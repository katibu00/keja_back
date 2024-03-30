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


  public function admin()
{
    // Get the total number of users
    $totalUsers = User::count();

    // Get the total wallet balance
    $totalWalletBalance = Wallet::sum('main_balance');

    // Calculate today's total funding
    $todayTotalFunding = FundingTransaction::whereDate('created_at', today())->sum('amount');
    $TotalFunding= FundingTransaction::sum('amount');

    // Calculate today's data purchase in GB
    $dataPurchases = PurchaseTransaction::where('purchase_type', 'data')
        ->whereDate('created_at', today())
        ->get();
    $totalDataPurchaseInGB = 0;
    foreach ($dataPurchases as $purchase) {
        $dataPlan = DataPlan::where('plan_id', $purchase->data_plan_id)->first();
        $totalDataPurchaseInGB += $dataPlan ? $this->decodeAmount($dataPlan->amount) : 0;
    }

    // Calculate today's airtime purchase
    $todayAirtimePurchase = PurchaseTransaction::where('purchase_type', 'airtime')
        ->whereDate('created_at', today())
        ->sum('data_plan_id');

    // Get regular users who registered today
    $newRegularUsers = User::whereDate('created_at', today())->where('user_type', 'regular')->get();

    // Pass the statistics to the view
    return view('admin.home', compact('totalUsers', 'totalWalletBalance', 'todayTotalFunding', 'TotalFunding','totalDataPurchaseInGB', 'todayAirtimePurchase', 'newRegularUsers'));
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
