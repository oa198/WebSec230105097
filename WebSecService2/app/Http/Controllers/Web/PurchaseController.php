<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index()
    {
        $purchases = auth()->user()->purchases()->with(['product', 'statusMessages'])->latest()->get();
        return view('purchases.list', compact('purchases'));
    }

    public function updateStatus(Request $request, Purchase $purchase)
    {
        if (!auth()->user()->hasPermissionTo('track_delivery')) {
            return back()->with('error', 'You do not have permission to update status.');
        }

        $request->validate([
            'status' => ['required', 'in:Pending,Shipped,Delivered'],
        ]);

        $purchase->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status updated successfully!');
    }

    public function addStatusMessage(Request $request, Purchase $purchase)
{
    if (!auth()->user()->hasPermissionTo('track_delivery')) {
        return back()->with('error', 'You do not have permission to add status messages.');
    }

    $request->validate([
        'message' => ['required', 'string', 'max:255'],
    ]);

    $purchase->statusMessages()->create([
        'message' => $request->message,
        'created_at' => now(),
    ]);

    return back()->with('success', 'Status message added successfully!');
}
}
