$(document).ready(function () {
    
    // Initially hide error messages
    $("#demo1").hide();
    $("#demo2").hide();
    $("#demo3").hide();
    $("#demo4").hide();
    $("#demo5").hide();
    $("#demo6").hide();

    // Fetch categories for the dropdown
    $.ajax({
        url: 'fetch_categories.php',
        type: 'GET',
        success: function (data) {
            $('#category').html(data);
        },
        error: function () {
            alert('Error fetching categories.');
        }
    });

    // Form submission with validation and AJAX
    $("#product-form").submit(function (e) {
        e.preventDefault(); // Prevent default form submission

        var isValid = true;

        // Helper functions to show and hide errors
        function showError(elementId, inputGroup) {
            $(elementId).show();
            $(inputGroup).parent().css("margin-bottom", "0");
            isValid = false;
        }

        function hideError(elementId, inputGroup) {
            $(elementId).hide();
            $(inputGroup).parent().css("margin-bottom", "1rem");
        }

        // Product Name Validation
        var pname = $("#pname").val().trim();
        if (pname === "") {
            showError("#demo1", "#pname");
        } else {
            hideError("#demo1", "#pname");
        }

        // Product Description Validation
        var pdes = $("#pdes").val().trim();
        if (pdes === "") {
            showError("#demo2", "#pdes");
        } else {
            hideError("#demo2", "#pdes");
        }

        // Price Validation
        var price = $("#price").val().trim();
        if (price === "") {
            showError("#demo3", "#price");
        } else {
            hideError("#demo3", "#price");
        }

        // Category Validation
        var category = $("#category").val();
        if (category === "") {
            showError("#demo4", "#category");
        } else {
            hideError("#demo4", "#category");
        }

        // Stock Validation
        var stock = $("#stock").val().trim();
        if (stock === "") {
            showError("#demo6", "#stock");
        } else {
            hideError("#demo6", "#stock");
        }

        // If validation fails, stop here
        if (!isValid) {
            return;
        }

        // Prepare form data for AJAX
        var formData = new FormData(this);

        // AJAX request to insert product
        $.ajax({
            url: 'update_product.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                var data = JSON.parse(response);
                if (data.success) {
                    $('#message').html('<div class="alert alert-success">' + data.message + '</div>');
                    setTimeout(function () {
                        window.location.href = 'allproduct.php';  // Redirect after success
                    }, 2000);
                } else {
                    $('#message').html('<div class="alert alert-danger">' + data.message + '</div>');
                }
            },
            error: function () {
                alert('Error updating product.');
            }
        });
    });
   
});
