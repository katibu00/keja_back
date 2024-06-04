<?php

namespace App\Http\Controllers;

use App\Models\ReservedAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email_or_phone' => 'required',
            'password' => 'required',
        ]);

        $credentials = $this->getCredentials($request);
        $rememberMe = $request->filled('remember_me');

        try {
            if (Auth::attempt($credentials, $rememberMe)) {
                if ($request->ajax()) {
                    return response()->json(['success' => true, 'redirect_url' => $this->getRedirectUrl()]);
                } else {
                    return redirect()->route($this->getRedirectRoute());
                }
            } else {
                throw ValidationException::withMessages([
                    'login_error' => 'Invalid credentials.',
                ]);
            }
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $e->errors()], 422);
            } else {
                return redirect()->back()->withErrors($e->errors())->withInput()->with('error_message', 'Invalid credentials.');
            }
        }
    }




    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email_or_phone' => 'required',
    //         'password' => 'required',
    //     ]);

    //     $credentials = $this->getCredentials($request);
    //     $rememberMe = $request->filled('remember_me');

    //     try {
    //         if (Auth::attempt($credentials, $rememberMe)) {
    //             $user = Auth::user();

    //             $reservedAccount = ReservedAccount::where('customer_email', $user->email)->first();
                
    //             // Check if the user has a reserved account
    //             if (!$reservedAccount) {
    //                 // Create reserved account for the user
    //                 $accessToken = $this->getAccessToken();
    //                 $monnifyReservedAccount = $this->createMonnifyReservedAccount($user, $accessToken, [
    //                     'name' => $user->name, // You may need to adjust this depending on the data needed
    //                     'phone' => $user->phone, // You may need to adjust this depending on the data needed
    //                     'email' => $user->email, // You may need to adjust this depending on the data needed
    //                 ]);

    //                 ReservedAccount::create([
    //                     'user_id' => $user->id,
    //                     'account_reference' => $monnifyReservedAccount->accountReference,
    //                     'customer_email' => $monnifyReservedAccount->customerEmail,
    //                     'customer_name' => $monnifyReservedAccount->customerName,
    //                     'accounts' => json_encode($monnifyReservedAccount->accounts),
    //                 ]);
    //             }

    //             if ($request->ajax()) {
    //                 return response()->json(['success' => true, 'redirect_url' => $this->getRedirectUrl()]);
    //             } else {
    //                 return redirect()->route($this->getRedirectRoute());
    //             }
    //         } else {
    //             throw ValidationException::withMessages([
    //                 'login_error' => 'Invalid credentials.',
    //             ]);
    //         }
    //     } catch (ValidationException $e) {
    //         if ($request->ajax()) {
    //             return response()->json(['success' => false, 'errors' => $e->errors()], 422);
    //         } else {
    //             return redirect()->back()->withErrors($e->errors())->withInput()->with('error_message', 'Invalid credentials.');
    //         }
    //     }
    // }



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


    protected function getCredentials(Request $request)
    {
        $field = filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        return [
            $field => $request->email_or_phone,
            'password' => $request->password,
        ];
    }

    protected function getRedirectRoute()
    {
        $userType = auth()->user()->user_type;

        return $userType === 'admin' ? 'admin.home' : 'regular.home';
    }

    protected function getRedirectUrl()
    {
        return route($this->getRedirectRoute());
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

}
