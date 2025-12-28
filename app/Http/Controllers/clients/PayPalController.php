<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\clients\Checkout;
use App\Models\clients\Booking;
use Illuminate\Support\Facades\Auth;

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
    // Hàm gọi API MoMo private 
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Length: ' . strlen($data)]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    /** * Tạo giao dịch MoMo */
    public function createMomoPayment(Request $request)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        // 1. Tạo booking 
        $orderId = time()."";
        $booking = Booking::create([
            'tourId' => $request->tourId, 
            'userId' => Auth::id(), 
            'fullName' => $request->fullName, 
            'email' => $request->email, 
            'phoneNumber' => $request->tel, 
            'address' => $request->address, 
            'bookingDate' => now(), 
            'numAdults' => $request->numAdults, 
            'numChildren' => $request->numChildren, 
            'totalPrice' => $request->totalPrice, 
            'bookingStatus' => 'n',
            'momoOrderId' => $orderId,
        ]);
        // 2. Tạo checkout 
        $checkout = new Checkout();
        $checkoutId = $checkout->createCheckout([
            'bookingId' => $booking->bookingId, 
            'paymentMethod' => 'momo', 
            'amount' => $request->totalPrice, 
            'paymentStatus' => 'y',]); // 3. Chuẩn bị dữ liệu gửi MoMo 
        $orderId = time() . "";
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $request->totalPrice;
        $requestId = time() . "";
        $requestType = "payWithATM";
        $extraData = "";
        $redirectUrl = route('tour-booked', ['bookingId' => $booking->bookingId, 'checkoutId' => $checkoutId,]);
        $ipnUrl = route('momoIpn');
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = ['partnerCode' => $partnerCode, 'partnerName' => "Test", 'storeId' => "MomoTestStore", 'requestId' => $requestId, 'amount' => $amount, 'orderId' => $orderId, 'orderInfo' => $orderInfo, 'redirectUrl' => $redirectUrl, 'ipnUrl' => $ipnUrl, 'lang' => 'vi', 'extraData' => $extraData, 'requestType' => $requestType, 'signature' => $signature];
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);
        return redirect()->away($jsonResult['payUrl']);
    }
    /** * IPN callback từ MoMo */
    public function momoIpn(Request $request)
{
    $data = $request->all();

    if ($data['resultCode'] == 0) {
        $booking = Booking::where('bookingId', $data['orderId'])->first();
        if ($booking) {
            $booking->bookingStatus = 'paid';
            $booking->save();

            // cập nhật số lượng tour
            $tour = \App\Models\clients\Tours::find($booking->tourId);
            if ($tour) {
                $newQuantity = $tour->quantity - ($booking->numAdults + $booking->numChildren);
                $tour->update(['quantity' => $newQuantity]);
            }
        }
    } else {
        Booking::where('bookingId', $data['orderId'])->update(['bookingStatus' => 'failed']);
    }

    return response()->json(['message' => 'IPN received']);
}

    /** * Redirect khi thanh toán thành công */
   public function momoSuccess(Request $request)
{
    $booking = Booking::find($request->bookingId);
    if ($booking) {
        Checkout::where('checkoutId', $request->checkoutId)->update(['paymentStatus' => 'paid']);
        $booking->update(['bookingStatus' => 'paid']);

        // cập nhật số lượng tour
        $tour = \App\Models\clients\Tours::find($booking->tourId);
        if ($tour) {
            $newQuantity = $tour->quantity - ($booking->numAdults + $booking->numChildren);
            $tour->update(['quantity' => $newQuantity]);
        }
    }

    return redirect()->route('tour-booked', [
        'bookingId'  => $request->bookingId,
        'checkoutId' => $request->checkoutId,
    ])->with('success', 'Thanh toán MoMo thành công!');
}


}
