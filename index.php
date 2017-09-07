<?php
session_start();
include 'includes/header.php';
include 'includes/connection.php';

?>
<div class="heading text-center">
  <h1>Neptune Michael Cabelin</h1>
  <p class="lead">Fullstack Web Developer</p>
</div>
<div class="wrap">
<nav class="text-center">
  <ul class="navigation">
    <li data-id="about" class="nav-link">About Me</li>
    <li data-id="skills" class="nav-link">Skills</li>
    <li data-id="projects" class="nav-link">Projects</li>
    <li data-id="contacts" class="nav-link">Contacts</li>
  </ul>
</nav>
  <div class="container">
    <div class="row" id="pics">
      <div class="col-md-12">
        <div class="text-center">
          <img src="https://res.cloudinary.com/dd6kwd0zn/image/upload/v1504641707/AAEAAQAAAAAAAAl4AAAAJDBjMWI4M2U2LTIwZDYtNDE3Zi1hM2Q3LWM1NzhiZmMwMDZkMA_xiezhj.jpg" class="img-responsive circle profile-pic center-block">
        </div>
      </div>
    </div>
  </div>
  <div class="container no-show">
    <div class="row" id="about">
      <div class="col-md-12">
        <img src="https://res.cloudinary.com/dd6kwd0zn/image/upload/v1504642855/ss_c6di7o.jpg" class="img-responsive circle profile-pic pic-right pull-right">
        <h2>About me</h2>
        <p>I'm a full-stack web developer with a background in economics(BA) and healthcare experience. I've always had a passion for tech at an early age. I eventually discovered coding and loved it so much that I haven't looked back eversince.</p>
        <hr>
        <p>I have 2 years experience in building front-end, back-end and data-visualization applications with Python, JavaScript and PHP with a focus on security, and I'm expanding into mobile app development with React Native.</p>
        <hr>
        <p>Currently I'm freelancing but I am available for full-time, part-time and/or contract work.</p>
      </div>
    </div>

    <div class="row" id="skills">
      <div class="col-md-12">
        <h2>My Skills</h2>
        <?php
          $query = 'SELECT * FROM skills';
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              $name = $row['name'];
              echo "<div class='btn btn-default btn-lg skills'>$name</div>";
            }
          }
        ?>
      </div>
    </div>
    <div class="row"id="projects">
      <div class="col-md-12">
        <h2>Featured Projects</h2>
        <div class="row flexed">
        <?php
        $query = 'SELECT * FROM projects WHERE type = "fullstack"';
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            $title = $row['title'];
            $image = $row['image'];
            $details = $row['details'];
            $github = $row['github_url'];
            $live = $row['live_url'];
          ?>
          <div class="col-md-4 flexed-item">
            <div class="fullstack panel panel-default" data-github="<?php echo $github ?>" data-live="<?php echo $live ?>" data-title="<?php echo $title ?>">
            <div class="panel-heading text-center"><?php echo $title; ?></div>
            <div class="panel-body"><img src="<?php echo $image; ?>" class="img-responsive panel-img">
              <?php echo $details ?>
            </div>
            </div>
          </div>
          <?php
          }
        }
        ?>
        </div>

        <h2>Wordpress</h2>
        <div class="row flexed">
        <?php
        $query = 'SELECT * FROM projects WHERE type = "wordpress"';
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            $title = $row['title'];
            $image = $row['image'];
            $details = $row['details'];
            $github = $row['github_url'];
            $live = $row['live_url'];
          ?>
          <div class="col-md-4 flexed-item">
            <div class="slide panel panel-default" data-github="<?php echo $github ?>" data-live="<?php echo $live ?>" data-title="<?php echo $title ?>" data-image="<?php echo $image; ?>">
            <div class="panel-heading text-center"><?php echo $title; ?></div>
            <div class="panel-body">
              <img src="<?php echo $image; ?>" class="img-responsive panel-img center-block">
                <?php echo $details ?>
            </div>
            </div>
          </div>
          <?php
          }
        }
        ?>
        </div>

        <h2>Games</h2>
        <div class="row flexed">
        <?php
        $query = 'SELECT * FROM projects WHERE type = "games"';
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            $title = $row['title'];
            $image = $row['image'];
            $details = $row['details'];
            $github = $row['github_url'];
            $live = $row['live_url'];
          ?>
          <div class="col-md-4 flexed-item">
            <div class="slide panel panel-default" data-github="<?php echo $github ?>" data-live="<?php echo $live ?>" data-title="<?php echo $title ?>" data-image="<?php echo $image; ?>">
            <div class="panel-heading text-center"><?php echo $title; ?></div>
            <div class="panel-body">
              <img src="<?php echo $image; ?>" class="img-responsive panel-img center-block">
                <?php echo $details ?>
            </div>
            </div>
          </div>
          <?php
          }
        }
        ?>
        </div>

        <h2>Microservices</h2>
        <div class="row flexed">
        <?php
        $query = 'SELECT * FROM projects WHERE type = "microservices"';
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            $title = $row['title'];
            $image = $row['image'];
            $details = $row['details'];
            $github = $row['github_url'];
            $live = $row['live_url'];
          ?>
          <div class="col-md-4 flexed-item">
            <div class="slide panel panel-default" data-github="<?php echo $github ?>" data-live="<?php echo $live ?>" data-title="<?php echo $title ?>" data-image="<?php echo $image; ?>">
            <div class="panel-heading text-center"><?php echo $title; ?></div>
            <div class="panel-body">
              <img src="<?php echo $image; ?>" class="img-responsive panel-img center-block">
                <?php echo $details ?>
            </div>
            </div>
          </div>
            <?php
            }
          }
          ?>
          </div>

          <h2>Others</h2>
          <div class="row flexed">
          <?php
          $query = 'SELECT * FROM projects WHERE type = "other"';
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              $title = $row['title'];
              $image = $row['image'];
              $details = $row['details'];
              $github = $row['github_url'];
              $live = $row['live_url'];
            ?>
            <div class="col-md-4 flexed-item">
              <div class="slide panel panel-default" data-github="<?php echo $github ?>" data-live="<?php echo $live ?>" data-title="<?php echo $title ?>" data-image="<?php echo $image; ?>">
              <div class="panel-heading text-center"><?php echo $title; ?></div>
              <div class="panel-body">
                <img src="<?php echo $image; ?>" class="img-responsive panel-img center-block">
                  <?php echo $details ?>
              </div>
              </div>
            </div>
              <?php
              }
            }
            ?>
            </div>

      </div>
    </div>

    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
          </div>
        </div>

      </div>
    </div>

    <div class="row" id="contacts">
      <div class="col-md-12">
        <h2>Contact me</h2>
        <ul class="contacts">
          <li><i class="fa fa-github fa-lg"></i> - Github : <a href="https://github.com/ncabelin" target="_blank">https://github.com/ncabelin</a></li><br>
          <li><i class="fa fa-phone fa-lg"></i> - Phone : <a href="tel:6615137773" target="_blank">(661) 513-7773</a></li><br>
          <li><i class="fa fa-linkedin fa-lg"></i> - Linkedin : <a href="https://www.linkedin.com/in/ncabelin/" target="_blank">URL</a></li><br>
          <li><i class="fa fa-envelope fa-lg"></i> - E-mail : <a href="mailto:ncabelin@gmail.com">ncabelin@gmail.com</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php
