<?php
session_start();

// REDIRECT IF NOT LOGGED IN
if (!$_SESSION['username']) {
  header('Location: /login.php');
}

include 'includes/connection.php';
include 'includes/validation.php';
$skill_id = validateData($_GET['edit']);
$message = validateData($_GET['message']);
$error = validateData($_GET['error']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $delete_id = validateData($_POST['delete_id']);
  $edit_id = validateData($_POST['edit_id']);
  if ($delete_id) {
    // DELETE
    $query = "DELETE FROM skills WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $delete_id);
    if ($stmt->execute()) {
      header('Location: /admin_skills.php?message=Deleted skill');
    } else {
      header('Location: /admin_skills.php?error=Error deleting skill');
    }
  } elseif ($edit_id) {
    // EDIT
    $name = validateData($_POST['name']);
    $level = validateData($_POST['level']);
    $query = "UPDATE skills SET name = ?, level = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssi', $name, $level, $edit_id);
    if ($stmt->execute()) {
      header('Location: /admin_skills.php?message=Edited skill');
    } else {
      header('Location: /admin_skills.php?error=Error editing skill');
    }
  } else {
    // ADD
    $name = validateData($_POST['name']);
    $level = validateData($_POST['level']);
    $query = "INSERT INTO skills(name, level) VALUES(?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $name, $level);
    if ($stmt->execute()) {
      header('Location: /admin_skills.php?message=Added skill');
    } else {
      header('Location: /admin_skills.php?error=Error adding skill');
    }
  }
} elseif ($skill_id) {
  // GET EDIT FORM
  $stmt = $conn->prepare("SELECT * FROM skills WHERE id = ?");
  $stmt->bind_param('i', $skill_id);
  $stmt->execute();
  $stmt->bind_result($id, $name, $level);
  $stmt->store_result();
}
// GET ALL
$query = "SELECT * FROM skills";
$result = $conn->query($query);

include 'includes/header.php';
include 'includes/admin_header.php';
?>
<?php if ($message) {
  echo "<div class='alert alert-success text-center'>$message</div>";
} ?>
<?php if ($error) {
  echo "<div class='alert alert-danger text-center'>$error</div>";
} ?>
<div class="container">
  <div class="row">

    <div class="col-md-4">
      <?php
      if ($stmt->num_rows > 0) {
        while ($stmt->fetch()) { // EDIT FORM ?>
          <h3>Edit Skill</h3>
          <form method="POST">
            <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
            <div class="form-group">
              <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $name; ?>">
            </div>
            <div class="form-group">
              <select name="level">
                <?php if ($level === 'beginner') { ?>
                  <option value="beginner" selected>Beginner</option>
                  <option value="intermediate">Intermediate</option>
                  <option value="advanced">Advanced</option>
                <?php } elseif ($level === 'intermediate') { ?>
                  <option value="beginner">Beginner</option>
                  <option value="intermediate" selected>Intermediate</option>
                  <option value="advanced">Advanced</option>
                <?php } else { ?>
                  <option value="beginner">Beginner</option>
                  <option value="intermediate">Intermediate</option>
                  <option value="advanced" selected>Advanced</option>
                <?php } ?>
              </select>
            </div>
            <input type="submit" class="btn btn-default" value="Save">
            <a href="admin_skills.php" class="btn btn-default">Cancel</a>
          </form>
      <?php
        }
      } else { // ADD FORM ?>
        <h3>Add Skill</h3>
        <form method="POST">
          <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="Name">
          </div>
          <div class="form-group">
            <select name="level">
              <option value="beginner">Beginner</option>
              <option value="intermediate">Intermediate</option>
              <option value="advanced">Advanced</option>
            </select>
          </div>
          <input type="submit" class="btn btn-default" value="Add">
        </form>
      <?php
      }
      ?>
    </div>

    <div class="col-md-8">
      <ul class="list-group">
        <?php
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              $id = $row['id'];
              $name = $row['name'];
              $level = $row['level']; ?>
              <li class='list-group-item'><strong><?php echo $name . '</strong> - ' . $level; ?>
                <a href='admin_skills.php?edit=<?php echo $id; ?>' class='btn btn-default btn-sm'>EDIT</a>
                <form method="POST" style="display:inline;">
                  <input type="hidden" value="<?php echo $id; ?>" name="delete_id">
                  <button class='btn btn-default btn-sm'>DELETE</button>
                </form>
              </li>
          <?php
            }
          }
        ?>
      </ul>
    </div>
  </div>
</div>
<?php
include 'includes/footer.php';
?>
