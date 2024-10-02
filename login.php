<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();

$system = $conn->query("SELECT * FROM system_settings")->fetch_array();
foreach($system as $k => $v){
  $_SESSION['system'][$k] = $v;
}
ob_end_flush();

if(isset($_SESSION['login_id']))
  header("location:index.php?page=home");

include 'header.php'; 
?>
<head>
  <style>
    body {
      margin: 0;
      padding: 0;
      overflow: hidden; /* Prevent scrolling */
    }

    .bg-slider {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: -1;
    }

    .slide {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
      display: none; /* Hide slides by default */
      filter: blur(2px); /* Adjust the blur level */
    }

    .slide:first-child {
      display: block; /* Show the first slide */
    }

    .login-box {
    position: relative; 
    z-index: 1; 
    padding: 20px; 
    background: rgba(255, 255, 255, 0.8); 
    border-radius: 10px; 
    text-align: center; /* Center all content inside */
  }

  .create-account-btn {
    display: inline-block; 
    background: linear-gradient(45deg, #6a11cb, #2575fc); 
    color: white; 
    border: none; 
    border-radius: 5px; 
    padding: 10px 20px; 
    font-size: 16px; 
    transition: background 0.3s; 
  }

  .create-account-btn:hover {
    background: linear-gradient(45deg, #2575fc, #6a11cb); 
    color:white;
  }
  </style>
</head>
<body class="hold-transition login-page">
  
  <div class="bg-slider">
    <div class="slide" style="background-image: url('https://technext24.com/wp-content/uploads/2020/05/Nigerian-Unversities-Lecture-room.png');"></div>
    <div class="slide" style="background-image: url('https://images.theconversation.com/files/353862/original/file-20200820-18-rr2gen.jpg?ixlib=rb-4.1.0&q=45&auto=format&w=926&fit=clip');"></div>
    <div class="slide" style="background-image: url('https://dailytrust.com/wp-content/uploads/2021/01/university-education-in-Nigeria-2.jpg');"></div>
  </div>

  <div class="login-box">
  <div class="login-logo">
    <img src="http://localhost/eval/assets/uploads/PSA.png" alt="Logo" style="width: 100px; height: auto;">
  </div>
  <h5 class="text-center" style="color: black;"><b>Evaluation System - Login</b></h5>

  <div class="card">
    <div class="card-body login-card-body">
      <form action="" id="login-form">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" required placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" required placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="form-group mb-3">
          <label for="">Login As</label>
          <select name="login" class="custom-select custom-select-sm">
            <option value="3">Student</option>
            <option value="2">Lecturer</option>
            <option value="1">Admin</option>
          </select>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">Remember Me</label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>
      <div class="text-center mt-3"> <!-- Centering the button -->
        <a href="create_account.php" class="create-account-btn">Create Account</a>
      </div>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

<script>
  $(document).ready(function(){
    $('#login-form').submit(function(e){
      e.preventDefault();
      start_load();
      if($(this).find('.alert-danger').length > 0)
        $(this).find('.alert-danger').remove();
      $.ajax({
        url:'ajax.php?action=login',
        method:'POST',
        data:$(this).serialize(),
        error: err => {
          console.log(err);
          end_load();
        },
        success: function(resp){
          if(resp == 1){
            location.href ='index.php?page=home';
          } else {
            $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
            end_load();
          }
        }
      });
    });

    // Background slider logic
    let currentIndex = 0;
    const slides = document.querySelectorAll('.slide');
    const totalSlides = slides.length;

    function showSlide(index) {
      slides.forEach((slide, i) => {
        slide.style.display = i === index ? 'block' : 'none';
      });
    }

    function nextSlide() {
      currentIndex = (currentIndex + 1) % totalSlides;
      showSlide(currentIndex);
    }

    showSlide(currentIndex);
    setInterval(nextSlide, 5000); // Change slide every 5 seconds
  });
</script>
<?php include 'footer.php'; ?>
</body>
</html>
