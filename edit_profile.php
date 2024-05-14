<?php
include 'db.php';
include "header.php";

// Check if user is logged in
if (!isset($_SESSION['uid'])) {
    header("Location: signin_form.php");
    exit();
}

// Fetch user details from the database
$user_id = $_SESSION['uid'];
$profile_updated = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Update user details
    if (!empty($password)) {
        $sql = "UPDATE user_info SET first_name='$first_name', last_name='$last_name', email='$email', password='$password_hash' WHERE user_id='$user_id'";
    } else {
        $sql = "UPDATE user_info SET first_name='$first_name', last_name='$last_name', email='$email' WHERE user_id='$user_id'";
    }
    
    if (mysqli_query($con, $sql)) {
        $profile_updated = true;
    } else {
        echo "Error updating profile: " . mysqli_error($con);
    }
}

// Fetch updated user details from the database
$sql = "SELECT first_name, last_name, email FROM user_info WHERE user_id='$user_id'";
$result = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Profile</h2>
        <form action="edit_profile.php" method="POST">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password (leave blank to keep current password)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Profile Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Profile updated successfully!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        <?php if ($profile_updated): ?>
            $(document).ready(function() {
                $('#updateModal').modal('show');
            });
        <?php endif; ?>
    </script>
</body>
</html>
