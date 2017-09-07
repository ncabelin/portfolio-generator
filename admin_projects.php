<?php
session_start();

// REDIRECT IF NOT LOGGED IN
if (!$_SESSION['username']) {
  header('Location: /login.php');
}

include 'includes/connection.php';
include 'includes/validation.php';
$project_id = validateData($_GET['edit']);
$message = validateData($_GET['message']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $delete_id = validateData($_POST['delete_id']);
  $edit_id = validateData($_POST['edit_id']);
  if ($delete_id) {
    // DELETE
    $query = "DELETE FROM projects WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $delete_id);
    if ($stmt->execute()) {
      header('Location: /admin_projects.php?message=Deleted project');
    } else {
      header('Location: /admin_projects.php?error=Error deleting project');
    }
  } elseif ($edit_id) {
    // EDIT
    $title = validateData($_POST['title']);
    $type = validateData($_POST['type']);
    $github_url = validateData($_POST['github_url']);
    $live_url = validateData($_POST['live_url']);
    $details = validateData($_POST['details']);
    $image = validateData($_POST['image']);
    $query = "UPDATE projects SET title = ?, type = ?, github_url = ?, live_url = ?, details = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssssi', $title, $type, $github_url, $live_url, $details, $image, $edit_id);
    if ($stmt->execute()) {
      header('Location: /admin_projects.php?message=Edited project');
    } else {
      header('Location: /admin_projects.php?error=Error editing project');
    }
  } else {
    // ADD
    $title = validateData($_POST['title']);
    $type = validateData($_POST['type']);
    $github_url = validateData($_POST['github_url']);
    $live_url = validateData($_POST['live_url']);
    $details = validateData($_POST['details']);
    $image = validateData($_POST['image']);
    $query = "INSERT INTO projects(title, type, github_url, live_url, details, image) VALUES(?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssss', $title, $type, $github_url, $live_url, $details, $image);
    if ($stmt->execute()) {
      header('Location: /admin_projects.php?message=Added project');
    } else {
      header('Location: /admin_projects.php?error=Error adding project');
    }
  }
} elseif ($project_id) {
  // GET EDIT FORM
  $stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
  $stmt->bind_param('i', $project_id);
  $stmt->execute();
  $stmt->bind_result($id, $title, $type, $github_url, $live_url, $details, $image, $date_created);
  $stmt->store_result();
}
// GET ALL
$query = "SELECT * FROM projects ORDER BY date_created DESC";
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
<div class="wrap">
  <div class="container">
    <div class="row">

      <div class="col-md-4">
        <?php
        if ($stmt->num_rows > 0) {
          while ($stmt->fetch()) { // EDIT FORM ?>
            <h3>Edit Project</h3>
            <form method="POST">
              <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
              <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
              </div>
              <div class="form-group">
                <label>Github URL</label>
                <input type="text" name="github_url" class="form-control" value="<?php echo $github_url; ?>">
              </div>
              <div class="form-group">
                <label>Live URL</label>
                <input type="text" name="live_url" class="form-control" value="<?php echo $live_url; ?>">
              </div>
              <div class="form-group">
                <label>Image URL</label>
                <input type="text" name="image" class="form-control" value="<?php echo $image; ?>">
              </div>
              <div class="form-group">
                <label>Details</label>
                <textarea name="details" class="form-control"><?php echo $details; ?></textarea>
              </div>
              <div class="form-group">
                <?php if ($type === 'Fullstack') { ?>
                  <select name="type">
                    <option value="Fullstack" selected>Fullstack</option>
                    <option value="Wordpress">Wordpress</option>
                    <option value="Microservices">Micro-services</option>
                    <option value="Games">Games</option>
                  </select>
                <?php } elseif ($type === 'Wordpress') { ?>
                  <select name="type">
                    <option value="Fullstack">Fullstack</option>
                    <option value="Wordpress" selected>Wordpress</option>
                    <option value="Microservices">Micro-services</option>
                    <option value="Games">Games</option>
                    <option value="Other">Other</option>
                  </select>
                <?php } elseif ($type === 'Microservices') { ?>
                  <select name="type">
                    <option value="Fullstack">Fullstack</option>
                    <option value="Wordpress">Wordpress</option>
                    <option value="Microservices" selected>Micro-services</option>
                    <option value="Games">Games</option>
                    <option value="Other">Other</option>
                  </select>
                <?php } elseif ($type === 'Games') { ?>
                  <select name="type">
                    <option value="Fullstack">Fullstack</option>
                    <option value="Wordpress">Wordpress</option>
                    <option value="Microservices">Micro-services</option>
                    <option value="Games" selected>Games</option>
                    <option value="Other">Other</option>
                  </select>
                <?php } else { ?>
                  <select name="type">
                    <option value="Fullstack">Fullstack</option>
                    <option value="Wordpress">Wordpress</option>
                    <option value="Microservices">Micro-services</option>
                    <option value="Games">Games</option>
                    <option value="Other" selected>Other</option>
                  </select>
                <?php } ?>
              </div>
              <input type="submit" class="btn btn-default" value="Save">
              <a href="admin_projects.php" class="btn btn-default">Cancel</a>
            </form>
        <?php
          }
        } else { // ADD FORM ?>
          <h3>Add Project</h3>
          <form method="POST">
            <div class="form-group">
              <label>Title</label>
              <input type="text" name="title" class="form-control">
            </div>
            <div class="form-group">
              <label>Github URL</label>
              <input type="text" name="github_url" class="form-control">
            </div>
            <div class="form-group">
              <label>Live URL</label>
              <input type="text" name="live_url" class="form-control">
            </div>
            <div class="form-group">
              <label>Image URL</label>
              <input type="text" name="image" class="form-control">
            </div>
            <div class="form-group">
              <label>Details</label>
              <textarea name="details" class="form-control"></textarea>
            </div>
            <div class="form-group">
              <label>Type</label>
              <select name="type">
                <option value="Fullstack">Fullstack</option>
                <option value="Wordpress">Wordpress</option>
                <option value="Microservices">Micro-services</option>
                <option value="Games">Games</option>
                <option value="Other">Other</option>
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
                $title = $row['title'];
                $type = $row['type'];
                $github_url = $row['github_url'];
                $live_url = $row['live_url'];
                $details = $row['details'];
                $image = $row['image'];
              ?>
                <li class='list-group-item'><strong><?php echo $title . '</strong> - ' . $type; ?>
                  <br>
                  <?php echo $github_url . ' @ ' . $live_url; ?>
                  <br>
                  <img src="<?php echo $image; ?>" class="img-responsive thumb-nail">
                  <br>
                  <p><?php echo $details; ?></p>
                  <hr>
                  <a href='admin_project_skills.php?id=<?php echo $id; ?>' class='btn btn-default btn-sm'>ADD SKILLS</a>
                  <a href='admin_projects.php?edit=<?php echo $id; ?>' class='btn btn-default btn-sm'>EDIT</a>
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
</div>
<?php
include 'includes/scripts.php';
?>
<script>
$('.heading,.navigation').css('padding','20px');
$('.navigation li a').css('color','white');
</script>
<?php
include 'includes/footer.php';
?>
