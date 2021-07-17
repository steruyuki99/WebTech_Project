<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require 'vendor/autoload.php'; // '../vendor/autoload.php';
require 'db.php';

$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello World");
    return $response;
});

$app->get('/event', function ($request,  $response, $args) {
    // $response->getBody()->write("this will return all users");
    // return $response;

    $sql = "SELECT * FROM imagelink";
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

$app->get('/getBannerData', function (Request $request, Response $response, array $args) {
	$response->getBody()->write("this will return all users");
    return $response;
    class Banner
    {
        public $id = "";
        public $bannerURL = "";
    }

    $data = array();

    try{
        $db = new db();
        $db = $db->connect();
        $stmt = $db->query("SELECT * FROM imagelink");
            while ($row = $stmt->fetch()){
        //create an object/instance user of class Book
                $banner = new Banner();
        //populate the data/properties of object book
                $banner->bannerURL = $row['link'];
                $banner->id = $row['id'];
                array_push($data,$banner);
        }
    }catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }

    echo json_encode($data);
});


$app->post('/addBannerData', function (Request $request, Response $response, array $args){
    $link = $_POST["imageURL"];

    try{
        $sql = "INSERT INTO imagelink (link, id) VALUES (:link, NULL)";
        $db = new db();

        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':link', $link);
        $stmt->execute();
        $count = $stmt->rowCount();
        $db = null;
    
        $data = array(
            "status" => "success",
            "rowcount" => $count
        );
            
            echo json_encode($data);
        } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        
            echo json_encode($data);
        }
});


$app->delete('/deleteBannerData/{id}', function (Request $request, Response $response, array $args){
    $id = $args['id'];
    $sql = "DELETE FROM imagelink WHERE id = $id";

    try{
        $sql = "DELETE FROM imagelink WHERE id = $id";
        $db = new db();

        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt -> execute();
        $count = $stmt->rowCount();
     
        $db = null;
        $data = array(
            "rowAffected" => $count,
            "status" => "success"
        );
            
        echo json_encode($data);
    }catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        ); echo json_encode($data);
    }
});
$app->run();