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
use Carbon\Carbon;

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
    //     $TotalFunding = FundingTransaction::sum('amount');

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

    //     $startDate = Carbon::now()->subDays(15);
    //     $endDate = Carbon::now();

    //     // Data for the last 15 days
    //     $dataPurchasesLast15Days = PurchaseTransaction::where('purchase_type', 'data')
    //         ->whereBetween('created_at', [$startDate, $endDate])
    //         ->get();

    //     $dataPurchasesByDate = $dataPurchasesLast15Days->groupBy(function ($purchase) {
    //         return $purchase->created_at->format('Y-m-d');
    //     });

    //     $dates = [];
    //     $totalDataPurchaseInGB = [];

    //     foreach ($dataPurchasesByDate as $date => $purchases) {
    //         $dates[] = $date;
    //         $totalPurchase = 0;
    //         foreach ($purchases as $purchase) {
    //             $dataPlan = DataPlan::where('plan_id', $purchase->data_plan_id)->first();
    //             if ($dataPlan) {
    //                 $totalPurchase += $this->decodeAmount($dataPlan->amount);
    //             }
    //         }
    //         $totalDataPurchaseInGB[] = $totalPurchase;
    //     }

    //     $fundingLast15Days = FundingTransaction::whereBetween('created_at', [$startDate, $endDate])
    //         ->groupBy('date')
    //         ->orderBy('date')
    //         ->get([
    //             \DB::raw('DATE(created_at) as date'),
    //             \DB::raw('SUM(amount) as total_amount'),
    //         ]);

    //     $registrationsLast15Days = User::whereBetween('created_at', [$startDate, $endDate])
    //         ->groupBy('date')
    //         ->orderBy('date')
    //         ->get([
    //             \DB::raw('DATE(created_at) as date'),
    //             \DB::raw('COUNT(id) as total_users'),
    //         ]);

    //     // Prepare data for Chart.js
    //     $dates = [];
    //     $dataPurchases = [];
    //     $funding = [];
    //     $registrations = [];

    //     foreach ($dataPurchasesLast15Days as $dataPurchase) {
    //         $dates[] = $dataPurchase->date;
    //         $dataPurchases[] = $dataPurchase->total_amount;
    //     }

    //     foreach ($fundingLast15Days as $fund) {
    //         $funding[] = $fund->total_amount;
    //     }

    //     foreach ($registrationsLast15Days as $registration) {
    //         $registrations[] = $registration->total_users;
    //     }

    //     return view('admin.home', compact('totalUsers', 'registeredToday', 'totalWalletBalance', 'todayTotalFunding', 'TotalFunding', 'totalDataPurchaseInGB', 'todayAirtimePurchase', 'newRegularUsers', 'dates', 'dataPurchases', 'funding', 'registrations'));
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

    $startDate = Carbon::now()->subDays(15);
    $endDate = Carbon::now();

    // Data for the last 15 days
    $dataPurchasesLast15Days = PurchaseTransaction::where('purchase_type', 'data')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->get();

    $dataPurchasesByDate = $dataPurchasesLast15Days->groupBy(function ($purchase) {
        return $purchase->created_at->format('Y-m-d');
    });

    $dates = [];
    $totalDataPurchaseInGB = [];

    foreach ($dataPurchasesByDate as $date => $purchases) {
        $dates[] = $date;
        $totalPurchase = 0;
        foreach ($purchases as $purchase) {
            $dataPlan = DataPlan::where('plan_id', $purchase->data_plan_id)->first();
            if ($dataPlan) {
                $totalPurchase += $this->decodeAmount($dataPlan->amount);
            }
        }
        $totalDataPurchaseInGB[] = $totalPurchase;
    }

    $fundingLast15Days = FundingTransaction::whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('date')
        ->orderBy('date')
        ->get([
            \DB::raw('DATE(created_at) as date'),
            \DB::raw('SUM(amount) as total_amount'),
        ]);

    $registrationsLast15Days = User::whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('date')
        ->orderBy('date')
        ->get([
            \DB::raw('DATE(created_at) as date'),
            \DB::raw('COUNT(id) as total_users'),
        ]);

    // Prepare data for Chart.js
    $dates = [];
    $dataPurchases = [];
    $funding = [];
    $registrations = [];

    foreach ($dataPurchasesLast15Days as $dataPurchase) {
        $dates[] = $dataPurchase->date;
        $dataPurchases[] = $dataPurchase->total_amount;
    }

    foreach ($fundingLast15Days as $fund) {
        $funding[] = $fund->total_amount;
    }

    foreach ($registrationsLast15Days as $registration) {
        $registrations[] = $registration->total_users;
    }

    return view('admin.home', compact('totalUsers', 'registeredToday', 'totalWalletBalance', 'todayTotalFunding', 'TotalFunding', 'totalDataPurchaseInGB', 'todayAirtimePurchase', 'newRegularUsers', 'dates', 'dataPurchases', 'funding', 'registrations'));
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
