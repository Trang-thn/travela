@include('clients.blocks.header')
@include('clients.blocks.banner')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>booking DienCode</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        /* Layout */
        .booking-container {
            max-width: 1200px;
            margin: auto;
            padding-top: 20px;
            display: flex;
            gap: 24px;
        }

        .booking-container {
            .booking__infor {
                background-color: #F6F8FA;
                display: grid;
                grid-template-columns: 1fr 1fr;
                border: none;
                gap: 16px;
                padding: 30px;
            }

            .booking-info {
                flex: 1;
            }

            .booking-summary {
                width: 400px;
            }

            /* Header */
            .booking-header {
                margin-bottom: 30px;
                font-size: 24px;
                font-weight: 700;
            }

            /* Form Styling */

            .booking__infor .form-group label {
                font-weight: 600;
                font-size: 1rem;
            }

            .booking__infor .form-group input {
                width: 100%;
                height: 56px;
                padding: 16px 17px;
                font-size: 1rem;
                border: 0px solid #E2E4E5;
                border-radius: 5px;
            }

            /* Quantity Selector */
            .booking__quantity {
                display: flex;
                gap: 24px;
            }

            .quantity-selector {
                width: 50%;
                display: flex;
                align-items: center;
                border: 1px solid #E2E4E5;
                padding: 20px;
                justify-content: space-between;
                gap: 48px;
            }

            .input__quanlity {
                display: flex;
                gap: 16px;
            }

            .quantity-btn {
                width: 30px;
                height: 30px;
                background-color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                font-weight: bold;
                border-radius: 5px;
                border: 2px solid #63AB45;
                color: #63AB45;
            }

            .quantity-input {
                padding: 0;
                width: 30px;
                text-align: center;
                border: none;
                font-size: 24px;
                line-height: 1;
                letter-spacing: 0em;
                font-weight: 500;
                color: #63AB45;
            }

            /* Payment Options */
            .payment-option {
                margin-bottom: 15px;
                padding: 15px;
                border: 1px solid #E2E4E5;
                border-radius: 5px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .payment-option img {
                width: 40px;
            }

            /* Privacy Agreement */
            .privacy-section {
                margin-top: 20px;
                margin-bottom: 20px;
                padding: 20px;
                background-color: #F9F9F9;
                border-radius: 5px;
                font-size: 1rem;
                color: #333;
                text-align: center;
            }

            .privacy-checkbox {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-top: 10px;
                justify-content: center;
            }

            /* Order Summary */
            .order-summary {
                border-top: 1px solid #D6D6D6;
                border-bottom: 1px solid #D6D6D6;
                margin-top: 20px;
                padding-top: 20px;
            }

            .summary-item {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
            }

            .total-price,
            .quantity_adults,
            .quantity_children {
                font-weight: bold;
                font-size: 1.2rem;
            }

            /* Button */
            .booking-btn {
                width: 100%;
                padding: 15px;
                background-color: #1b9cedda;
                color: white;
                font-weight: 700;
                font-size: 1.1rem;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .summary-section {
                padding: 16px;
                box-shadow: 10px 10px 36px rgba(0, 0, 0, 0.08);
                position: sticky;
                top: 50px;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .booking-container {
                flex-direction: column;
            }

            .booking-summary {
                width: 100%;
                margin-top: 20px;
            }

        }

        /* giam gia */
        .order-coupon {
            border-top: 1px solid white;
            margin-top: 20px;
            padding: 20px 0;
            display: flex;
            justify-content: space-between;
            gap: 8px;
            border-bottom: 1px solid white;
        }

        .order-coupon input {
            border: 2px solid rgb(175, 168, 168);
            border-radius: 8px;

        }

        .btn-submit-booking.inactive {
            background-color: #9adee9;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <section class="container" style="margin-top:50px">
        {{-- <h1 class="text-center booking-header">Tổng Quan Về Chuyến Đi</h1> --}}

        <form action="{{ route('create-booking') }}" method="POST" class="booking-container">
            @csrf
             <input type="hidden" name="tourId" value="{{ $tour_booked->tourId }}">
    <input type="hidden" name="userId" value="{{ auth()->id() }}">
    <input type="hidden" id="payment_hidden" name="payment_hidden" value="">
            <!-- Contact Information -->
            <div class="booking-info">
                <h2 class="booking-header">Thông Tin Liên Lạc</h2>
                <div class="booking__infor">
                    <div class="form-group">
                        <label for="username">Họ và tên*</label>
                        <input type="text" id="username" placeholder="Nhập Họ và tên" value="{{ $tour_booked->fullName }}" name="fullName" required>
                        <span id="usernameError" class="error-message" style="display:none;color:red"></span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email*</label>
                        <input type="email" id="email" placeholder="sample@gmail.com" value="{{ $tour_booked->email }}" name="email" required>
                        <span id="emailError" class="error-message" style="display:none;color:red"></span>
                    </div>

                    <div class="form-group">
                        <label for="tel">Số điện thoại*</label>
                        <input type="number" id="tel" placeholder="Nhập số điện thoại liên hệ" value="{{ $tour_booked->phoneNumber }}" name="tel"
                            required>
                        <span id="telError" class="error-message" style="display:none;color:red"></span>
                    </div>

                    <div class="form-group">
                        <label for="address">Địa chỉ*</label>
                        <input type="text" id="address" value="{{ $tour_booked->address }}" placeholder="Nhập địa chỉ liên hệ" name="address" required>
                        <span id="addressError" class="error-message " style="display:none;color:red"></span>
                    </div>
                </div>


                <!-- Passenger Details -->
                <h2 class="booking-header">Hành Khách</h2>

                <div class="booking__quantity">
                    <div class="form-group quantity-selector">
                        <label>Người lớn</label>
                        <div class="input__quanlity">
                            <button type="button" class="quantity-btn minus">-</button>
                            <input type="number" class="quantity-input" value="{{ $tour_booked->numAdults }}" min="1" id="numAdults"
                                name="numAdults" data-price-adults="100000" readonly>
                            <button type="button" class="quantity-btn plus">+</button>
                        </div>
                    </div>

                    <div class="form-group quantity-selector">
                        <label>Trẻ em</label>
                        <div class="input__quanlity">
                            <button type="button" class="quantity-btn minus">-</button>
                            <input type="number" class="quantity-input" value="{{ $tour_booked->numChildren }}" min="0" id="numChildren"
                                name="numChildren" data-price-children="50000" readonly>
                            <button type="button" class="quantity-btn plus">+</button>
                        </div>
                    </div>
                </div>
                <!-- Privacy Agreement Section -->
                <div class="privacy-section">
                    <p>Bằng cách nhấp chuột vào nút "ĐỒNG Ý" dưới đây, Khách hàng đồng ý rằng các điều kiện điều khoản
                        này sẽ được áp dụng. Vui lòng đọc kỹ điều kiện điều khoản trước khi lựa chọn sử dụng dịch vụ của
                        Lửa Việt Tours.</p>
                    <div class="privacy-checkbox">
                        <input type="checkbox" id="agree" name="agree"  checked disabled>
                        <label for="agree">Tôi đã đọc và đồng ý với <a href="#" target="_blank">Điều khoản
                                thanh
                                toán</a></label>
                    </div>
                </div>
                <!-- Payment Method -->
                <h2 class="booking-header">Phương Thức Thanh Toán</h2>

                <label class="payment-option">
                    <input type="radio" name="paymentMethod" value="office" {{ $tour_booked->paymentMethod === 'office' ? 'checked' : '' }} disabled>
                    <img src="{{ asset('assets/images/booking/cong-thanh-toan-paypal.jpg') }}" alt="Office Payment">
                    Thanh toán tại văn phòng
                </label>

                <label class="payment-option">
                    <input type="radio" name="paymentMethod" value="paypal"  {{ $tour_booked->paymentMethod === 'paypal' ? 'checked' : '' }} disabled>
                    <img src="{{ asset('assets/images/booking/cong-thanh-toan-paypal.jpg') }}" alt="PayPal">
                    Thanh toán bằng PayPal
                </label>

                <label class="payment-option">
                    <input type="radio" name="paymentMethod" value="momo"  {{ $tour_booked->paymentMethod === 'momo' ? 'checked' : '' }} disabled >
                    <img src="{{ asset('assets/images/booking/thanh-toan-momo.jpg') }}" alt="MoMo">
                    Thanh toán bằng Momo
                </label>


            </div>
                <!-- Order Summary -->
                <div class="booking-summary">
                    <div class="summary-section">
                        <p>Mã tour : {{ $tour_booked->tourId }}</p>
                        <h5 class="widget-tital">{{ $tour_booked->title}}</h5>
                        <p>Ngày khởi hành : {{ date('d-m-y', strtotime($tour_booked->startDate)) }}</p>
                        <p>Ngày kết thúc : {{ date('d-m-y', strtotime($tour_booked->endDate)) }}</p>
                        <p class="quantityAvailable">Số chỗ còn nhận tour : {{ $tour_booked->quantity }}</p>
                    </div>

                    <div class="order-summary">
                        <div class="summary-item">
                            <span>Người lớn:</span>
                            <div>
                                <span class="quantity_adults">{{ $tour_booked->numAdults }}</span>
                                <span>X</span>
                                <span class="total-price">{{ number_format($tour_booked->numAdults * $tour_booked->priceAdult) }} VNĐ</span>
                            </div>
                        </div>
                        <div class="summary-item">
                            <span>Trẻ em:</span>
                            <div>
                                <span class="quantity_children">{{ $tour_booked->numChildren }}</span>
                                <span>X</span>
                                <span class="total-price">{{ number_format($tour_booked->numChildren * $tour_booked->priceChild) }} VNĐ</span>
                            </div>
                        </div>
                        <div class="summary-item">
                            <span>Giảm giá:</span>
                            <div>
                                <span class="total-price">{{ number_format($tour_booked->discount ?? 0) }}VNĐ</span>
                            </div>
                        </div>
                        <div class="summary-item total-price">
                            <span>Tổng cộng:</span>
                            <span>{{ number_format($tour_booked->totalPrice) }} VNĐ</span>
                            <input type="hidden" class="totalPrice" name="totalPrice" value="">
                        </div>
                    </div>

                    {{-- <div class="order-coupon">
                        <input type="text" class="order-coupon-input" placeholder="Mã giảm giá"
                            style="width:65%;">
                        <button style="width: 30%" class="booking-btn btn-coupon">Áp dụng</button>
                    </div>

                    <!-- Chọn phương thức thanh toán -->
                    <div class="payment-method">
                        <label>
                            <input type="hidden" name="paymentMethod" value="paypal">
                        </label>
                        <label>
                            <input type="hidden" name="paymentMethod" value="momo"> 
                        </label>
                    </div> --}}

                    <!-- PayPal button -->
                    {{-- <div id="paypal-button-container" style="display:none;"></div> --}}

                    <!-- Submit / Momo -->
                    <input type="hidden" name="bookingId" value="{{ $bookingId }}">
                    @if($tour_booked->bookingStatus=='f')
                    <a href="{{ route("tour-detail",['id'=>$tour_booked->tourId]) }}" class="booking-btn" stype="display:inline-block; text-align:center;">
                        Đánh giá</a>
                        @else
                    <button type="submit" class="booking-btn btn-cancel-booking {{ $hide }}">Hủy tour</button>
                    @endif
                    {{-- <button id="btn-momo-payment" class="booking-btn" style="display:none;"
                        data-urlmomo="{{ route('createMomoPayment') }}">
                        Thanh toán với Momo
                        <img src="{{ asset('assets/images/booking/icon-thanh-toan-momo.jpg') }}" alt="Momo">
                    </button> --}}
                </div>

            {{-- <button type="submit" class="booking-btn btn-submit-booking inactive">Xác Nhận và Thanh Toán</button> --}}
            </div>
            </div>
        </form>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/custom-js.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @yield('content')

    <!-- JS toastr -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Hiển thị thông báo từ session -->
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>


</body>

</html>

{{-- @section('content')
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
            {{-- <form action="{{ route('cancel-booking') }}" method="POST">
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
@endsection --}} 

@include('clients.blocks.footer')