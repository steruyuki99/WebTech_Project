<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require 'vendor/autoload.php'; // '../vendor/autoload.php';
require 'db.php';


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