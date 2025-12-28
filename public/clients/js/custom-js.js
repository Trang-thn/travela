$(document).ready(function () {
    // Handle Login
    $("#sign-up").click(function () {
        $(".sign-in").hide();
        $(".sign-up").show();
    });
    $("#sign-in").click(function () {
        $(".sign-up").hide();
        $(".sign-in").show();
    });


    $("#userDropdown").click(function () {
      $("#dropdownMenu").toggle();

  });
  $(document).click(function (e) {
      if (!$(e.target).closest('.dropdown').length) {
        $("#dropdownMenu").hide();
      }
    });

});
