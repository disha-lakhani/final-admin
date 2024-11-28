<?php
session_start();
require 'db.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$email = $name = $profileimage = $gender = $contact = $dob = '';

$query = "
    SELECT u.email, ui.name, ui.profileimage, ui.gender, ui.contact, ui.dob 
    FROM users u 
    INNER JOIN user_info ui ON u.id = ui.user_id 
    WHERE u.id = $user_id
";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    $email = $user['email'];
    $name = $user['name'];
    $profileimage = !empty($user['profileimage']) ? "uploads/" . $user['profileimage'] : "default.png";
    $gender = $user['gender'];
    $contact = $user['contact'];
    $dob = $user['dob'];
} else {

    echo "User data not found!";
    exit;
}

mysqli_close($conn);
?>



<?php

include 'layout/header.php';

?>
<div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
    style="min-height: 100px; background-image: url(../assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
    <span class="mask bg-gradient-default opacity-8"></span>
    <div class="header  pb-8 pt-5 pt-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent px-0 mini-nav">
                            <li class="breadcrumb-item text-white">Profile</li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Edit Profile</li>
                        </ol>
                    </nav>
                </div>
</div>
<div class="container-fluid mt--9">
    <div class="row">

        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Edit Profile</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-name">Name</label>
                                        <input type="text" id="input-name" name="name"
                                            class="form-control form-control-alternative"
                                            value="<?php echo htmlspecialchars($name); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address</label>
                                        <input type="email" id="input-email" name="email"
                                            class="form-control form-control-alternative"
                                            value="<?php echo htmlspecialchars($email); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <h6 class="heading-small text-muted mb-4">Contact information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-contact">Contact</label>
                                        <input type="text" id="input-contact" name="contact"
                                            class="form-control form-control-alternative"
                                            value="<?php echo htmlspecialchars($contact); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-gender">Gender</label>
                                        <select id="input-gender" name="gender"
                                            class="form-control form-control-alternative">
                                            <option value="Male" <?php echo ($gender === 'Male') ? 'selected' : ''; ?>>
                                                Male</option>
                                            <option value="Female" <?php echo ($gender === 'Female') ? 'selected' : ''; ?>>Female</option>
                                            <option value="Other" <?php echo ($gender === 'Other') ? 'selected' : ''; ?>>
                                                Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-dob">Date of Birth</label>
                                        <input type="date" id="input-dob" name="dob"
                                            class="form-control form-control-alternative"
                                            value="<?php echo htmlspecialchars($dob); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <!-- Profile Image -->
                        <h6 class="heading-small text-muted mb-4">Profile Image</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-profileimage">Profile Image</label>
                                        <input type="file" id="input-profileimage" name="profileimage"
                                            class="form-control form-control-alternative">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('form').on('submit', function(event) {
        event.preventDefault();  

        var formData = new FormData(this);  

        $.ajax({
            url: 'update_profile.php',  
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var result = JSON.parse(response); 
                if (result.status === 'success') {
                    alert(result.message);
                    window.location.href = 'profile.php';  
                } else {
                    // Display error message
                    alert(result.message);
                }
            },
            error: function() {
                alert('An error occurred while updating your profile. Please try again.');
            }
        });
    });
});
</script>


<?php

include 'layout/footer.php';

?>