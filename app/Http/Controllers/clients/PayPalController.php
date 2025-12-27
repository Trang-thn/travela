<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\clients\Checkout;

class PayPalController extends Controller
{
    /**
     * Tạo giao dịch PayPal
     */
    public function createTransaction(Request $request)
    {
        $checkout = new Checkout();
        $checkoutId = $checkout->createCheckout([
            'bookingId'     => $request->bookingId,
            'paymentMethod' => 'paypal',
            'amount'        => $request->amount,
            'paymentStatus' => 'pending',
        ]);

        return response()->json([
            'checkoutId' => $checkoutId,
            'message'    => 'Transaction created, redirect to PayPal...',
        ]);
    }

    /**
     * Xử lý giao dịch PayPal sau khi người dùng xác nhận
     */
    public function processTransaction(Request $request)
    {
        $transactionId = $request->transactionId;

        $checkout = new Checkout();
        $checkout->updateCheckoutStatusByBookingId($request->bookingId, 'processing');

        // Lưu transactionId
        Checkout::where('bookingId', $request->bookingId)
            ->update(['transactionId' => $transactionId]);

        return response()->json([
            'message' => 'Transaction is being processed',
        ]);
    }

    /**
     * Thanh toán thành công
     */
    public function successTransaction(Request $request)
    {
        Checkout::where('bookingId', $request->bookingId)
            ->update(['paymentStatus' => 'paid']);

        return redirect()->route('tour-booked', [
            'bookingId'  => $request->bookingId,
            'checkoutId' => $request->checkoutId,
        ])->with('success', 'Thanh toán PayPal thành công!');
    }

    /**
     * Hủy giao dịch
     */
    public function cancelTransaction(Request $request)
    {
        Checkout::where('bookingId', $request->bookingId)
            ->update(['paymentStatus' => 'cancelled']);

        return redirect()->route('booking', ['id' => $request->bookingId])
            ->with('error', 'Thanh toán PayPal đã bị hủy!');
    }
}
