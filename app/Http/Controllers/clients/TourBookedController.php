<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\clients\Tours;
use App\Models\clients\Booking;
use App\Models\clients\Checkout;

class TourBookedController extends Controller
{
    private $tour;
    private $booking;
    private $checkout;

    public function __construct(Tours $tour, Booking $booking, Checkout $checkout)
    {
        $this->tour = $tour;
        $this->booking = $booking;
        $this->checkout = $checkout;
    }

    public function index(Request $req)
    {
        $title = "Tour đã đặt";

        $bookingId  = $req->input('bookingId');
        $checkoutId = $req->input('checkoutId');

        $tour_booked = $this->tour->tourBooked($bookingId, $checkoutId);

        if ($tour_booked && $tour_booked->startDate) {
            $today = Carbon::now();
            $startDate = Carbon::parse($tour_booked->startDate);
            $diffInDays = $startDate->diffInDays($today);
            $hide = $diffInDays < 7 ? 'hide' : '';
        } else {
            $hide = '';
        }

        return view("clients.tour-booked", compact('title', 'tour_booked', 'hide', 'bookingId', 'checkoutId'));
    }

    public function cancelBooking(Request $req)
    {
        $tourId        = $req->input('tourId');
        $quantityAdults   = (int) $req->input('numAdults');
        $quantityChildren = (int) $req->input('numChildren');
        $bookingId     = $req->input('bookingId');

        // Cập nhật lại số lượng tour
        $tour = $this->tour->getTourDetail($tourId);
        if ($tour) {
            $newQuantity = $tour->quantity + $quantityAdults + $quantityChildren;
            $this->tour->updateTours($tourId, ['quantity' => $newQuantity]);
        }

        // Cập nhật trạng thái thay vì xóa
        $this->booking->updateBookingStatus($bookingId, 'C'); // Cancelled
        $this->checkout->updateCheckoutStatusByBookingId($bookingId, 'cancelled');

        return redirect()->route('home')->with('success', 'Hủy tour thành công!');
    }
}