include 'includes/scripts.php';
?>
<script>
$(function() {
  var first_check = false;

  var links = '#projects,#contacts,#about,#skills,footer';
  $(links).css('display','none');
  $('#pics').css('display','none').fadeIn(2000);
  $('.nav-link').click(function() {
    if (!first_check) {
      $('#pics').fadeOut();
      $('.heading').animate({
        padding: '20px'
      });
      $('.navigation').animate({
        padding: '20px'
      });
      $('.no-show').slideDown();
      first_check = true;
    }

    $('.nav-link').css('color','white');
    $(this).css('color','#ffce00');
    var link = $(this).data('id');
    $(links).hide();
    $('#' + link).fadeIn();
  });

  function changeModal(elem) {
    var title = elem.data('title'),
        github_url = elem.data('github'),
        live_url = elem.data('live'),
        live_html = '<a href="'
          + live_url + '" class="btn btn-lg btn-primary" target="_blank"><strong>View Live Site</strong></a>';

    if (!github_url) {
      github_html = '';
    } else {
      github_html = '<a href="' +
        github_url + '" class="btn btn-lg btn-primary" target="_blank"><strong>View Github repo</strong></a>';
    }

    $('.modal-title').text(title);
    $('.modal-body').html('<div class="text-center">' + github_html + live_html + '</div>');
    $('#myModal').modal();
  }

  $('.fullstack').click(function() {
    changeModal($(this));
  });

  $('.slide').click(function() {
    changeModal($(this));
  });
});
</script>
<?php
include 'includes/footer.php';
?>
