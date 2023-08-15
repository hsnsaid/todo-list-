<?php
include 'db.php';
$auth_type = $_POST['auth'];
$password = $_POST['password'];
if($auth_type == 'login'){
$user_info = $_POST['user'];
$result=$pdo->prepare("SELECT id FROM person WHERE (email = :user_info OR name = :user_info) AND password =:password");
$result->bindParam(":user_info", $user_info);
$result->bindParam(":password", $password);
$result->execute();
    if ($result->rowCount() == 1) {
        session_start(); 
        $_SESSION['active'] = true;
        $_SESSION['user_id'] = $result->fetch(PDO::FETCH_ASSOC)['id'];
             $response = [
            "status" => false,
            "location" => "category.php"
        ];
        echo json_encode($response);}
     else {
    $array =['status'=>TRUE];
    header("Content-Type: application/json");
    echo json_encode($array);
    }
}
else{
    $email = $_POST['email'];
    $username = $_POST['user'];
    $result=$pdo->prepare("SELECT id FROM person WHERE email = :email OR name = :username");
    $result->bindParam(":email",$email);
    $result->bindParam(":username",$username);
    $result->execute();
     if($result->rowCount() == 0){
        try{
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("INSERT INTO person (name, email, password) VALUES (:name, :email, :password)");
            $stmt->bindParam(":email",$email);
            $stmt->bindParam(":name",$username);
            $stmt->bindParam(":password",$password);
            $stmt->execute();
            session_start(); 
            $stmt_id =$pdo->prepare("SELECT id FROM person WHERE email =:email OR name =:name");
            $stmt_id->bindParam(":email",$email);
            $stmt_id->bindParam(":name",$username);
            $stmt_id->execute();
            $_SESSION['active'] = true;
            $_SESSION['user_id'] = $stmt_id->fetch(PDO::FETCH_BOTH)['id'];
                $array = [
                'status'=>false,
                'location'=>'category.php'
            ];
            echo json_encode($array);
            $pdo->commit();
        }
        catch(PDOException $e){
            $pdo->rollback();
            die($e->getMessage());
        }
    }
     else{
        $array =['status'=>TRUE];
        header("Content-Type: application/json");
        echo json_encode($array);   
     }
}
$pdo=null;