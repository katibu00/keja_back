<?php

namespace App\Http\Controllers;

use App\Models\PlanProvider;
use Illuminate\Http\Request;

class PlanProviderController extends Controller
{
    public function index()
    {
        $planProviders = PlanProvider::all();
        return view('admin.plan-providers.index', compact('planProviders'));
    }

    public function activate(PlanProvider $planProvider)
    {
        $planProvider->active = true;
        $planProvider->save();

        return redirect()->route('plan-providers.index')->with('success', 'Plan provider activated successfully.');
    }
}

