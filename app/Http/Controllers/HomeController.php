<?php

namespace App\Http\Controllers;

use App\Models\Charges;
use App\Models\DataPlan;
use App\Models\FundingTransaction;
use App\Models\MarqueeNotification;
use App\Models\PopUp;
use App\Models\PurchaseTransaction;
use App\Models\ReservedAccount;
use App\Models\User;
use App\Models\Wallet;

class HomeController extends Controller
{
    public function regular()
    {
        $query = ReservedAccount::where('customer_email', auth()->user()->email)->first();
        $accounts = $query ? json_decode($query->accounts, true) : [];

        $popUp = PopUp::where('switch', 'on')->first();

        $firstRowCharges = Charges::first();
        $bonusPerGB = $firstRowCharges ? $firstRowCharges->bonus_per_gb : null;
        $funding_charges_description = $firstRowCharges ? $firstRowCharges->funding_charges_description : null;

        $marqueeNotification = MarqueeNotification::first();

        return view('home.regular', compact('accounts', 'popUp', 'funding_charges_description', 'bonusPerGB', 'marqueeNotification'));
    }


    // public function admin()
    // {
    //     $totalUsers = User::count();
    //     $registeredToday = User::whereDate('created_at', today())->count();

    //     $totalWalletBalance = Wallet::sum('main_balance');

    //     $todayTotalFunding = FundingTransaction::whereDate('created_at', today())->sum('amount');
    //     $TotalFunding= FundingTransaction::sum('amount');

    //     $dataPurchases = PurchaseTransaction::where('purchase_type', 'data')
    //         ->whereDate('created_at', today())
    //         ->get();
    //     $totalDataPurchaseInGB = 0;
    //     foreach ($dataPurchases as $purchase) {
    //         $dataPlan = DataPlan::where('plan_id', $purchase->data_plan_id)->first();
    //         $totalDataPurchaseInGB += $dataPlan ? $this->decodeAmount($dataPlan->amount) : 0;
    //     }

    //     $todayAirtimePurchase = PurchaseTransaction::where('purchase_type', 'airtime')
    //         ->whereDate('created_at', today())
    //         ->sum('data_plan_id');

    //     $newRegularUsers = User::whereDate('created_at', today())->where('user_type', 'regular')->get();

    //     return view('admin.home', compact('totalUsers','registeredToday', 'totalWalletBalance', 'todayTotalFunding', 'TotalFunding','totalDataPurchaseInGB', 'todayAirtimePurchase', 'newRegularUsers'));
    // }


    // private function decodeAmount($amount)
    // {
    //     preg_match('/\d+/', $amount, $matches);
    //     if (!empty($matches)) {
    //         $value = intval($matches[0]);

    //         if (strpos($amount, 'GB') !== false) {
    //             return $value;
    //         } elseif (strpos($amount, 'MB') !== false) {
    //             return $value / 1000;
    //         }
    //     }
    //     return false;
    // }



    public function admin()
{
    $totalUsers = User::count();
    $registeredToday = User::whereDate('created_at', today())->count();

    $totalWalletBalance = Wallet::sum('main_balance');

    $todayTotalFunding = FundingTransaction::whereDate('created_at', today())->sum('amount');
    $TotalFunding = FundingTransaction::sum('amount');

    $dataPurchases = PurchaseTransaction::where('purchase_type', 'data')
        ->whereDate('created_at', today())
        ->get();
    $totalDataPurchaseInGB = 0;
    foreach ($dataPurchases as $purchase) {
        $dataPlan = DataPlan::where('plan_id', $purchase->data_plan_id)->first();
        $totalDataPurchaseInGB += $dataPlan ? $this->decodeAmount($dataPlan->amount) : 0;
    }

    $todayAirtimePurchase = PurchaseTransaction::where('purchase_type', 'airtime')
        ->whereDate('created_at', today())
        ->sum('data_plan_id');

    $newRegularUsers = User::whereDate('created_at', today())->where('user_type', 'regular')->get();

    // Data for the graphs
    $dates = [];
    $userRegistrations = [];
    $dataPurchasesInGB = [];
    $fundingTransactions = [];

    for ($i = 0; $i < 15; $i++) {
        $date = today()->subDays($i)->toDateString();
        $dates[] = $date;
        $userRegistrations[] = User::whereDate('created_at', $date)->count();

        $dailyDataPurchases = PurchaseTransaction::where('purchase_type', 'data')
            ->whereDate('created_at', $date)
            ->get();
        $dailyDataPurchaseInGB = 0;
        foreach ($dailyDataPurchases as $purchase) {
            $dataPlan = DataPlan::where('plan_id', $purchase->data_plan_id)->first();
            $dailyDataPurchaseInGB += $dataPlan ? $this->decodeAmount($dataPlan->amount) : 0;
        }
        $dataPurchasesInGB[] = $dailyDataPurchaseInGB;

        $fundingTransactions[] = FundingTransaction::whereDate('created_at', $date)->sum('amount');
    }

    $dates = array_reverse($dates);
    $userRegistrations = array_reverse($userRegistrations);
    $dataPurchasesInGB = array_reverse($dataPurchasesInGB);
    $fundingTransactions = array_reverse($fundingTransactions);

    return view('admin.home', compact(
        'totalUsers',
        'registeredToday',
        'totalWalletBalance',
        'todayTotalFunding',
        'TotalFunding',
        'totalDataPurchaseInGB',
        'todayAirtimePurchase',
        'newRegularUsers',
        'dates',
        'userRegistrations',
        'dataPurchasesInGB',
        'fundingTransactions'
    ));
}

private function decodeAmount($amount)
{
    preg_match('/\d+/', $amount, $matches);
    if (!empty($matches)) {
        $value = intval($matches[0]);

        if (strpos($amount, 'GB') !== false) {
            return $value;
        } elseif (strpos($amount, 'MB') !== false) {
            return $value / 1000;
        }
    }
    return false;
}


}
