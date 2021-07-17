<?php
//AHMAD SYAHIR BIN ABDUL HANIM
//A18CS0017
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'db.php';
$app = new \Slim\App;
//API #0 root doc
$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello there from root");
    return $response;
});

//API Login

$app->get('/GET/users/email={email}/pass={password}', function (Request $request, Response $response, $args) {
    session_start();
    $email = $args['email'];
    $password = $args['password'];

    if(!empty($email) && !empty($password)){
        $sql = "SELECT * FROM users WHERE email = $email";
        try {
            // Get DB Object
            $db = new db();
            // Connect
            $db = $db->connect();
    
            $stmt = $db->query($sql);
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            $user_pass = $user->password;
                $status = "Active now";
                $sql2 = "UPDATE users SET status = :status WHERE email = $email";
                $stmt = $db->prepare($sql2);
                $stmt->bindParam(':status', $status);
                $stmt->execute();
                $count = $stmt->rowCount();
                if($sql2){
                    $_SESSION['unique_id'] = $user->unique_id;
                    echo "success";
                }else{
                    echo "Something went wrong. Please try again!";
                }
            $db = null;
            echo json_encode($user);
        } catch (PDOException $e) {
            $data = array(
                "status" => "fail"
            );
            echo json_encode($user->unique_id);
        }
    }

});
//API getMessage
$app->get('/GET/users/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['email'];

    $sql = "SELECT * FROM users WHERE email = $email";

    try {
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($user);
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
});

// API #3 POST
$app->post('/POST/users', function (Request $request, Response $response, array $args) {
    

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    $p_name = $input["p_name"];
    $p_age = $input["p_age"];
    $p_sex = $input["p_sex"];
    $admission_date = $input["admission_date"];
    $icu_admission = $input["icu_admission"];
    $clinical_death = $input["clinical_death"];
    $discharge_date = $input["discharge_date"];
    $status = $input["status"];
    $phone_num = $input["phone_num"];
    $marital_status = $input["marital_status"];


    echo $p_name;


    try {
        $sql = "INSERT INTO patients (p_name,p_age,p_sex,admission_date,icu_admission, clinical_death, discharge_date, phone_num, marital_status, status) VALUES (:p_name,:p_age,:p_sex,:admission_date,:icu_admission, :clinical_death, :discharge_date, :phone_num, :marital_status, :status)";
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':p_name', $p_name);
        $stmt->bindValue(':p_age', $p_age);
        $stmt->bindValue(':p_sex', $p_sex);
        $stmt->bindValue(':admission_date', $admission_date);
        $stmt->bindValue(':icu_admission', $icu_admission);
        $stmt->bindValue(':clinical_death', $clinical_death);
        $stmt->bindValue(':discharge_date', $discharge_date);
        $stmt->bindValue(':phone_num', $phone_num);
        $stmt->bindValue(':marital_status', $marital_status);
        $stmt->bindValue(':status', $status);

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
        echo $e;
    }
});


// API #4 UPDATE
$app->put('/PUT/users/{unique_id}', function (Request $request, Response $response, array $args) {
    $id = $args['unique_id'];

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    $p_name = $input["p_name"];
    $p_age = $input["p_age"];
    $p_sex = $input["p_sex"];
    $phone_num = $input["phone_num"];
    $marital_status = $input["marital_status"];

    $sql = "UPDATE patients SET p_name = :p_name, 
    p_age = :p_age, 
    p_sex = :p_sex, phone_num = :phone_num, marital_status = :marital_status WHERE id = $id";

    try {
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':p_name', $p_name);
        $stmt->bindParam(':p_age', $p_age);
        $stmt->bindParam(':phone_num', $phone_num);
        $stmt->bindParam(':marital_status', $marital_status);
        $stmt->bindParam(':p_sex', $p_sex);


        $stmt->execute();
        $count = $stmt->rowCount();

        $data = array(
            "rowAffected" => $count,
            "status" => "success"
        );
        echo json_encode($data);
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
});


// API #5 UPDATE STATUS
$app->put('/PUT/patients/status/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    $status = $input["status"];

    $sql = "UPDATE patients SET status = :status
    WHERE id = $id";


try {

    $db = new db();
    $db = $db->connect();

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':status', $status);


    $stmt->execute();
    $count = $stmt->rowCount();

    $data = array(
        "rowAffected" => $count,
        "status" => "success"
    );
    echo json_encode($data);
} catch (PDOException $e) {
    $data = array(
        "status" => "fail"
    );
    echo json_encode($data);
}


 });


$app->run();
