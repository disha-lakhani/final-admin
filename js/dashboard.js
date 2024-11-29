
$(document).ready(function () {
    $.ajax({
        url: 'check_session.php',
        method: 'POST',
        dataType: 'json',
        success: function (response) {
            if (response.status !== 'success') {

                alert(response.message || "Please log in first.");
                window.location.href = 'login.php';
            }
        },
        error: function () {
            alert("An error occurred while checking session.");
            window.location.href = 'login.php';
        }
    });
    $.ajax({
        url: 'dashboard_data.php', // Endpoint to fetch data
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // Update the UI with the data
            $("#total-products").text(data.total_products);
            $("#total-categories").text(data.total_categories);
            $("#total-customers").text(data.total_customers);
            

        },
        error: function (xhr, status, error) {
            console.error("Error fetching dashboard data:", error);
        }
    });
   
    $('#logoutBtn').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'logout.php',
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // alert('Logout successful!');
                    window.location.href = 'login.php';
                } else {
                    alert('Logout failed: ' + response.message);
                }
            },
            error: function () {
                alert('An error occurred. Please try again.');
            }
        });

    });
});

