<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\DataPlan;
use App\Models\PlanProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DataPlansController extends Controller
{
    function index(){
        $data['dataPlans'] = DataPlan::all(); 
        $data['PlanProviders'] = PlanProvider::all(); 
        return view('data_plans.index',$data);
    }


    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'network' => 'required|string',
            'data_plan_type' => 'required|string',
            'provider' => 'required|string',
            'plan_id.*' => 'required|string',
            'amount.*' => 'required|string',
            'buying_price.*' => 'required|numeric',
            'selling_price.*' => 'required|numeric',
            'validity.*' => 'required|string',
            'order_number.*' => 'required|integer',
        ]);

        // If validation fails, return the errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Begin a transaction
        DB::beginTransaction();

        try {
            // Loop through the dynamic fields and create data for each row
            foreach ($request->plan_id as $index => $planId) {
                // Create a new data plan for each row
                DataPlan::create([
                    'network_name' => $request->network,
                    'plan_id' => $planId,
                    'amount' => $request->amount[$index],
                    'buying_price' => $request->buying_price[$index],
                    'selling_price' => $request->selling_price[$index],
                    'validity' => $request->validity[$index],
                    'plan_type' => $request->data_plan_type,
                    'order_number' => $request->order_number[$index],
                    'provider_id' => $request->provider,
                    'active' => true, // Assuming the plan is active by default
                ]);
            }

            // Commit the transaction
            DB::commit();

            // If all goes well, return success response
            return response()->json(['message' => 'Data plans saved successfully'], 200);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollback();
            
            // Return error response
            return response()->json(['error' => 'Failed to save data plans. Error: ' . $e->getMessage()], 500);
        }
    }


   
    public function fetchPlans(Request $request)
    {
        $networkId = $request->input('networkId');
        
        $activePlanProviderId = PlanProvider::where('active', true)->value('id');

        $dataPlans = DataPlan::where('network_name', $networkId)
                            ->where('provider_id', $activePlanProviderId)
                            ->get();

        $contacts = Contact::where('network', $networkId)
                            ->where('user_id', auth()->user()->id)
                            ->get();

        return response()->json(['dataPlans' => $dataPlans, 'contacts' => $contacts]);
    }

 
    public function edit($id)
    {
        $dataPlan = DataPlan::findOrFail($id);
        return view('data_plans.edit', compact('dataPlan'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'network_name' => 'required',
            'plan_id' => 'required',
            'provider_id' => 'required',
            'buying_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'validity' => 'required',
            'plan_type' => 'required',
            'order_number' => 'required|integer',
            'active' => 'nullable|string',
        ]);

        $dataPlan = DataPlan::findOrFail($id);
        $dataPlan->network_name = $request->input('network_name');
        $dataPlan->plan_id = $request->input('plan_id');
        $dataPlan->provider_id = $request->input('provider_id');
        $dataPlan->buying_price = $request->input('buying_price');
        $dataPlan->selling_price = $request->input('selling_price');
        $dataPlan->validity = $request->input('validity');
        $dataPlan->plan_type = $request->input('plan_type');
        $dataPlan->order_number = $request->input('order_number');
        $dataPlan->active = $request->has('active'); // Convert to boolean

        $dataPlan->save();

        return redirect()->route('data-plans.index')->with('success', 'Data plan updated successfully.');
    }

    public function destroy($id)
    {
        $dataPlan = DataPlan::findOrFail($id);
        $dataPlan->delete();

        return redirect()->route('data-plans.index')->with('success', 'Data plan deleted successfully.');
    }


    public function pricingIndex()
    {
        $networkColors = [
            'mtn' => 'yellow',
            'glo' => 'green',
            '9mobile' => 'darkgreen',
            'airtel' => 'red',
        ];

        $dataPlans = DataPlan::where('active', true)
            ->orderBy('network_name')
            ->get()
            ->groupBy('network_name');

        $dataPlans = $dataPlans->map(function ($plans, $networkName) use ($networkColors) {
            $networkName = strtolower($networkName); // Convert network name to lowercase
            $color = isset($networkColors[$networkName]) ? $networkColors[$networkName] : 'gray'; // Default to gray if not found
            return [
                'networkName' => $networkName,
                'plans' => $plans,
                'color' => $color,
            ];
        });

        return view('pages.pricing_plans', compact('dataPlans'));
    }


}
