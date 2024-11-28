$(document).ready(function () {

    $("#demo1").hide();
    $("#demo2").hide();


    $("#addCategoryForm").on("submit", function (e) {
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


        var cname = $("#categoryName").val().trim();
        if (cname === "") {
            showError("#demo1", "#categoryName");
        } else {
            hideError("#demo1", "#categoryName");
        }


        var cdes = $("#categoryDescription").val().trim();
        if (cdes === "") {
            showError("#demo2", "#categoryDescription");
        } else {
            hideError("#demo2", "#categoryDescription");
        }

        if (!isValid) {
            return;
        }


        $.ajax({
            url: "insert_category.php",
            type: "POST",
            data: {
                category_name: cname,
                category_description: cdes,
            },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $("#message").html('<div class="alert alert-success">' + response.message + "</div>");
                    setTimeout(function () {
                        window.location.href = "allcategory.php";
                    }, 2000);
                } else {
                    $("#message").html('<div class="alert alert-danger">' + response.message + "</div>");
                }
            },
            error: function () {
                alert("An error occurred while adding the category.");
            },
        });
    });
   
});
