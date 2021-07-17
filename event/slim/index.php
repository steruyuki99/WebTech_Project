<?php
require 'vendor/autoload.php';
require 'db.php';

$app = new \Slim\App;


//PUT - update/modif user based on id
$app->put('/user/{id}',function($request, $response, $args){
    $id = $args['id'];
    //connect to database
    //sql update based on id etc....
    //return the status update berjaya/tidak, as a response

});

$app->get('/events', function ($request,  $response, $args) {
    // $response->getBody()->write("this will return all users");
    // return $response;

    $sql = "SELECT * FROM event";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($user);
    }catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
});

$app->post('/addEvent',function($request, $response, $args){
    //connect to database
    $db = new db();
    $db = $db->connect();
    //sql insert etc....
$event = $_POST["event"];
$time = $_POST["time"];
$date = $_POST["date"];

// $inputJSON = file_get_contents('php://input');
// $input = json_decode($inputJSON, TRUE);
// $name = $input["name"];


    try {
        $sql = "INSERT INTO event (event_name, date, time) VALUES ('$event','$date','$time')";
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':event_name', $event);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':time', $time);
        $stmt->execute();
        $count = $stmt->rowCount();
        $db = null;
    
        $data = array(
            "status" => "success",
            "rowcount" =>$count
        );
        echo json_encode($data);
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
        

    //return the status insert berjaya/tidak, as a response
    // $response->getBody()->write("this operation will insert user ti database table");
    // return $response;
});

$app->post('/deleteEvent',function($request, $response, $args){
    //connect to database
    $db = new db();
    $db = $db->connect();
    //sql insert etc....
$event = $_POST["event"];


    try {
        $sql = "DELETE FROM event WHERE event_name='$event'";
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':event_name', $event);
        
        $stmt->execute();
        $count = $stmt->rowCount();
        $db = null;
    
        $data = array(
            "status" => "success",
            "rowcount" =>$count,
            
        );
        
        echo json_encode($data);
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }

});

$app->delete('/deleteEvent/{id}',function($request, $response, $args){
    $id = $args['id'];
    //connect to database
    $db = new db();
    $db = $db->connect();

    //sql delete based on id etc....
    $sql = "DELETE FROM event WHERE id='$id'";
    $stmt = $db->query($sql);
    //return the status delete berjaya/tidak, as a response
    $response->getBody()->write("this operation will delete event with ID : $id");

    return $response;
});

$app->run();