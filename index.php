<?php

include 'functions.php';
/*if(empty($_SESSION['user']))
    header("location:login.php");*/
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="favicon.ico" />

  <title>Sistem Informasi Geografis</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="assets/css/general.css" rel="stylesheet" />
  <script src="assets/js/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <!-- <script src="assets/js/bootstrap.min.js"></script>   -->
  <!-- <link href="assets/css/solar-bootstrap.min.css" rel="stylesheet"/> -->

  <script src="assets/tinymce/tinymce.min.js"></script>
  <script>
    tinymce.init({
      selector: "textarea.mce",
      plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
      ],
      menubar: false,
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    });
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCiDdGyp6n2hKHPECuB6JZIT-8dVHCpwI0&language=id&region=ID"></script>
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAidve3dd0jZmDEgdEkM1ettoSJLlB5tqs&callback=initMap&v=weekly"></script> -->
  <script>
    var default_lat = <?= get_option('default_lat') ?>;
    var default_lng = <?= get_option('default_lng') ?>;
    var default_zoom = <?= get_option('default_zoom') ?>;
  </script>
  <script src="assets/js/script.js"></script>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #3260a8;">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse show" id="navbarColor03">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a href="index.php" class="text-white nav-link active"><span></span> SemarFood</a>
          </li>
          <?php if ($_SESSION['login']) { ?>
            <li class="nav-item">
              <a href="?m=tempat" class="text-white nav-link active"><span></span> Tempat</a>
            </li>
            <li class="nav-item">
              <a href="?m=galeri" class="text-white nav-link active"><span></span> Galeri</a>
            </li>
            <li class="nav-item">
              <a href="?m=password" class="text-white nav-link active"><span></span> Password</a>
            </li>
            <li class="nav-item">
              <a href="aksi.php?act=logout" class="text-white nav-link active"><span></span> Logout</a>
            </li>
          <?php } else { ?>
            <li class="nav-item ">
              <a href="?m=login" class="text-white nav-link active"><span></span> Login</a>
            </li>
            <li class="nav-item ">
              <a href="?m=register" class="text-white nav-link active"><span></span> Register</a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <?php
    if (file_exists($mod . '.php')) {
      include $mod . '.php';
    } else {
      include 'home.php';
    }
    ?>
  </div>

</body>

</html>