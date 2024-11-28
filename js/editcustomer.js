$(document).ready(function () {

    $("#demo1").hide();
    $("#demo2").hide();
    $("#demo3").hide();
    $("#demo4").hide();
    $("#demo5").hide();
    $("#demo6").hide();
    $("#demo7").hide();
    $("#demo8").hide();




    $("#edit").click( function (e) {
        e.preventDefault();
        var isValid = true;

        function showError(elementId, inputGroup) {
            $(elementId).show();
            $(inputGroup).parent().css("margin-bottom", "0");
            isValid = false;
        }

        function hideError(elementId, inputGroup) {
            $(elementId).hide();
            $(inputGroup).parent().css("margin-bottom", "1rem");
        }

        var fname = $("#fname").val().trim();
        if (fname === "") {
            showError("#demo1", "#fname");
        } else {
            hideError("#demo1", "#fname");
        }

        var lname = $("#lname").val().trim();
        if (lname === "") {
            showError("#demo2", "#lname");
        } else {
            hideError("#demo2", "#lname");
        }
        var gender = $("input[name='gender']:checked").val();
        if (!gender) {
            showError("#demo3", "input[name='gender']");
        } else {
            hideError("#demo3", "input[name='gender']");
        }

        var contact = $("#contact").val().trim();
        if (contact === "" || isNaN(contact) || contact.length !== 10) {
            if (contact.length !== 10) {
                showError("#demo4", "#contact", "***Only 10 digits are allowed***");
            } else {
                showError("#demo4", "#contact", "***Contact number is required***");
            }
        } else {
            hideError("#demo4", "#contact");
        }

        var email = $("#email").val().trim();
        var emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
        if (!emailPattern.test(email)) {
            $("#demo5").text("enter valid email address");
            showError("#demo5", "#email");
        } else {
            hideError("#demo5", "#email");
        }

        var address = $("#address").val().trim();
        if (address === "") {
            showError("#demo6", "#address", "***Address is required***");
        } else {
            hideError("#demo6", "#address");
        }


        var city = $("#city").val();
        if (city === "") {
            showError("#demo7", "#city");
        } else {
            hideError("#demo7", "#city");
        }

        var state = $("#state").val();
        if (state === "") {
            showError("#demo8", "#state", "***State is required***");
        } else {
            hideError("#demo8", "#state");
        }

        if (isValid){


        $.ajax({
            url: 'update_customer.php',
            type: 'POST',
            data: $("#addCustomerForm").serialize(),
            success: function (response) {
                var data = JSON.parse(response);
                if (data.success) {
                    alert("updated");
                    $('#message').html('<div class="alert alert-success">' + data.message + '</div>');
                    setTimeout(function () {
                        window.location.href = 'allcustomer.php';

                    }, 2000);
                } else {
                    alert("error");
                    $('#message').html('<div class="alert alert-danger">' + data.message + '</div>');
                }
            },
           
        });
    }


    });

});