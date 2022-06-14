<?php 
session_start();
// require 'functions.php';
// // $tuples = read("SELECT * FROM peminjaman_terbanyak;");
// // $data =read("SELECT COUNT(*) AS total_peminjaman FROM peminjaman");
?>

<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Sewa Mobil</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    </head>
    <body>
       <section class="h-100 w-100" style="
        box-sizing: border-box;
        position: relative;
        background-color: #FAFCFF;
      ">
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

      .header-3-3 .modal-backdrop.show {
        background-color: #000;
        opacity: 0.6;
      }

      .header-3-3 .modal-item.modal {
        top: 2rem;
      }

      .header-3-3 .navbar {
        padding: 2rem 2rem;
      }

      .header-3-3 .navbar-light .navbar-nav .nav-link {
        font: 300 0.875rem/1.5rem Poppins, sans-serif;
        color: #8B9CAF;
        padding: 0rem 1.25rem 0rem 0rem;
        margin-right: 0;
        margin-left: 0;
      }

      .header-3-3 .navbar-light .navbar-nav .nav-link:hover {
        font: 500 0.875rem/1.5rem Poppins, sans-serif;
        color: #243142;
      }

      .header-3-3 .navbar-light .navbar-nav .active {
        position: relative;
        width: fit-content;
      }

      .header-3-3 .navbar-light .navbar-nav .active>.nav-link,
      .header-3-3 .navbar-light .navbar-nav .nav-link.active,
      .header-3-3 .navbar-light .navbar-nav .nav-link.show,
      .header-3-3 .navbar-light .navbar-nav .show>.nav-link {
        font-weight: 500;
      }

      .header-3-3 .navbar-light .navbar-toggler-icon {
        background-image: urlurl("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 0, 0, 0.55%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
      }

      .header-3-3 .btn:focus,
      .header-3-3 .btn:active {
        outline: none !important;
      }

      .header-3-3 .btn-fill {
        font: 500 0.875rem/1.25rem Poppins, sans-serif;
        border: 1px solid #4E91F9;
        background-color: #4E91F9;
        border-radius: 999px;
        padding: 0.75rem 1.5rem;
        transition: 0.3s;
      }

      .header-3-3 .btn-fill:hover {
        background-color: #6DA4F9;
        border: 1px solid #6DA4F9;
      }

      .header-3-3 .btn-no-fill {
        font: 500 0.875rem/1.25rem Poppins, sans-serif;
        color: #8B9CAF;
        padding: 0.75rem 2rem;
      }

      .header-3-3 .btn-no-fill:hover {
        color: #243142;
      }

      .header-3-3 .modal-item .modal-dialog .modal-content {
        border-radius: 8px;
      }

      .header-3-3 .responsive li {
        padding: 1rem;
      }

      .header-3-3 .hr {
        padding-left: 2rem;
        padding-right: 2rem;
      }

      .header-3-3 .hero {
        padding: 4rem 2rem;
      }

      .header-3-3 .left-column {
        margin-bottom: 0.75rem;
        width: 100%;
      }

      .header-3-3 .title-text-big {
        font: 600 2.25rem / normal Poppins, sans-serif;
        margin-bottom: 1.25rem;
        color: #243142;
      }

      .header-3-3 .text-caption {
        font: 300 1rem/1.5rem Poppins, sans-serif;
        letter-spacing: 0.025em;
        color: #8B9CAF;
        margin-bottom: 5rem;
      }

      .header-3-3 .btn-get {
        font: 600 1rem/1.5rem Poppins, sans-serif;
        padding: 1rem 2rem;
        border-radius: 999px;
        border: 1px solid #4E91F9;
        background-color: #4E91F9;
        transition: 0.3s;
      }

      .header-3-3 .btn-get:hover {
        background-color: #6DA4F9;
        border: 1px solid #6DA4F9;
      }

      .header-3-3 .btn-outline {
        font: 400 1rem/1.5rem Poppins, sans-serif;
        padding: 1rem 1.5rem;
        border-radius: 999px;
        background-color: transparent;
        border: 1px solid #A6B1BE;
        color: #A6B1BE;
        transition: 0.3s;
      }

      .header-3-3 .btn-outline:hover {
        border: 1px solid #6DA4F9;
        color: #6DA4F9;
      }

      .header-3-3 .btn-outline:hover div path {
        fill: #6DA4F9;
      }

      .header-3-3 .btn-outline:hover div rect {
        stroke: #6DA4F9;
      }

      .header-3-3 .right-column {
        width: 100%;
      }

      .header-3-3 .hero-right {
        right: 2rem;
        bottom: 0;
      }

      .header-3-3 .card-outer {
        padding-left: 0;
        z-index: 1;
      }

      .header-3-3 .card {
        transition: 0.4s;
        top: 0px;
        left: 0px;
        background-color: #FFFFFF;
        padding: 1.25rem;
        border-radius: 0.75rem;
        width: 100%;
        margin-top: 2.5rem;
        box-shadow: -4px 4px 10px 0px rgba(224, 224, 224, 0.25);
      }

      .header-3-3 .card:hover {
        top: -3px;
        left: -3px;
        transition: 0.4s;
        box-shadow: -4px 8px 15px 0px rgba(167, 167, 167, 0.25);
      }

      .header-3-3 .card-name {
        font: 600 1rem/1.5rem Poppins, sans-serif;
        margin-bottom: 0.25rem;
      }

      .header-3-3 .card-job {
        font: 300 0.75rem/1rem Poppins, sans-serif;
        color: #aaa6a6;
        margin-bottom: 0;
      }

      .header-3-3 .card-price-left {
        font: 500 1rem/1.5rem Poppins, sans-serif;
        margin-bottom: 0.125rem;
        color: #1B8171;
      }

      .header-3-3 .card-caption {
        font: 300 0.75rem/1rem Poppins, sans-serif;
        color: #aaa6a6;
        margin-bottom: 0;
      }

      .header-3-3 .card-price-right {
        font: 500 1rem/1.5rem Poppins, sans-serif;
        margin-bottom: 0.125rem;
        color: #FF7468;
      }

      .header-3-3 .btn-hire {
        font: 600 1rem/1.5rem Poppins, sans-serif;
        padding: 0.75rem 4rem;
        border-radius: 0.75rem;
        margin-bottom: 0.125rem;
        border: 1px solid #4E91F9;
        background-color: #4E91F9;
        transition: 0.3s;
      }

      .header-3-3 .btn-hire:hover {
        background-color: #6DA4F9;
        border: 1px solid #6DA4F9;
      }

      .header-3-3 .form {
        border-radius: 999px;
        background-color: #eef4fd;
        box-sizing: border-box;
        font-size: 14px;
        padding: 0rem 1rem;
        padding-right: 0.5rem;
        outline: none;
      }

      .header-3-3 .form div input[type="text"] {
        background-color: #eef4fd;
        box-sizing: border-box;
        font-size: 14px;
        padding: 0rem 0.5rem;
        outline: none;
        width: 100%;
      }

      .header-3-3 .center-search {
        bottom: 0.5rem;
      }

      @media (min-width: 576px) {
        .header-3-3 .modal-item .modal-dialog {
          max-width: 95%;
          border-radius: 12px;
        }

        .header-3-3 .navbar {
          padding: 2rem;
        }

        .header-3-3 .title-text-big {
          font-size: 3rem;
          line-height: 1.2;
        }
      }

      @media (min-width: 768px) {
        .header-3-3 .navbar {
          padding: 2rem 4rem;
        }

        .header-3-3 .hr {
          padding-left: 4rem;
          padding-right: 4rem;
        }

        .header-3-3 .hero {
          padding: 4rem;
        }

        .header-3-3 .left-column {
          margin-bottom: 3rem;
        }

        .header-3-3 .hero-right {
          right: 4rem;
        }

        .header-3-3 .card {
          margin-left: auto;
          margin-top: 0;
        }
      }

      @media (min-width: 992px) {

        .header-3-3 .navbar-light .navbar-nav .active:before {
          content: "";
          position: absolute;
          margin-left: auto;
          margin-right: auto;
          left: 0;
          right: 0;
          text-align: center;
          bottom: 0;
          height: 0px;
          width: 80%;
          /* or 100px */
          border-bottom: 2px solid #4E91F9;
        }

        .header-3-3 .navbar {
          padding: 2rem 6rem;
        }

        .header-3-3 .navbar-light .navbar-nav .nav-link {
          padding: 0;
          margin-right: 1rem;
          margin-left: 1rem;
        }

        .header-3-3 .navbar-light .navbar-nav .active:before {
          width: 40%;
        }

        .header-3-3 .hr {
          padding-left: 6rem;
          padding-right: 6rem;
        }

        .header-3-3 .hero {
          padding: 4rem 6rem 5rem;
        }

        .header-3-3 .left-column {
          width: 50%;
          margin-bottom: 0;
        }

        .header-3-3 .title-text-big {
          font-size: 3.75rem;
          line-height: 1.25;
        }

        .header-3-3 .right-column {
          width: 50%;
        }

        .header-3-3 .hero-right {
          right: 6rem;
        }

        .header-3-3 .card-outer {
          padding-left: 4rem;
        }

        .header-3-3 .center-search {
          left: 48%;
          top: 50%;
          bottom: auto;
          transform: translate(-48%, -50%);
        }

        .header-3-3 .form {
          width: 340px;
        }
      }

      @media (max-width: 1023px) {
        .header-3-3 .form div input[type="text"] {
          width: 100%;
        }
      }
    </style>
    <div class="header-3-3 container-xxl mx-auto p-0 position-relative" style="font-family: 'Poppins', sans-serif">
      <nav class="navbar navbar-expand-lg navbar-light">
        <a href="#">
          <img style="margin-right: 0.75rem"
            src="http://api.elements.buildwithangga.com/storage/files/2/assets/Header/Header3/Header-3-6.png" alt="" />
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="modal" data-bs-target="#targetModal-item">
          <span class="navbar-toggler-icon"></span>
        </button>

        

      <div class="collapse navbar-collapse" id="navbarTogglerDemo">
          <ul class="navbar-nav mx-auto mt-2 mt-lg-0">
            <li class="nav-item position-relative">
              <a class="nav-link main=" href="#"></a>
            </li>
            <li class="nav-item position-relative">
              <a class="nav-link" href="#"></a>
            </li>
            <li class="nav-item position-relative">
              <a class="nav-link" href="#"></a>
            </li>
            <li class="nav-item position-relative">
              <a class="nav-link" href="#"></a>
            </li>
            <li class="nav-item my-auto">
              <a class="nav-link" data-bs-toggle="collapse" href="#collapse" role="button" aria-expanded="false"
                aria-controls="collapse">
                
              </a>
              <form class="collapse position-absolute form center-search border-0" id="collapse">
                <div class="d-flex">
                  <input type="text" class="rounded-full border-0 focus:outline-none" placeholder="Search" />
                  <button class="btn" type="button">
                    <svg style="width: 20px; height: 20px" data-bs-toggle="collapse" href="#collapse" role="button"
                      aria-expanded="false" aria-controls="collapse" fill="none" stroke="#273B56" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                      </path>
                    </svg>
                  </button>
                </div>
              </form>
            </li>
          </ul>
          <!-- <button class="btn btn-default btn-no-fill" href="form_login.php">Sign In</button> -->
          <a href="form_login.php" class="btn btn-default btn-no-fill" role="button" aria-pressed="true">Sign In</a>
          <a href="form_registrasi.php" class="btn btn-fill text-white" role="button" aria-pressed="true">Register</a>
          <!-- <button class="btn btn-fill text-white" href="form_registrasi.php">Register</button> -->
        </div>
      </nav>
      <div class="hr">
        <hr style="
              border-color: #F4F4F4;
              background-color: #F4F4F4;
              opacity: 1;
              margin: 0 !important;
            " />
      </div>

      <div>
        <div class="mx-auto d-flex flex-lg-row flex-column hero">
          <!-- Left Column -->
          <div
            class="left-column flex-lg-grow-1 d-flex flex-column align-items-lg-start text-lg-start align-items-center text-center">
            <h1 class="title-text-big">
              Cara Baru<br class="d-lg-block d-none" />
              <span style="color: #4E91F9">Meminjam Mobil</span> dar Kami<br class="d-lg-block d-none" />
              
            </h1>
            <p class="text-caption">
              Hard to find a good Cars according to your wishes?<br class="d-sm-block d-none" />Don't
              worry because we
              are here to help you
            </p>
            <div class="d-flex flex-sm-row flex-column align-items-center mx-auto mx-lg-0 justify-content-center gap-3">
              <button class="btn btn-get text-white d-inline-flex" href = "">
                Ayo Order
              </button>
              <!-- <button class="btn btn-outline">
                <div class="d-flex align-items-center">
                  <svg class="me-2" width="26" height="26" viewBox="0 0 26 26" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M15.9295 13L11.6668 10.158V15.842L15.9295 13ZM17.9175 13.2773L10.8515 17.988C10.8013 18.0214 10.743 18.0406 10.6828 18.0434C10.6225 18.0463 10.5627 18.0328 10.5095 18.0044C10.4563 17.9759 10.4119 17.9336 10.3809 17.8818C10.3499 17.8301 10.3335 17.771 10.3335 17.7107V8.28933C10.3335 8.22904 10.3499 8.16988 10.3809 8.11816C10.4119 8.06644 10.4563 8.0241 10.5095 7.99564C10.5627 7.96718 10.6225 7.95367 10.6828 7.95655C10.743 7.95943 10.8013 7.9786 10.8515 8.012L17.9175 12.7227C17.9631 12.7531 18.0006 12.7943 18.0265 12.8427C18.0524 12.8911 18.0659 12.9451 18.0659 13C18.0659 13.0549 18.0524 13.1089 18.0265 13.1573C18.0006 13.2057 17.9631 13.2469 17.9175 13.2773Z"
                      fill="#A6B1BE" />
                    <rect x="0.5" y="0.5" width="25" height="25" rx="12.5" stroke="#A6B1BE" />
                  </svg>
                  Watch the video
                </div>
              </button> -->
            </div>
          </div>

          <!-- Right Column -->
          <div class="right-column d-flex justify-content-center justify-content-lg-start text-center pe-0">
            <img class="position-absolute d-lg-block d-none hero-right"
              src="http://api.elements.buildwithangga.com/storage/files/2/assets/Header/Header3/Header-3-2.png"
              alt="" />
            <!-- <div class="d-flex align-items-end card-outer">
              <div class="mx-auto d-flex flex-wrap align-items-center">
                <div class="card border-0 position-relative d-flex flex-column">
                  <div class="d-flex align-items-center" style="margin-bottom: 1.25rem">
                    <div>
                      <img style="margin-right: 1rem"
                        src="http://api.elements.buildwithangga.com/storage/files/2/assets/Header/Header3/Header-3-3.png"
                        alt="" />
                    </div>
                    <div class="text-start">
                      <p class="card-name">Felix Potah</p>
                      <p class="card-job">Pro Mentor</p>
                    </div>
                  </div>
                  <div class="row text-start" style="margin-bottom: 1.25rem">
                    <div class="col-6">
                      <p class="card-price-left">64,100</p>
                      <p class="card-caption">Followers</p>
                    </div>
                    <div class="col-6 ps-0">
                      <p class="card-price-right">106</p>
                      <p class="card-caption">Reviews</p>
                    </div>
                  </div>
                  <button class="btn btn-hire text-white">
                    <div class="test d-none">show</div>
                    Hire Me
                  </button>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </section> 
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    </body>
  </html>