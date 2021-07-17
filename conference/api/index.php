<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require 'vendor/autoload.php';
require 'db.php';

$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello World");
    return $response;
});

$app->get('/getUser', function (Request $request, Response $response, array $args) {
    $sql = "SELECT * FROM user";

    try {
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        // $response->getBody()->write(json_encode($user));
        // return $response;
        echo json_encode($user);

    } catch(PDOException $e) {
        $error = array(
            "status" => "fail"
        );
        echo json_encode($error);
    }
});

$app->get('/getUser/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $sql = "SELECT * FROM user WHERE id = $id";

    try {
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        // $response->getBody()->write(json_encode($user));
        // return $response;
        echo json_encode($user);

    } catch(PDOException $e) {
        $error = array(
            "status" => "fail"
        );
        echo json_encode($error);
    }
});

$app->post('/addUser', function (Request $request, Response $response, array $args) {
    // $putParams = $request->getParsedBody();
    // $fullname = $putParams['fullname'];
    // $username = $putParams['username'];
    // $email = $putParams['email'];
    // $phone = $putParams['phone'];
    // $pass = $putParams['pass'];
    // $gender = $putParams['gender'];

    $fullname = $_POST["fullname"];
    $username = $_POST["username"];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass = $_POST['pass'];
    $gender = $_POST['gender'];

    $sql = "INSERT INTO user (fullname, username, email, phone, pass, gender) VALUE (:fullname, :username, :email, :phone, :pass, :gender)";

    try {
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $stmt -> bindValue(':fullname', $fullname);
        $stmt -> bindValue(':username', $username);
        $stmt -> bindValue(':email', $email);
        $stmt -> bindValue(':phone', $phone);
        $stmt -> bindValue(':pass', $pass);
        $stmt -> bindValue(':gender', $gender);
        // $stmt -> bindParam(':fullname', $fullname);
        // $stmt -> bindParam(':username', $username);
        // $stmt -> bindParam(':email', $email);
        // $stmt -> bindParam(':phone', $phone);
        // $stmt -> bindParam(':pass', $pass);
        // $stmt -> bindParam(':gender', $gender);

        $result = $stmt->execute();
        $db = null;

        echo json_encode($result);

    } catch(PDOException $e) {
        $error = array(
            "status" => "fail"
        );
        echo json_encode($error);
    }
});

$app->post('/login', function (Request $request, Response $response, array $args) {
    $username = $_POST["username"];
    $pass = $_POST['pass'];
    // $putParams = $request->getParsedBody();
    // $username = $putParams['username'];
    // $pass = $putParams['pass'];

    session_start();

    $sql = "SELECT id, username FROM user WHERE username = (:username) AND pass = (:pass)";

    try {
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $stmt -> bindValue(':username', $username);
        $stmt -> bindValue(':pass', $pass);

        $stmt->execute();
        $id = $stmt->fetch();
        $db = null;

        $_SESSION["id"] = $id;
        $_SESSION["username"] = $username;
        echo json_encode($id);
    } catch(PDOException $e) {
        $error = array(
            "status" => "fail"
        );
        echo json_encode($error);
    }
});

$app->post('/addMeeting', function (Request $request, Response $response, array $args) {
    $username = $_POST["username"];
    $meetingname = $_POST['meetingname'];
    $pass = $_POST['pass'];
    // $putParams = $request->getParsedBody();
    // $username = $putParams['username'];
    // $meetingname = $putParams['meetingname'];
    // $pass = $putParams['pass'];

    session_start();

    $sql = "INSERT INTO meeting (username, meetingname, pass) VALUE (:username, :meetingname, :pass)";

    try {
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $stmt -> bindValue(':username', $username);
        $stmt -> bindValue(':meetingname', $meetingname);
        $stmt -> bindValue(':pass', $pass);

        $result = $stmt->execute();
        $db = null;

        echo json_encode($result);
    } catch(PDOException $e) {
        $error = array(
            "status" => "fail"
        );
        echo json_encode($error);
    }
});

$app->run();