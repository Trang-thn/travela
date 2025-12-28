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
