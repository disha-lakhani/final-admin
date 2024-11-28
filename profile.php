<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$user_id = $_SESSION['user_id'];

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
  echo "Error: User details not found.";
  exit;
}
?>

<?php

include 'layout/header.php';

?>
<div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" 
    style="min-height: 500px; background-image: url(../assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
    <span class="mask bg-gradient-default opacity-8"></span>
    <div class="container-fluid d-flex align-items-center">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h1 class="display-2 text-white">Hello <?php echo htmlspecialchars($name); ?></h1>
                <p class="text-white mt-0 mb-5">You can see your progress and manage your account.</p>
                
            </div>
            
        </div>
    </div>
</div>
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                <img src="uploads/<?php echo htmlspecialchars($profileimage); ?>" class="rounded-circle">
                            </a>
                        </div>
                    </div>
                </div>
                <br><br><br><br><br>
                <div class="card-body pt-0 pt-md-4">
                    <div class="text-center">
                        <h3><?php echo htmlspecialchars($name); ?></h3>
                        <div class="h5 font-weight-300">
                        <i class="fa-solid fa-envelope"></i> <?php echo htmlspecialchars($email); ?>
                        </div>
                        <div class="h5 mt-4">
                        <i class="fa-solid fa-person-half-dress"></i>  Gender: <?php echo htmlspecialchars($gender); ?>
                        </div>
                        <div class="h5 mt-4">
                        <i class="fa-solid fa-mobile"></i>  Contact: <?php echo htmlspecialchars($contact); ?>
                        </div>
                        <div class="h5 mt-4">
                        <i class="fa-regular fa-calendar-days"></i>  Date of Birth: <?php echo htmlspecialchars($dob); ?>
                        </div>
                        <br><br><br>
                        <div>
                          <a href="edit_profile.php" class="btn btn-primary">Edit profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">My account</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Username</label>
                                        <input type="text" id="input-username" class="form-control form-control-alternative" value="<?php echo htmlspecialchars($name); ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address</label>
                                        <input type="email" id="input-email" class="form-control form-control-alternative" value="<?php echo htmlspecialchars($email); ?>" readonly>
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
                                        <input type="text" id="input-contact" class="form-control form-control-alternative" value="<?php echo htmlspecialchars($contact); ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-dob">Date of Birth</label>
                                        <input type="date" id="input-dob" class="form-control form-control-alternative" value="<?php echo htmlspecialchars($dob); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                    </form>
                </div>
            </div>
        </div>
    </div>



<?php

  include 'layout/footer.php';

?>