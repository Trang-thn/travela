// booking
let discount = 0;
let totalPrice = 0;
function updateSummary() {
    //lay so luong nguoi lon va tre em;
    const numAdults = parseInt($("#numAdults").val());
}
$(document).ready(function () {
    let discount = 0; // giá trị giảm giá mặc định

    // Hàm cập nhật tổng tiền
    function updateSummary() {
        const numAdults = parseInt($("#numAdults").val());
        const numChildren = parseInt($("#numChildren").val());

        const adultPrice = parseInt($("#numAdults").data("price-adults"));
        const childPrice = parseInt($("#numChildren").data("price-children"));

        const adultTotal = numAdults * adultPrice;
        const childrenTotal = numChildren * childPrice;

        // Cập nhật hiển thị
        $(".quantity_adults").text(numAdults);
        $(".quantity_children").text(numChildren);
        $(".summary-item:nth-child(1) .total-price").text(adultTotal.toLocaleString() + " VND");
        $(".summary-item:nth-child(2) .total-price").text(childrenTotal.toLocaleString() + " VND");
        //tong gia
        totalPrice = adultTotal + childrenTotal - discount;
        $(".summary-item.total-price span:last").text(totalPrice.toLocaleString() + " VND");
    }



    // Sự kiện tăng/giảm số lượng
    $(".quantity-selector").on("click", ".quantity-btn", function () {
        const input = $(this).siblings("input");
        const min = parseInt(input.attr("min"));
        let value = parseInt(input.val());

        if ($(this).text() === "+") {
            value++;
        } else if (value > min) {
            value--;
        }

        input.val(value);
        updateSummary();
    });

    // Áp dụng mã giảm giá
    $(".btn-coupon").on("click", function () {
        const couponCode = $(".order-coupon-input").val().trim();

        if (couponCode === "DISCOUNT10") {
            discount = 0.1 * (parseInt($("#numAdults").val()) * $("#numAdults").data("price-adults") +
                parseInt($("#numChildren").val()) * $("#numChildren").data("price-children"));
            alert("Áp dụng mã giảm giá thành công!");
        } else {
            discount = 0;
            alert("Mã giảm giá không hợp lệ!");
        }
        $(".summary-item:nth-child(3) .total-price").text(
            discount.toLocaleString() + " VND"
        );


        updateSummary();
    });

    // Sự kiện khi thay đổi trạng thái checkbox
    $("#agree").on("change", function () {
        toggleButtonState();
    });

    // Hàm thay đổi trạng thái của nút
    function toggleButtonState() {
        if ($("#agree").is(":checked")) {
            $(".btn-submit-booking")
                .removeClass("inactive")
                .css("pointer-events", "auto");
        } else {
            $(".btn-submit-booking")
                .addClass("inactive")
                .css("pointer-events", "none");
        }
    }
    $(".btn-submit-booking").on("click", function (e) {
        e.preventDefault(); // chặn submit mặc định để kiểm tra trước
        const numAdults = parseInt($("#numAdults").val());
        const numChildren = parseInt($("#numChildren").val());
        let isValid = true;

        // Ẩn tất cả thông báo lỗi trước khi kiểm tra
        $(".error-message").hide();

        // Kiểm tra họ và tên (không được để trống)
        const username = $("#username").val().trim();
        if (!username) {
            $("#usernameError").text("Họ và tên không được để trống").show();
            isValid = false;
        }

        // Kiểm tra email (phải đúng định dạng)
        const email = $("#email").val().trim();
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (!email) {
            $("#emailError").text("Email không được để trống").show();
            isValid = false;
        } else if (!emailPattern.test(email)) {
            $("#emailError").text("Email không đúng định dạng").show();
            isValid = false;
        }

        // Kiểm tra số điện thoại (phải là số và từ 10-11 ký tự)
        const tel = $("#tel").val().trim();
        const telPattern = /^[0-9]{10,11}$/;
        if (!tel) {
            $("#telError").text("Số điện thoại không được để trống").show();
            isValid = false;
        } else if (!telPattern.test(tel)) {
            $("#telError").text("Số điện thoại phải có từ 10-11 chữ số").show();
            isValid = false;
        }

        // Kiểm tra địa chỉ (không được để trống)
        const address = $("#address").val().trim();
        if (!address) {
            $("#addressError").text("Địa chỉ không được để trống").show();
            isValid = false;
        }
        const paymentMethod = $('input[name="payment"]:checked').val();
        if (!paymentMethod) {
            alert("Vui lòng chọn phương thức thanh toán");
            isValid = false;
        }
        // Nếu tất cả đều hợp lệ, gửi form
        if (isValid) {
            formDataBooking = {
                'fullName': username,
                'email': email,
                'tel': tel,
                'address': address,
                'numAdults': numAdults,
                'numChildren': numChildren,
                'totalPrice': totalPrice,
                '__token': $('input[name="token"]').val()

            }
            console.log(formDataBooking)
            $.ajax({
                type: "POST",
                url: $(this).attr("action"), // lấy action từ form 
                data: formDataBooking,
                success: function (response) {
                    // if (response.success) {
                    //     // Thành công -> chuyển hướng về trang chủ hoặc trang cảm ơn 
                    //     window.location.href = "/";
                    // } else { // Có lỗi từ server -> hiện thông báo 
                    //     toastr.error(response.message);
                    // }
                },
                error: function (xhr, textStatus, errorThrown) {
                    toastr.error("Có lỗi xảy ra. Vui lòng thử lại sau.");
                },
            });
        }
    });


    // Khởi tạo tổng giá khi trang vừa tải
    updateSummary();
    toggleButtonState();

});

