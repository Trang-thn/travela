$(document).ready(function () {
    let discount = 0;
    let totalPrice = 0;

    function updateSummary() {
        const numAdults = parseInt($("#numAdults").val());
        const numChildren = parseInt($("#numChildren").val());

        const adultPrice = parseInt($("#numAdults").data("price-adults"));
        const childPrice = parseInt($("#numChildren").data("price-children"));

        const adultTotal = numAdults * adultPrice;
        const childrenTotal = numChildren * childPrice;

        $(".quantity_adults").text(numAdults);
        $(".quantity_children").text(numChildren);
        $(".summary-item:nth-child(1) .total-price").text(adultTotal.toLocaleString() + " VND");
        $(".summary-item:nth-child(2) .total-price").text(childrenTotal.toLocaleString() + " VND");

        totalPrice = adultTotal + childrenTotal - discount;
        $(".summary-item.total-price span:last").text(totalPrice.toLocaleString() + " VND");
        $("input[name='totalPrice']").val(totalPrice);
    }
    $(".quantity-selector").on("click", ".quantity-btn", function () {
        // tìm input nằm cùng khối với nút vừa bấm
        const input = $(this).siblings(".quantity-input");

        const min = parseInt(input.attr("min"));
        let value = parseInt(input.val());

        const quantityAvailable = parseInt($(".quantityAvailable").text().match(/\d+/)[0]);

        const totalAdults = parseInt($("#numAdults").val());
        const totalChildren = parseInt($("#numChildren").val());

        if ($(this).hasClass("plus")) {
            if (input.attr("id") === "numAdults") {
                if (totalAdults + totalChildren < quantityAvailable) {
                    value++;
                } else {
                    toastr.error("Không thể thêm số người lớn vượt quá số chỗ còn nhận!");
                }
            } else if (input.attr("id") === "numChildren") {
                if (totalAdults + totalChildren < quantityAvailable) {
                    value++;
                } else {
                    toastr.error("Không thể thêm số trẻ em vượt quá số chỗ còn nhận!");
                }
            }
        } else if ($(this).hasClass("minus") && value > min) {
            value--;
        }

        // cập nhật lại input
        input.val(value);
        updateSummary();
    });
    // Áp dụng mã giảm giá
    $(".btn-coupon").on("click", function () {
        const couponCode = $(".order-coupon-input").val().trim();
        if (couponCode === "DISCOUNT10") {
            discount = 0.1 * ($("#numAdults").val() * $("#numAdults").data("price-adults") +
                $("#numChildren").val() * $("#numChildren").data("price-children"));
            toastr.success("Áp dụng mã giảm giá thành công!");
        } else {
            discount = 0;
            toastr.error("Mã giảm giá không hợp lệ!");
        }
$(".summary-item:nth-child(3) .total-price").text(discount.toLocaleString() + " VND");
        updateSummary();
    });

    // Checkbox đồng ý điều khoản
    $("#agree").on("change", function () {
        if ($(this).is(":checked")) {
            $(".btn-submit-booking").removeClass("inactive").css("pointer-events", "auto");
        } else {
            $(".btn-submit-booking").addClass("inactive").css("pointer-events", "none");
        }
    });
    //kiểm tra dl trống


    // Chọn phương thức thanh toán
    $("input[name='paymentMethod']").change(function () {
        const method = $(this).val();
        $("#payment_hidden").val(method);

        const isPaymentSelected = method === "paypal" || method === "momo";
        $(".btn-submit-booking").toggle(!isPaymentSelected);

        if (method === "paypal") {
            $("#paypal-button-container").show();
            var totalPricePayment = totalPrice / 25000;
            paypal.Buttons({
                createOrder: (data, actions) => actions.order.create({
                    purchase_units: [{ amount: { value: totalPricePayment.toFixed(2) } }]
                }),
                onApprove: (data, actions) => actions.order.capture().then(details => {
                    $("<input>", {
                        type: "hidden",
                        name: "transactionIdPayPal",
                        value: details.id,
                    }).appendTo(".booking-container");
                    toastr.success("Thanh toán thành công!");

                    // đảm bảo paymentMethod = paypal
                    $("input[name='paymentMethod'][value='paypal']").prop("checked", true);

                    $(".booking-container").submit();
                }),

                onError: err => {
                    toastr.error("Có lỗi xảy ra trong quá trình thanh toán!");
                    console.error(err);
                }
            }).render("#paypal-button-container");

        } else {
            $("#paypal-button-container").empty();
        }
// $("input[name='paymentMethod']").change(function () {
//     const method = $(this).val();

    if (method === "momo") {
        $("#btn-momo-payment").show();   // chỉ hiện nút
    } else {
        $("#btn-momo-payment").hide();   // ẩn nút
    }
});

$("#btn-momo-payment").on("click", function(e) {
    e.preventDefault();
    // đổi action của form sang route MoMo
    $(".booking-container").attr("action", $(this).data("urlmomo"));
    // submit form
    $(".booking-container").submit();
});



    //     if (method === "momo") {
    //         $("#btn-momo-payment").show();
    //         $(".booking-container-momo").submit();
    //     } else {
    //         $("#btn-momo-payment").hide();
    //     }
    // });

    // Submit form
    $(".btn-submit-booking").on("click", function (e) {
        e.preventDefault();
let isValid = true;

        $(".error-message").hide().text("");

        if (!$("#username").val().trim()) {
            $("#usernameError").text("Họ và tên không được để trống").show();
            isValid = false;
        }
        const email = $("#email").val().trim();
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (!email || !emailPattern.test(email)) {
            $("#emailError").text("Email không hợp lệ").show();
            isValid = false;
        }
        const tel = $("#tel").val().trim();
        const telPattern = /^[0-9]{10,11}$/;
        if (!tel || !telPattern.test(tel)) {
            $("#telError").text("Số điện thoại phải có từ 10-11 chữ số").show();
            isValid = false;
        }
        if (!$("#address").val().trim()) {
            $("#addressError").text("Địa chỉ không được để trống").show();
            isValid = false;
        }
        if (!$("#agree").is(":checked")) {
            toastr.error("Bạn phải đồng ý với điều khoản trước khi đặt tour!");
            isValid = false;
        }
        if (!$("input[name='paymentMethod']:checked").val()) {
            toastr.error("Bạn phải chọn phương thức thanh toán!");
            isValid = false;
        }

        if (isValid) {
            $(".booking-container").submit();
        }
    });

    // Khởi tạo
    updateSummary();
    // handle login
    $('#sign-up').click(function() {
        $('.sign-in').hide();
        $('.signup').show();
    });
    $('#sign-in').click(function() {
        $('.signup').hide();
        $('.sign-in').show();
    });
//icon
    userDropdown.addEventListener("click", function() {
    dropdownMenu.classList.toggle("show");
});

    //handle form submission
    $('#login-form').on('submit', function(e) {
        e.preventDefault();
        var username = $('#username_login').val().trim();
        var password = $('#password_login').val().trim();

        //noi dung thong bao loi va an di
        $('#validate_username').hide().text('');
        $('#validate_password').hide().text('');
        var isValid = true;

        //kiem tra do dai mat khau
        if(password.length < 6) {
            isValid = false;
            $('#validate_password').show().text('Mật khẩu phải có ít nhất 6 ký tự.');
        }
        //kiem tra ten dang nhap va mat khau khong chua ki tu dac biet (sql injection)
        var sqlInjectionPattern = /[%&()+'";<>]/;
        if(sqlInjectionPattern.test(username)) {
            isValid = false;
            $('#validate_username').show().text('Tên đăng nhập chứa ký tự đặc biệt không hợp lệ.');
        }
        if(sqlInjectionPattern.test(password)) {
            isValid = false;
            $('#validate_password').show().text('Mật khẩu chứa ký tự đặc biệt không hợp lệ.');
        }

        if(isValid) {
            // this.submit();
}
    });

    //Handle signup form submission
    $('#signup-form').on('submit', function(e) {
        e.preventDefault();
        //lay gia tri tu form
        var userName = $('#username_regester').val().trim();
        var email = $('#email_regester').val().trim();
        var password = $('#password_regester').val().trim();
        var rePass = $('#re_pass').val().trim();

        //noi dung thong bao loi va an di
        $('#validate_username_regis').hide().text('');
        $('#validate_email_regis').hide().text('');
        $('#validate_password_regis').hide().text('');
        $('#validate_repass').hide().text('');

        var isValid = true;

        //kiem tra ten dang nhap khong chua ki tu dac biet (sql injection)
        var sqlInjectionPattern = /[%&()+'";<>]/;
        if(sqlInjectionPattern.test(userName)) {
            isValid = false;
            $('#validate_username_regis').show().text('Tên tài khoản chứa ký tự đặc biệt không hợp lệ.');
        }
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(!emailPattern.test(email)) {
            isValid = false;
            $('#validate_email_regis').show().text('Địa chỉ email không hợp lệ.');
        }
        if(password.length < 6) {
            isValid = false;
            $('#validate_password_regis').show().text('Mật khẩu phải có ít nhất 6 ký tự.');
        }
        if(sqlInjectionPattern.test(password)) {
            isValid = false;
            $('#validate_password_regis').show().text('Mật khẩu chứa ký tự đặc biệt không hợp lệ.');
        }
        if(password !== rePass) {
            isValid = false;
            $('#validate_repass').show().text('Mật khẩu nhập lại không khớp.');
        }

        if(isValid) {
            // this.submit();
        }
    });
});
