<?php
session_start();

// REDIRECT IF NOT LOGGED IN
if (!$_SESSION['username']) {
  header('Location: /login.php');
}

include 'includes/connection.php';
include 'includes/validation.php';
$contact_id = validateData($_GET['edit']);
$message = validateData($_GET['message']);
$error = validateData($_GET['error']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $delete_id = validateData($_POST['delete_id']);
  $edit_id = validateData($_POST['edit_id']);
  if ($delete_id) {
    // DELETE
    $query = "DELETE FROM contacts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $delete_id);
    if ($stmt->execute()) {
      header('Location: /admin_contacts.php?message=Deleted contact');
    } else {
      header('Location: /admin_contacts.php?error=Error deleting contact');
    }
  } elseif ($edit_id) {
    // EDIT
    $title = validateData($_POST['title']);
    $description = validateData($_POST['description']);
    $url = validateData($_POST['url']);
    $query = "UPDATE contacts SET title = ?, description = ?, url = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssi', $title, $description, $url, $edit_id);
    if ($stmt->execute()) {
      header('Location: /admin_contacts.php?message=Edited contact');
    } else {
      header('Location: /admin_contacts.php?error=Error editing contact');
    }
  } else {
    // ADD
    $title = validateData($_POST['title']);
    $description = validateData($_POST['description']);
    $url = validateData($_POST['url']);
    $query = "INSERT INTO contacts(title, description, url) VALUES(?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $title, $description, $url);
    if ($stmt->execute()) {
      header('Location: /admin_contacts.php?message=Added contact');
    } else {
      header('Location: /admin_contacts.php?error=Error adding contact');
    }
  }
} elseif ($contact_id) {
  // GET EDIT FORM
  $stmt = $conn->prepare("SELECT * FROM contacts WHERE id = ?");
  $stmt->bind_param('i', $contact_id);
  $stmt->execute();
  $stmt->bind_result($id, $title, $description, $url);
  $stmt->store_result();
}
// GET ALL
$query = "SELECT * FROM contacts";
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
          <h3>Edit Contact</h3>
          <form method="POST">
            <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
            <div class="form-group">
              <input type="text" name="title" class="form-control" placeholder="Title" value="<?php echo $title; ?>">
            </div>
            <div class="form-group">
              <textarea type="text" name="description" class="form-control" placeholder="Description"><?php echo $description; ?></textarea>
            </div>
            <div class="form-group">
              <input type="text" name="url" class="form-control" placeholder="URL" value="<?php echo $url; ?>">
            </div>
            <input type="submit" class="btn btn-default" value="Save">
            <a href="admin_contacts.php" class="btn btn-default">Cancel</a>
          </form>
      <?php
        }
      } else { // ADD FORM ?>
        <h3>Add Contact</h3>
        <form method="POST">
          <div class="form-group">
            <input type="text" name="title" class="form-control" placeholder="Title">
          </div>
          <div class="form-group">
            <textarea type="text" name="description" class="form-control" placeholder="Description"></textarea>
          </div>
          <div class="form-group">
            <input type="text" name="url" class="form-control" placeholder="URL">
          </div>
          <input type="submit" class="btn btn-default" value="Save">
          <a href="admin_contacts.php" class="btn btn-default">Cancel</a>
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
              $title = $row['title'];
              $url = $row['url'];
              $description = $row['description']; ?>
              <li class='list-group-item'>
                <strong><?php echo $title; ?></strong><br>
                <em><?php echo $url; ?></em><hr>
                <p><?php echo $description; ?></p>
                <a href='admin_contacts.php?edit=<?php echo $id; ?>' class='btn btn-default btn-sm'>EDIT</a>
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
