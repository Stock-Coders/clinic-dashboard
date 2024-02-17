<?php

namespace App\Http\Controllers;

// use App\Models\Receipt;
// use App\Http\Requests\ReceiptRequest;
use App\Models\Payment;

class DashboardReceiptController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::with('xrays')->findOrFail($id);
        return view('dashboard.receipts.pdf.show', compact('payment'));
    }
}
