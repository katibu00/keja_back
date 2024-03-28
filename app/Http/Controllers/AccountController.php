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
    
        $dataPurchases = PurchaseTransaction::where('user_id', $user->id)
                            ->where('created_at', '>=', Carbon::now()->subDays(15)->startOfDay())
                            ->where('created_at', '<=', Carbon::now()->endOfDay())
                            ->get();
    
        $dataPurchasesByDay = [];
    
        foreach ($dataPurchases as $purchase) {
            if(isset($purchase->data_plan)) {
                $date = $purchase->created_at->toDateString(); 
                $dataAmount = str_replace(['MB', 'GB'], ['', '*1024'], $purchase->data_plan->amount);
                eval('$dataAmount = '.$dataAmount.';');
                $dataPurchasesByDay[$date] = isset($dataPurchasesByDay[$date]) ? $dataPurchasesByDay[$date] + $dataAmount : $dataAmount;
            }
        }        
    
        $chartData = [];
        foreach (range(14, 0) as $i) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $chartData[] = isset($dataPurchasesByDay[$date]) ? round($dataPurchasesByDay[$date] / 1024, 2) : 0; 
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
