<?php

namespace App\Http\Controllers;

use App\Models\PurchaseTransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AccountController extends Controller
{

    public function index()
    {
        $user = auth()->user();
    
        // Query data purchases for the last 15 days
        $dataPurchases = PurchaseTransaction::where('user_id', $user->id)
                            ->where('created_at', '>=', Carbon::now()->subDays(15)->startOfDay())
                            ->where('created_at', '<=', Carbon::now()->endOfDay())
                            ->get();
    
        // Initialize an array to store data purchases for each day
        $dataPurchasesByDay = [];
    
        // Loop through each purchase to calculate total data purchased each day in GB
        foreach ($dataPurchases as $purchase) {
            // dd($purchase->data_plan->amount);
            $date = $purchase->created_at->toDateString(); // Get the date of the purchase
            $dataAmount = str_replace(['MB', 'GB'], ['', '*1024'], $purchase->data_plan->amount); // Convert amount to MB
            eval('$dataAmount = '.$dataAmount.';'); // Evaluate the expression (e.g., 100*1024 for 100MB)
            $dataPurchasesByDay[$date] = isset($dataPurchasesByDay[$date]) ? $dataPurchasesByDay[$date] + $dataAmount : $dataAmount;
        }
    
        // Prepare the data for the chart
        $chartData = [];
        foreach (range(14, 0) as $i) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $chartData[] = isset($dataPurchasesByDay[$date]) ? round($dataPurchasesByDay[$date] / 1024, 2) : 0; // Convert to GB
        }
    
        return view('pages.account', compact('chartData'));
    }
    

    public function switchAccount(Request $request)
    {
        $user = auth()->user();
        $user->update(['account_type' => $request->account_type]);

        return redirect()->back()->with('success', 'Account type switched successfully.');
    }
}
