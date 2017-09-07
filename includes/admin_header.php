<nav class="text-center">
  <h1 class="heading">Admin</h1>
  <ul class="navigation">
    <li><a href="/">Home</a></li>
    <?php if ($_SESSION['username']) {
      echo '<li><a href="admin_contacts.php">Contacts</a></li>';
      echo '<li><a href="admin_projects.php">Projects</a></li>';
      echo '<li><a href="admin_skills.php">Skills</a></li>';
      echo '<li><a href="admin_logout.php">Logout</a></li>';
    } else {
      echo '<li><a href="admin.php">Login</a></li>';
    } ?>
  </ul>
</nav>
