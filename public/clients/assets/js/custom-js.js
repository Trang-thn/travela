$(document).ready(function() {
    // handle login
    $('#sign-up').click(function() {
        $('.sign-in').hide();
        $('.signup').show();
    });
    $('#sign-in').click(function() {
        $('.signup').hide();
        $('.sign-in').show();
    });



    $('#message').hide();
    $('#error').hide();
    $('#error_login').hide();

    //handle form submission
    $('#login-form').on('submit', function(e) {
        e.preventDefault();
        var username = $('#your_name').val().trim();
        var password = $('#your_pass').val().trim();

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
            var formData = {
            'username': username,
            'password': password,
            '_token'        : $('input[name="_token"]').val()
            };

            console.log(formData);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                success: function(response) {
                    if(response.success) {
                        window.location.href = "/";
                    } else {
                        $('#error_login').show().text(response.message);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert('Có lỗi xảy ra!');
                }
            });
        }
    });

    //Handle signup form submission
    $('#register-form').on('submit', function(e) {
        e.preventDefault();
        //lay gia tri tu form
        var userName = $('#name').val().trim();
        var email = $('#email').val().trim();
        var password = $('#pass').val().trim();
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
            var formData = {
            'username_regis': userName,
            'email'         : email,
            'password_regis': password,
            '_token'        : $('input[name="_token"]').val()
        };
        console.log(formData);
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            success: function(response) {
                if(response.success) {
                    $('#message').show().text(response.message);
                    $('#error').hide();
                    //reset form
                    $('#register-form').trigger('reset');
                } else {
                    $('#error').show().text(response.message);
                    $('#message').hide();
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                alert('Có lỗi xảy ra!');
            }
        });
        }
    });

    //  USER PROFILE
    $(".updateUser").on("submit", function (e) {
        e.preventDefault();
        var fullName = $("#inputFullName").val();
        var address = $("#inputLocation").val();
        var email = $("#inputEmailAddress").val();
        var phone = $("#inputPhone").val();

        var dataUpdate = {
            'fullName'  : fullName,
            'address'   : address,
            'email'     : email,
            'phone'     : phone,
            '_token'    : $('input[name="_token"]').val()
        }
        console.log(dataUpdate);

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: dataUpdate,
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, textStatus, errorThrown) {
                alert('Có lỗi xảy ra khi cập nhật thông tin!');
            },
        });
    });

    $('#update_password_profile').click( function () {
        $("#card_change_password").toggle();
    });


    //change password
    $(".change_password_profile").on("submit", function (e) {
        e.preventDefault();
        var oldPass = $("#inputOldPass").val();
        var newPass = $("#inputNewPass").val();
        var isValid = true;
        var sqlInjectionPattern = /[%&()+'";<>]/;
        if(oldPass.length < 6 || newPass.length < 6) {
            isValid = false;
            $('#validate_password').show().text('Mật khẩu phải có ít nhất 6 ký tự.');
        }
        if(sqlInjectionPattern.test(newPass)) {
            isValid = false;
            $('#validate_password').show().text('Mật khẩu chứa ký tự đặc biệt không hợp lệ.');
        }

        if(isValid) {
            $('#validate_password').hide().text('');
            var updataPass = {
            'oldPass'  : oldPass,
            'newPass'   : newPass,
            '_token'    : $('input[name="_token"]').val()
            }
            console.log(updataPass);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: updataPass,
                success: function(response) {
                    if(response.success) {
                        $('#validate_password').hide().text('');
                        alert('Đổi mật khẩu thành công!');
                    } else {
                        alert('Đổi mật khẩu thất bại!');
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    $('#validate_password').show().text(xhr.responseJSON.message);
                },
            });
        }
    });

    // //header icon login
    //     $("#userDropdown").click(function () {
    //     $("#dropdownMenu").toggle();
    // });
    // $(document).click(function (e) {
    //   if (!$(e.target).closest('.dropdown').length) {
    //     $("#dropdownMenu").hide();
    //   }
    // });
    $("#userDropdown").click(function (e) {
        e.stopPropagation(); // Ngăn sự kiện lan ra ngoài
        $("#dropdownMenu").toggle();
    });

    $(document).click(function (e) {
        if (!$(e.target).closest('.dropdown').length) {
            $("#dropdownMenu").hide();
        }
    });
});


