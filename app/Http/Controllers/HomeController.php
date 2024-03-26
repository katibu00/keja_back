<?php

namespace App\Http\Controllers;

use App\Models\Charges;
use App\Models\MarqueeNotification;
use App\Models\MonnifyTransfer;
use App\Models\PopUp;
use Illuminate\Http\Request;
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

        return view('home.regular', compact('accounts', 'popUp', 'funding_charges_description','bonusPerGB', 'marqueeNotification'));
    }


    public function admin()
    {
        // Get the required statistics
        $totalUsers = User::count();
        $totalWalletBalance = Wallet::sum('main_balance');
        $totalFundings = MonnifyTransfer::sum('amount_paid');
    
    
        // Calculate the number of new users (registered within the last 30 days)
        $newUsers = User::where('created_at', '>=', Carbon::now()->subDays(3))->count();
    
        // Pass the statistics to the view
        return view('admin.home', compact('totalUsers', 'totalWalletBalance', 'totalFundings', 'newUsers'));

    }
}
