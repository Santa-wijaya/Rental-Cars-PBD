<?php 

require 'functions.php';
$conn = mysqli_connect("localhost", "root", "", "rental");
if (isset($_POST["register"])) {
  if (ctype_space($_POST["username"]) && ctype_space($_POST["password_akun"])) {
    echo "<script> alert('Tolong isi data anda dengan benar!'); </script>";
  } else {
    $uname = stripslashes($_POST["username"]);
    $pwd = mysqli_real_escape_string($conn, $_POST["password_akun"]);
    $hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO admin VALUES('', '$uname', '$hashed_pwd');";
    mysqli_query($conn, $query);
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <link rel="icon" href="Images/Logo/logo_square.png" type="image/x-icon" />
    <title>Sewa Mobil</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a href="index.php" class="navbar-brand ms-3">Sewa Mobil</a>
        <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse ms-3" id="navbarTogglerDemo01">
            <ul class = "navbar-nav mx-auto">
                <li class="nav-item me-5"><a class = "nav-link" href="">Mobil Pickup</a></li>
                <li class="nav-item me-5"><a class = "nav-link" href="">Truk</a></li>
                <li class="nav-item"><a class = "nav-link" href="">Hubungi Kita</a></li>
            </ul>
            <a class="btn btn-primary btn-dark me-3" href="form_registrasi.php" role="button">Signup</a>
            <a class="btn btn-primary btn-dark me-3" href="form_login.php" role="button">Login</a>
        </div>
    </nav>

    <h1 class="text-center mb-4 mt-4">Login</h1>
    <form class="ms-3 me-3" action="#" method="post">
        <div class="mb-3 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
            <label for="inputUsername" class="form-label">Username</label>
            <input type="text" class="form-control" id="inputUsername" name="username">
        </div>
        <div class="mb-3 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPassword" name="password_akun">
        </div>
        <div class="text-center">
            <button type="submit" name="register" class="btn btn-primary col-sm-4">Register</button>
        </div>
    </form>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
  </body>
</html>