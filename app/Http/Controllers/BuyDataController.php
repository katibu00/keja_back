<?php

namespace App\Http\Controllers;

use App\Models\Charges;
use App\Models\DataPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PlanProvider;
use App\Models\PurchaseTransaction;
use Illuminate\Support\Facades\Validator;

class BuyDataController extends Controller
{
   
    public function buyData(Request $request)
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
                return $this->buyDataFromGladTidings($request);
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
    
    public function recentTransactions()
    {
        $user = auth()->user();
        $transactions = PurchaseTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.recent_transactions', ['transactions' => $transactions]);
    }


    private function buyDataFromGladTidings($request)
    {
        $networkName = $request->network;
        $networkId = '';

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
            "mobile_number" => $number,
            "plan" => $request->plan_id,
            "Ported_number" => true,
            "payment_medium" => "MAIN WALLET",
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.gladtidingsdata.com/api/data/',
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

         if (isset($responseData->error)) {
            $errorMessage = $responseData->error[0];
            return response()->json([
                'status' => 400,
                'message' => 'Unknown error occured. Pls contact admin on WhatsApp.',
            ]);
        } else {
            $user = auth()->user();
            $user->wallet->decrement('main_balance', $request->selectedPlanPrice);

            $this->saveTransaction($request, $user->id);

            $updatedMainBalance = $user->fresh()->wallet->main_balance;
            $updatedBonusBalance = $user->fresh()->wallet->bonus_balance;

            /////////

            $dataPlan = DataPlan::where('plan_id', $request->plan_id)->first();

            if (!$dataPlan) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Data plan not found.',
                ]);
            }

            $planAmount = strtolower($dataPlan->amount);
            $firstRowCharges = Charges::first();
            $bonusPerGB = $firstRowCharges ? $firstRowCharges->bonus_per_gb : null;

            
            $bonus = 0;
            if (strpos($planAmount, 'gb') !== false) {
                // Plan amount is in GB
                $amount = (float) str_replace('gb', '', $planAmount);
                $bonus = $amount * $bonusPerGB;
            } elseif (strpos($planAmount, 'mb') !== false) {
                // Plan amount is in MB
                $amount = (float) str_replace('mb', '', $planAmount);
                $bonus = $amount * ($bonusPerGB / 1000); // Convert MB to GB for bonus calculation
            }

            $user = auth()->user();
            $user->wallet->bonus_balance += $bonus;
            $user->wallet->save();

            ///////

            return response()->json([
                'status' => 200,
                'message' => $responseData->api_response,
                'new_wallet_balance' => $updatedMainBalance,
                'new_bonus_balance' => $updatedBonusBalance,
            ]);
        }
    
    }


    private function saveTransaction($request, $userId)
    {
        $transactionReference = uniqid('TRX-');
        $purchaseType = 'data';
        $plan_id = $request->plan_id;
        $paymentMethod = 'wallet';
        $status = 'success';
        $notes = 'Data purchase transaction';

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
