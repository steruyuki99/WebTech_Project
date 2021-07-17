<!DOCTYPE html>

<?php 
  session_start();
?>

<html>
    <head>
        <title>Video Conference</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"crossorigin="anonymous">
        <style>
            body {
              font-family: "Lato", sans-serif;
            }
            
            .sidenav {
              height: 100%;
              width: 0;
              position: fixed;
              z-index: 1;
              top: 0;
              left: 0;
              background-color: #111;
              overflow-x: hidden;
              transition: 0.5s;
              padding-top: 60px;
            }
            
            .sidenav a {
              padding: 8px 8px 8px 32px;
              text-decoration: none;
              font-size: 25px;
              color: #818181;
              display: block;
              transition: 0.3s;
            }
            
            .sidenav a:hover {
              color: #f1f1f1;
            }
            
            .sidenav .closebtn {
              position: absolute;
              top: 0;
              right: 25px;
              font-size: 36px;
              margin-left: 50px;
            }
            
            @media screen and (max-height: 450px) {
              .sidenav {padding-top: 15px;}
              .sidenav a {font-size: 18px;}
            }
        </style>
    </head>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
            crossorigin="anonymous">
    </script>

    <script>
        function getDate() {
            var year = today.getFullYear();
            var date = today.getDate() + " / " + today.getMonth();
            document.getElementById("currentYear").innerHTML = year;
            document.getElementById("currentDate").innerHTML = date;
        }
        var today = new Date();
    </script>

    <body onload="getDate()">
      <div class="container">
        <div class="container-fluid text-center pt-3">
            <h1>Video Conference</h1>
            <hr>
            <h6>Year: <span id="currentYear"></span>&nbsp;&nbsp;&nbsp;&nbsp;Date: <span id="currentDate"></span></h6>
        </div>

        <div class="container-fluid">
          <div class="position-absolute top-50 start-50 translate-middle">
            <div class="text-center">
              <h1>Hello <?php echo $_SESSION['username'] ?> </h1>
            </div>
            <div class="card" style="width: 30rem;">
              <div class="card-header text-center">
                  Create Meeting
              </div>
              <div class="card-body">
                <div class="row justify-content-around my-4">
                  <div class="col">
                      Meeting Name:
                      <input type="text" class="form-control" id="meetingname" placeholder="Enter your meeting name">
                  </div>
                </div>
                <div class="row justify-content-around my-4">
                  <div class="col">
                      <label for="pass" class="form-label">Meeting Password:</label>
                      <input type="password" class="form-control" id="pass" placeholder="Enter your password">
                  </div>
                  <div class="col">
                      <label for="confirm" class="form-label">Confirm Password:</label>
                      <input type="password" class="form-control" id="confirm" placeholder="Confirm your password">
                  </div>
                </div>
                <div class="row text-center mt-4 mb-3">
                    <div class="col">
                        <button type="submit" class="btn btn-secondary" id="add">Register</button>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="#">About</a>
            <a href="#">Services</a>
            <a href="#">Clients</a>
            <a href="#">Contact</a>
        </div>

        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span> -->
      </div>
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script
          src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
          integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
          crossorigin="anonymous"
        ></script>
        <script
          src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
          integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
          crossorigin="anonymous"
        ></script>
    </body>

    <script>
      document.getElementById("add").addEventListener("click", function() {
          var username = '<%= Session["username"] %>'
          var meetingname = $("#meetingname").val();
          var pass = $("#pass").val();
          
          $.ajax({
              type: "POST",
              url: "api/addMeeting",
              data: {
                  "username": username,
                  "meetingname": meetingname,
                  "pass": pass,
              },
              dataType: "json",
              success: function(data, status, xhr) {
                  alert("Hello");
                  window.location.replace("http://localhost/videoConference/video.php");
              },
              error: function(data, status, xhr) {
                  alert(xhr)
              }
          })
      });
    </script>

    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }
        
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>
</html>