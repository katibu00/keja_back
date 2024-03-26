<?php

namespace App\Http\Controllers;

use App\Models\FundingTransaction;
use App\Models\PaystackAPIKey;
use App\Models\ReservedAccount;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $query = ReservedAccount::where('customer_email', auth()->user()->email)->first();

        if ($query) {
            $accounts = json_decode($query->accounts, true);
        } else {
            $accounts = [];
        }
        $publicKey = PaystackAPIKey::first()->public_key ?? '';
        return view('pages.wallet', compact('accounts','publicKey'));
    }




    public function creditWallet(Request $request)
    {
        $reference = $request->input('reference');
        $url = 'https://api.paystack.co/transaction/verify/' . $reference;
        
        $secretKey = PaystackAPIKey::first()->secret_key ?? '';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '. $secretKey
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response);

        if ($result->status && $result->data->status == 'success') {
            // Credit the customer's wallet here
            $user_id = $result->data->metadata->user_id;
            $amount = $result->data->amount / 100;
            
            $user = User::find($user_id);
            
            if ($user) {
                // Check if the user has a wallet
                if ($user->wallet) {
                    // Update the wallet balance
                    $wallet = $user->wallet;
                    $wallet->main_balance += $amount;
                    $wallet->save();
                } else {
                    // Create a new wallet for the user if it doesn't exist
                    $wallet = new Wallet(['main_balance' => $amount]);
                    $user->wallet()->save($wallet);
                }
                
                // Add the transaction to the funding_transactions table
                $transaction = new FundingTransaction([
                    'user_id' => $user_id,
                    'transaction_reference' => $reference,
                    'amount' => $amount,
                    'payment_method' => 'paystack',
                    'status' => 'success',
                ]);
            
                // Check if the user is funding their account for the first time
                if (!$user->fundingTransactions()->where('status', 'success')->exists()) {
                    // Check if the user was referred by someone
                    if ($user->referred_by != null) {
                        // Reward the referrer with bonus balance
                        // dd($user->referred_by);
                        $referrer = User::find($user->referred_by);
                        if ($referrer) {
                            $bonusAmount = 50; // Adjust the bonus amount as needed
                            if ($referrer->wallet) {
                                // Update the bonus balance
                                $referrer->wallet->bonus_balance += $bonusAmount;
                                $referrer->wallet->save();
                            } else {
                                // Create a new wallet for the referrer if it doesn't exist
                                $bonusWallet = new Wallet(['bonus_balance' => $bonusAmount]);
                                $referrer->wallet()->save($bonusWallet);
                            }
                        }
                    }
                }
                $transaction->save();

                return response()->json(['success' => 'Wallet has been credited.']);

            } else {
                return response()->json(['error' => 'Error Occurred.']);
            }
        } else {
            return response()->json(['error' => 'Transaction was not successful.']);
        }
    }

}
