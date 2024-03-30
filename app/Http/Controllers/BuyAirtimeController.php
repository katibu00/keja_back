<?php

namespace App\Http\Controllers;

use App\Models\Charges;
use App\Models\Contact;
use App\Models\DataPlan;
use App\Models\PlanProvider;
use App\Models\PurchaseTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BuyAirtimeController extends Controller
{
    public function index()
    {
        $firstRowCharges = Charges::first();
        $bonusPer100 = $firstRowCharges ? $firstRowCharges->bonus_per_gb : null;

        return view('pages.buy_airtime', compact('bonusPer100'));
    }

    public function fetchPlans(Request $request)
    {
        $networkId = $request->input('networkId');
        
        $activePlanProviderId = PlanProvider::where('active', true)->value('id');

        $dataPlans = DataPlan::where('network_name', $networkId)
                            ->where('provider_id', $activePlanProviderId)
                            ->where('plan_type', 'airtime')
                            ->get();

        $contacts = Contact::where('network', $networkId)
                            ->where('user_id', auth()->user()->id)
                            ->get();

        return response()->json(['dataPlans' => $dataPlans, 'contacts' => $contacts]);
    }



    public function buyAirtime(Request $request)
    {
        // dd($request->all());
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'network' => 'required|in:MTN,GLO,AIRTEL,9MOBILE',
            'plan_id' => 'required',
            // Add more validation rules as needed
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
            ]);
        }
    
        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'status' => 400,
                'message' => 'You are not logged in.',
            ]);
        }
    
        // Check if the user has sufficient funds in their wallet
        $user = auth()->user();
        $walletBalance = $user->wallet->main_balance;
        if ($walletBalance < $request->selectedPlanPrice) {
            return response()->json([
                'status' => 400,
                'message' => 'Insufficient funds. Please add funds to your wallet.',
            ]);
        }
    
        // Get the currently active plan provider
        $activePlanProvider = PlanProvider::where('active', true)->first();
    
        if (!$activePlanProvider) {
            return response()->json([
                'status' => 400,
                'message' => 'No active plan provider found.',
            ]);
        }
    
        // Call the appropriate private function based on the active plan provider
        switch ($activePlanProvider->name) {
            case 'GladTidings':
                return $this->buyAirtimeFromGladTidings($request);
                break;
            case 'Ogiedata':
                return $this->buyDataFromOgiedata($activePlanProvider, $request);
                break;
            case 'SMData':
                return $this->buyDataFromSMData($activePlanProvider, $request);
                break;
            default:
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid active plan provider.',
                ]);
        }
    }
    

    private function buyAirtimeFromGladTidings($request)
    {
        $networkName = $request->network;
        $networkId = '';

        $selectedPlanPrice = $request->selectedPlanPrice;
        $integerPrice = intval($selectedPlanPrice);        

        if ($networkName === 'MTN') {
            $networkId = 1;
        } else if ($networkName === 'GLO') {
            $networkId = 2;
        } else if ($networkName === 'AIRTEL') {
            $networkId = 3;
        } else if ($networkName === '9MOBILE') {
            $networkId = 6;
        } else {
            $networkId = null;
        }

        $number = ($request->contact == 'new') ? $request->number : $request->selectedContactNumber;

        $jsonData = json_encode([
            "network" => $networkId,
            "amount" => $integerPrice,
            "mobile_number" => $number,
            "Ported_number" => true,
            "airtime_type" => "VTU",
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.gladtidingsdata.com/api/topup/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Token b549be14f63f4087e6a5a85dfb03942ec658f27b',
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

         $responseData = json_decode($response); 


         if (isset($responseData) && $responseData !== null && $responseData->Status === "successful") {
            
            $user = auth()->user();
            $user->wallet->decrement('main_balance', $request->selectedPlanPrice);

            $this->saveTransaction($request, $user->id);

            $updatedMainBalance = $user->fresh()->wallet->main_balance;
            $updatedBonusBalance = $user->fresh()->wallet->bonus_balance;

            /////////

            // $dataPlan = DataPlan::where('plan_id', $request->plan_id)->first();

            // if (!$dataPlan) {
            //     return response()->json([
            //         'status' => 400,
            //         'message' => 'Data plan not found.',
            //     ]);
            // }

            // $planAmount = strtolower($dataPlan->amount);
            // $firstRowCharges = Charges::first();
            // $bonusPerGB = $firstRowCharges ? $firstRowCharges->bonus_per_gb : null;

            
            // $bonus = 0;
            // if (strpos($planAmount, 'gb') !== false) {
            //     // Plan amount is in GB
            //     $amount = (float) str_replace('gb', '', $planAmount);
            //     $bonus = $amount * $bonusPerGB;
            // } elseif (strpos($planAmount, 'mb') !== false) {
            //     // Plan amount is in MB
            //     $amount = (float) str_replace('mb', '', $planAmount);
            //     $bonus = $amount * ($bonusPerGB / 1000); // Convert MB to GB for bonus calculation
            // }

            // $user = auth()->user();
            // $user->wallet->bonus_balance += $bonus;
            // $user->wallet->save();

            ///////

            if (isset($responseData->api_response)) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Your airtime purchase was successful. Your account has been credited with ' . $integerPrice . '. Thank you for choosing Subnow NG.',
                    'new_wallet_balance' => $updatedMainBalance,
                    'new_bonus_balance' => $updatedBonusBalance,
                ]);
                
            } else {
                return response()->json([
                    'status' => 400, 
                    'message' => 'An error occurred. Please contact our team on WhatsApp for assistance.',
                    'new_wallet_balance' => $updatedMainBalance,
                    'new_bonus_balance' => $updatedBonusBalance,
                ]);
            }

        } else {
            
            if ($responseData !== null && isset($responseData->error[0])) {
                $errorMessage = $responseData->error[0];
                return response()->json([
                    'status' => 400,
                    'message' => $errorMessage,
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Unknown error occurred. Please contact admin on WhatsApp.',
                ]);
            }
            
            
            
        }
    
    }


    private function saveTransaction($request, $userId)
    {
        $transactionReference = uniqid('TRX-');
        $purchaseType = 'airtime';
        $plan_id = $request->plan_id;
        $paymentMethod = 'wallet';
        $status = 'success';
        $notes = 'Airtime purchase transaction';

        PurchaseTransaction::create([
            'user_id' => $userId,
            'transaction_reference' => $transactionReference,
            'purchase_type' => $purchaseType,
            'data_plan_id' => $plan_id,
            'payment_method' => $paymentMethod,
            'status' => $status,
            'notes' => $notes,
        ]);
    }
}
