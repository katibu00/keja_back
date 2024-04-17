<?php
namespace App\Http\Controllers;

use App\Models\BrevoAPIKey;
use App\Models\Charges;
use App\Models\Contact;
use App\Models\ReservedAccount;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class RegisterController extends Controller
{

    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'phone' => 'required|string|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);
          
            if ($request->input('bvn_nin_select') === 'bvn') {
                $bvnValidation = $request->validate([
                    'bvn' => ['required', 'string', 'regex:/^\d{11}$/'],
                ]);
            
                $validatedData = array_merge($validatedData, $bvnValidation);
            } elseif ($request->input('bvn_nin_select') === 'nin') {
                $ninValidation = $request->validate([
                    'nin' => ['required', 'string', 'regex:/^\d{11}$/'],
                ]);
            
                $validatedData = array_merge($validatedData, $ninValidation);
            }
            $fullName = $validatedData['name'];
            $firstName = explode(' ', $fullName)[0];
            $randomString = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4);
            $username = $firstName . $randomString;

            $user = new User([
                'name' => $validatedData['name'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'username' => $username . $randomString,
                'password' => Hash::make($validatedData['password']),
                'referral_code' => User::generateReferralCode(),

            ]);

            $referralCode = $request->referral_code;
            if ($referralCode) {
                $referrer = User::where('referral_code', $referralCode)->first();
                if ($referrer) {
                    $user->referred_by = $referrer->id;
                }
            }

            $accessToken = $this->getAccessToken();

            $monnifyReservedAccount = $this->createMonnifyReservedAccount($user, $accessToken, $validatedData);

            $user->save();
            ReservedAccount::create([
                'user_id' => $user->id,
                'account_reference' => $monnifyReservedAccount->accountReference,
                'customer_email' => $monnifyReservedAccount->customerEmail,
                'customer_name' => $monnifyReservedAccount->customerName,
                'accounts' => json_encode($monnifyReservedAccount->accounts),
            ]);

            $welcome_bonus = Charges::select('welcome_bonus')->first();
            Wallet::create([
                'user_id' => $user->id,
                'balance' => $welcome_bonus->welcome_bonus,
            ]);

            $phoneNumber = $validatedData['phone'];
            $network = $this->determineNetwork($phoneNumber);
    
            Contact::create([
                'user_id' => $user->id,
                'name' => 'My Number',
                'number' => $phoneNumber,
                'network' => $network,
            ]);

            $this->sendWelcomeEmail($fullName, $validatedData['email']);


            DB::commit(); 
            return response()->json(['message' => 'User account created successfully']);
        } catch (\Exception $e) {
            DB::rollback(); 
            Log::error('Registration Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getAccessToken()
    {
        $monnifyKeys = DB::table('monnify_keys')->first();
        $apiKey = $monnifyKeys->public_key;
        $secretKey = $monnifyKeys->secret_key;

        $encodedKey = base64_encode($apiKey . ':' . $secretKey);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.monnify.com/api/v1/auth/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                "Authorization: Basic $encodedKey",
            ),
        ));

        $response = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new \Exception("cURL Error: " . $err);
        }

        if ($httpStatus !== 200) {
            throw new \Exception("Monnify API request failed. Error Response: " . $response);
        }

        $monnifyResponse = json_decode($response);

        if (!$monnifyResponse->requestSuccessful) {
            throw new \Exception($monnifyResponse->responseMessage);
        }

        return $monnifyResponse->responseBody->accessToken;
    }

    private function createMonnifyReservedAccount(User $user, $accessToken, $validatedData)
    {
        $accountReference = uniqid('abc', true);
        $accountName = $user->name;

        $monnifyKeys = DB::table('monnify_keys')->first();
        $contractCode = $monnifyKeys->contract_code;

        $currencyCode = 'NGN';
        $contractCode = $contractCode;
        $customerEmail = $user->email;
        $customerName = $user->name;
        $getAllAvailableBanks = true;

        $data = [
            'accountReference' => $accountReference,
            'accountName' => $accountName,
            'currencyCode' => $currencyCode,
            'contractCode' => $contractCode,
            'customerEmail' => $customerEmail,
            'customerName' => $customerName,
            'getAllAvailableBanks' => $getAllAvailableBanks,
            'bvn' => $validatedData['bvn'] ?? null,
            'nin' => $validatedData['nin'] ?? null,
        ];

        $jsonData = json_encode($data);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.monnify.com/api/v2/bank-transfer/reserved-accounts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $accessToken,
            ),
        ));

        $response = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new \Exception("cURL Error: " . $err);
        }

        if ($httpStatus !== 200) {
            throw new \Exception("Monnify API request failed. Error Response: " . $response);
        }

        $monnifyResponse = json_decode($response);

        if (!$monnifyResponse->requestSuccessful) {
            throw new \Exception($monnifyResponse->responseMessage);
        }

        return $monnifyResponse->responseBody;
    }


    private function determineNetwork($phoneNumber)
    {
        // Extract the first 4 digits of the phone number
        $prefix = substr($phoneNumber, 0, 4);

        // Determine the network based on the prefix
        switch ($prefix) {
            case '0803':
            case '0806':
            case '0703':
            case '0903':
            case '0906':
            case '0706':
            case '0813':
            case '0810':
            case '0814':
            case '0816':
            case '0913':
            case '0916':
                return 'MTN';
            case '0805':
            case '0705':
            case '0905':
            case '0807':
            case '0815':
            case '0811':
            case '0915':
                return 'GLO';
            case '0802':
            case '0902':
            case '0701':
            case '0808':
            case '0708':
            case '0812':
            case '0901':
            case '0907':
                return 'AIRTEL';
            case '0809':
            case '0909':
            case '0817':
            case '0818':
            case '0908':
                return '9MOBILE';
            default:
                return 'Unknown';
        }
    }

    private function sendWelcomeEmail($name, $email)
    {

        $apiKey = BrevoAPIKey::first()->api_key ?? '';

        $endpoint = 'https://api.brevo.com/v3/smtp/email';

        // Email data
        $senderName = 'Subnow NG';
        $senderEmail = 'support@subnow.ng';
        $recipientName = $name;
        $recipientEmail = $email;
        $subject = 'Welcome to Subnow.ng!';

        $htmlContent = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Welcome to Subnow.ng!</title>
            <style>
                /* Add your custom styles here */
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f7f7f7;
                    margin: 0;
                    padding: 0;
                    line-height: 1.6;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }
                .logo img {
                    max-width: 150px;
                    height: auto;
                }
                .social-media {
                    margin-top: 20px;
                }
                .social-media a {
                    display: inline-block;
                    margin-right: 10px;
                }
                .message {
                    margin-top: 30px;
                }
                .message p {
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="logo">
                    <img src="https://subnow.ng/uploads/logo.png" alt="Subnow Logo">
                </div>
                <div class="social-media">
                    <a href="https://facebook.com/chatdoc" target="_blank">Facebook</a>
                    <a href="https://twitter.com/chatdoc" target="_blank">Twitter</a>
                    <a href="https://instagram.com/chatdoc" target="_blank">Instagram</a>
                </div>
                <div class="message">
                    <p>Hello ' . $recipientName . ',</p>
                    <p>Welcome to Subnow, where you can get amazing deals on data and airtime.</p>
                    <p>Feel free to reach out to us on social media or reply to this email if you have any questions.</p>
                    <p>Best regards,<br>Your Subnow Team</p>
                </div>
            </div>
        </body>
        </html>';

        // Prepare the data payload
        $data = [
            'sender' => [
                'name' => $senderName,
                'email' => $senderEmail,
            ],
            'to' => [
                [
                    'email' => $recipientEmail,
                    'name' => $recipientName,
                ],
            ],
            'subject' => $subject,
            'htmlContent' => $htmlContent,
        ];

        // Send the HTTP request
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'api-key' => $apiKey,
            'content-type' => 'application/json',
        ])->post($endpoint, $data);       

    }


}
