<?php 
  session_start();
  if(isset($_SESSION['unique_id'])){
    header("location: users.php");
  }
?>

<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="form login">
      <header>Sparta Message</header>
      <form id="login">
        <div class="error-text"></div>
        <div class="field input">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="Enter your email" required>
        </div>
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter your password" required>
          <i class="fas fa-eye"></i>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="login">
        </div>
      </form>
      <div class="link">Not yet signed up? <a href="index.html">Signup now</a></div>
    </section>
  </div>
  
  <script src="javascript/pass-show-hide.js"></script>
  <script>
  $("#login").submit(function (event) {
  event.preventDefault();
  var email = document.getElementsByName("email")[0].value;
  email = email.replace();
  var password = document.getElementsByName("password")[0].value;
  var formData = $(this).serialize();
  $.ajax({
    type: "GET",
    url: "http://localhost/api/GET/users/email='" + email +"'/pass='"+password+"'",
    data: formData,
    dataType: "json",
    success: function (data, status, xhr) {
      if (status == 'success') {
          alert("ok, successfully login");
          window.location.href = "index.html";
        } else {
          alert(status);
          alert("fail to login, " + data.errormessage);
        }
    },
  });
}); 
  </script>

</body>
</html>
