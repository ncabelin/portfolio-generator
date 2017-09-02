<?php
session_start();
include 'includes/header.php';
include 'includes/connection.php';

?>
<nav class="text-center">
  <h1>Neptune Michael Cabelin</h1>
  <p class="lead">Fullstack Web Developer</p>
  <ul class="navigation">
    <li><a href="#about" id="about-link">About Me</a></li>
    <li><a href="https://www.mindwelder.com" target="_blank">Blog</a></li>
    <li><a href="#projects" id="projects-link">Projects</a></li>
    <li><a href="#contacts" id="contacts-link">Contacts</a></li>
  </ul>
</nav>
<div class="container">
  <div class="row" id="about">
    <div class="col-md-12">
      <h3>About me</h3>
      <p>I'm a full-stack web developer with a background in economics and healthcare. I've always had a passion for tech at an early age. I discovered coding somewhere along and loved it so much (still do), that I haven't looked back eversince. So far I've been enjoying web development with Python, JavaScript and PHP/Wordpress but am currently expanding into mobile app development.</p>
      <p>Currently I'm freelancing but I am available for full-time, part-time and/or contract work.</p>
    </div>
  </div>
  <div class="row" id="contacts">
    <div class="col-md-12">
      <?php
        $query = 'SELECT * FROM contacts';
        $result = mysqli_query($conn, $query);
      ?>
      <h3>Contact me</h3>
      <ul>
        <?php if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            $title = $row['title'];
            $description = $row['description'];
            $url = $row['url']; ?>
            <li><?php echo $title . ' - ' . $url ?></li>
        <?php
          }
        } ?>
      </ul>
    </div>
  </div>
</div>
<?php
include 'includes/scripts.php';
include 'includes/footer.php';
?>
