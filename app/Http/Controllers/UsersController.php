<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FundingTransaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function regular()
    {
        $users = User::where('user_type', 'regular')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.regular.index', compact('users'));
    }
    public function admins()
    {
        $users = User::where('user_type', 'admin')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.admin.index', compact('users'));
    }

    public function manualFunding(Request $request)
    {
        $validatedData = $request->validate([
            'userId' => 'required|exists:users,id',
            'userName' => 'required',
            'amount' => 'required|numeric',
        ]);

        $user = User::find($validatedData['userId']);

        // Save the funding transaction
        $transactionReference = uniqid('TRX-');
        $paymentMethod = 'manual';
        $status = 'success';
        $notes = 'Manual funding transaction';

        $fundingTransaction = new FundingTransaction();
        $fundingTransaction->user_id = $user->id;
        $fundingTransaction->transaction_reference = $transactionReference;
        $fundingTransaction->amount = $validatedData['amount'];
        $fundingTransaction->payment_method = $paymentMethod;
        $fundingTransaction->status = $status;
        $fundingTransaction->notes = $notes;
        $fundingTransaction->save();

        if (!$user->wallet) {
            $wallet = new Wallet(['main_balance' => $validatedData['amount']]);
            $user->wallet()->save($wallet);
        } else {
            $user->wallet()->increment('main_balance', $validatedData['amount']);
        }

        return response()->json(['message' => 'Manual funding submitted successfully'], 200);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'userId' => 'required|exists:users,id',
            'newPassword' => 'required|min:6',
        ]);

        $user = User::find($request->input('userId'));
        $user->password = Hash::make($request->input('newPassword'));
        $user->save();

        // Return a response indicating success
        return response()->json(['message' => 'Password changed successfully'], 200);
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Perform any necessary checks or validations before deleting the user

        $user->delete();

        // You can optionally return a response indicating the success of the deletion
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'adminName' => 'required|string|max:255',
            'adminEmail' => 'required|email|unique:users,email',
            'adminPassword' => 'required|min:8',
            'adminPhone' => 'required|string|max:20',
        ]);

        $admin = new User();
        $admin->name = $request->input('adminName');
        $admin->email = $request->input('adminEmail');
        $admin->password = Hash::make($request->input('adminPassword'));
        $admin->phone = $request->input('adminPhone');
        $admin->user_type = 'admin';
        $admin->username = 'admin';

        $admin->save();

        return redirect()->route('admins.index')->with('success', 'New admin added successfully.');
    }
}
