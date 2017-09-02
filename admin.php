<?php
session_start();
include 'includes/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include 'includes/validation.php';
  $user = validateData($_POST['username']);
  $password = validateData($_POST['password']);
  include 'includes/connection.php';
  $stmt = $conn->prepare("SELECT username, password FROM user WHERE username = ?");
  $stmt->bind_param("s", $user);
  $stmt->execute();
  $stmt->bind_result($username, $hashed_password);
  $stmt->store_result();
  if ($stmt->num_rows > 0) {
    while ($stmt->fetch()) {
      if (sha1($password) === $hashed_password) {
        $_SESSION['username'] = $username;
      }
    }
  }
  //$conn.close();
}
include 'includes/admin_header.php';
?>
<div class="container">
  <div class="row">
    <?php if (!$_SESSION['username']) { ?>
      <div class="col-md-4 col-md-offset-4">
        <form method="POST">
          <p class="lead">Login</p>
          <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="Username">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password">
          </div>
          <input type="submit" value="LOGIN" class="btn btn-default">
        </form>
      </div>
   <?php } ?>
  </div>
</div>
<?php
include 'includes/scripts.php';
include 'includes/footer.php';
?>
