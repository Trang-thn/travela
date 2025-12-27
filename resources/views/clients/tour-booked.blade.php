@include('clients.blocks.header')
@include('clients.blocks.banner')
@include('clients.booking')
@section('content')
<section class="container" style="margin-top:50px">
    <h2 class="booking-header">Thông tin tour đã đặt</h2>

    <div class="booking-container">
        <div class="booking-info">
            <h3>Thông tin liên lạc</h3>
            <p>Họ tên: {{ $tour_booked->fullName }}</p>
            <p>Email: {{ $tour_booked->email }}</p>
            <p>Số điện thoại: {{ $tour_booked->phoneNumber }}</p>
            <p>Địa chỉ: {{ $tour_booked->address }}</p>

            <h3>Hành khách</h3>
            <p>Người lớn: {{ $tour_booked->numAdults }}</p>
            <p>Trẻ em: {{ $tour_booked->numChildren }}</p>
        </div>

        <div class="booking-summary">
            <div class="summary-section">
                <p>Mã tour : {{ $tour_booked->tourId }}</p>
                <h5>{{ $tour_booked->title }}</h5>
                <p>Ngày khởi hành : {{ date('d-m-Y', strtotime($tour_booked->startDate)) }}</p>
                <p>Ngày kết thúc : {{ date('d-m-Y', strtotime($tour_booked->endDate)) }}</p>
                <p>Số chỗ còn nhận tour : {{ $tour_booked->quantity }}</p>
            </div>

            <div class="order-summary">
                <div class="summary-item">
                    <span>Người lớn:</span>
                    <span>{{ $tour_booked->numAdults }} x {{ number_format($tour_booked->priceAdult) }} VND</span>
                </div>
                <div class="summary-item">
                    <span>Trẻ em:</span>
                    <span>{{ $tour_booked->numChildren }} x {{ number_format($tour_booked->priceChild) }} VND</span>
                </div>
                <div class="summary-item">
                    <span>Tổng cộng:</span>
                    <span>{{ number_format($tour_booked->totalPrice) }} VND</span>
                </div>
                <div class="summary-item">
                    <span>Phương thức thanh toán:</span>
                    <span>{{ $tour_booked->paymentMethod }}</span>
                </div>
            </div>

            {{-- Nút hủy tour --}}
            <form action="{{ route('cancel-booking') }}" method="POST">
                @csrf
                <input type="hidden" name="bookingId" value="{{ $bookingId }}">
                <input type="hidden" name="tourId" value="{{ $tour_booked->tourId }}">
                <input type="hidden" name="numAdults" value="{{ $tour_booked->numAdults }}">
                <input type="hidden" name="numChildren" value="{{ $tour_booked->numChildren }}">

                <button type="submit" class="booking-btn btn-danger {{ $hide }}">
                    Hủy tour
                    @if($tour_booked->paymentMethod === 'paypal')
                        (PayPal)
                    @elseif($tour_booked->paymentMethod === 'momo')
                        (Momo)
                    @endif
                </button>
            </form>
        </div>
    </div>
</section>
@endsection

@include('clients.blocks.footer')