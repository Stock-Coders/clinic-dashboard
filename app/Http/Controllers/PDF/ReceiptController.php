<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
// use App\Models\Receipt;
// use App\Http\Requests\ReceiptRequest;
use App\Models\Payment;

class ReceiptController extends Controller
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
