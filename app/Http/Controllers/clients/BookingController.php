<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\clients\Tours;
use App\Models\clients\Booking;
use App\Models\clients\Checkout;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private $tour;
    private $booking;
    private $checkout;

    public function __construct(Tours $tour, Booking $booking, Checkout $checkout)
    {
        $this->tour = new Tours();
        $this->booking = new Booking;
        $this->checkout = new Checkout;
    }

    public function index($id)
    {
        $title = 'Đặt Tour';
        $tour = $this->tour->getTourDetail($id);

        return view('clients.booking', compact('title', 'tour'));
    }

    public function createBooking(Request $req)
    {
        // Chặn nếu chưa chọn phương thức thanh toán
        $address       = $req->input('address');
        $email         = $req->input('email');
        $fullName      = $req->input('fullName');
        $numAdults     = $req->input('numAdults');
        $numChildren   = $req->input('numChildren');
        $paymentMethod = $req->input('paymentMethod'); // sửa lại cho khớp với radio
        $tel           = $req->input('tel');
        $totalPrice    = $req->input('totalPrice');
        $tourId        = $req->input('tourId');
        $userId        = $req->input('userId');

        // Booking
        $dataBooking = [
            'tourId'      => $tourId,
            'userId'      => $userId,
            'address'     => $address,
            'fullName'    => $fullName,
            'email'       => $email,
            'numAdults'   => $numAdults,
            'numChildren' => $numChildren,
            'phoneNumber' => $tel,
            'totalPrice'  => $totalPrice,
        ];
        $bookingId = $this->booking->createBooking($dataBooking);

        // Checkout
        $dataCheckout = [
            'bookingId'     => $bookingId,
            'paymentMethod' => $paymentMethod,
            'amount'        => $totalPrice,
            'paymentStatus' => ($paymentMethod === 'paypal' || $paymentMethod === 'momo') ? 'y' : 'n',
            'transactionId' => '' // mặc định rỗng
        ];

        if ($paymentMethod === 'paypal') {
            $dataCheckout['transactionId'] = $req->transactionIdPayPal;
        } elseif ($paymentMethod === 'momo') {
            $dataCheckout['transactionId'] = $req->transactionIdMomo;
        }


        $checkoutId = $this->checkout->createCheckout($dataCheckout);

        if (empty($bookingId) || empty($checkoutId)) {
            return redirect()->back()->with('error', 'Có vấn đề khi đặt tour');
        }

        // Cập nhật số lượng chỗ còn lại
        $tour = $this->tour->getTourDetail($tourId);
        $dataUpdate = [
            'quantity' => $tour->quantity - ($numAdults + $numChildren),
        ];
        $this->tour->updateTours($tourId, $dataUpdate);

        // Chuyển sang giao diện tour-booked
        return redirect()->route('tour-booked', [
            'bookingId'  => $bookingId,
            'checkoutId' => $checkoutId,
        ])->with('success', 'Đặt tour thành công');
    }
    
    
}
