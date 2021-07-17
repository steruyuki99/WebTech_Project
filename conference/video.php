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
            <!-- <h6>Year: <span id="currentYear"></span>&nbsp;&nbsp;&nbsp;&nbsp;Date: <span id="currentDate"></span></h6> -->
        </div>

        <!-- <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="#">About</a>
            <a href="#">Services</a>
            <a href="#">Clients</a>
            <a href="#">Contact</a>
        </div>

        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span> -->
        <div class="container-fluid mt-5 position-absolute top-50 start-50 translate-middle text-center">
            <h3><?php echo $_SESSION['username'] ?></h3>
            <!-- <video id="video" autoplay></video> -->
            <p><span id="errorMsg"></span></p>
    
            <!-- Stream video via webcam -->
            <div>
                <video id="video" playsinline autoplay></video>
            </div>

            <!-- Trigger canvas web API -->
            <div class="controller">
                <a href="index.html" class="btn btn-primary mt-1 mb-2">Log Out</a>
            </div>

            <div class="col">
                <a href="meeting.html" class="btn btn-secondary">Back</a>
            </div>

            <!-- Webcam video snapshot -->
            <!-- <canvas id="canvas" width="640" height="480"></canvas> -->
        </div>
        </div>
        <script>
            'use strict';

            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const snap = document.getElementById("snap");
            const errorMsgElement = document.querySelector('span#errorMsg');

            const constraints = {
                audio: false,
                video: {
                    width: 1920, height: 1080
                }
            };

            // Access webcam
            async function init() {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia(constraints);
                    handleSuccess(stream);
                } catch (e) {
                    errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
                }
            }

            // Success
            function handleSuccess(stream) {
                window.stream = stream;
                video.srcObject = stream;
            }

            // Load init
            init();

            // Draw image
            var context = canvas.getContext('2d');
            snap.addEventListener("click", function() {
                context.drawImage(video, 0, 0, 640, 480);
            });
        </script>
    </body>

    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }
        
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>
</html>