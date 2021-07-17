<?php
    session_start();
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "chatapp";
    
    $conn = mysqli_connect($hostname, $username, $password, $dbname);
    if(!$conn){
        echo "Database connection error".mysqli_connect_error();
    }
    if(isset($_SESSION['unique_id'])){
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        if(isset($logout_id)){
            $status = "Offline now";
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$_GET['logout_id']}");
            if($sql){
                session_unset();
                session_destroy();
                header("location: ../login.php");
            }
        }else{
            header("location: ../users.php");
        }
    }else{  
        header("location: ../login.php");
    }
?>