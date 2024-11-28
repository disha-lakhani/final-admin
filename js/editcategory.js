$(document).ready(function () {
    $("#demo1").hide();
    $("#demo2").hide();

    $("#msform").on("submit", function (e) {
        e.preventDefault();

        var isValid = true;

        // Helper functions to show and hide errors
        function showError(elementId, inputField) {
            $(elementId).show();
            $(inputField).css("border", "1px solid red"); // Highlight invalid field
            isValid = false;
        }

        function hideError(elementId, inputField) {
            $(elementId).hide();
            $(inputField).css("border", ""); // Reset field style
        }

        // Validate Category Name
        var cname = $("#categoryName").val().trim();
        if (cname === "") {
            showError("#demo1", "#categoryName");
        } else {
            hideError("#demo1", "#categoryName");
        }

        // Validate Category Description
        var cdes = $("#categoryDescription").val().trim();
        if (cdes === "") {
            showError("#demo2", "#categoryDescription");
        } else {
            hideError("#demo2", "#categoryDescription");
        }

        // Stop submission if validation fails
        if (!isValid) {
            return;
        }

        // Submit form data via AJAX
        $.ajax({
            url: "editcategory.php",
            type: "POST",
            data: $(this).serialize(), // Serialize form data
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    // Display success message
                    $("#resultMessage").html(`<div class="alert alert-success">${response.message}</div>`);

                    // Redirect after 2 seconds
                    setTimeout(function () {
                        window.location.href = "allcategory.php";
                    }, 2000);
                } else {
                    // Display error message
                    $("#resultMessage").html(`<div class="alert alert-danger">${response.message}</div>`);
                }
            },
            error: function () {
                // Handle unexpected AJAX errors
                $("#resultMessage").html(`<div class="alert alert-danger">An error occurred while processing the request.</div>`);
            },
        });
    });
   
});
