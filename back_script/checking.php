<?php
include 'db.php';
$auth_type = $_POST['auth'];
$password = $_POST['password'];
if($auth_type == 'login'){
$user_info = $_POST['user'];
$query = "SELECT id FROM person WHERE (email = '$user_info' OR name = '$user_info') AND password ='$password'";
$result = $conn->query($query);
    if (mysqli_num_rows($result) == 1  ) {
        session_start(); 
        $_SESSION['active'] = true;
        $_SESSION['user_id'] = $result->fetch_array(MYSQLI_BOTH)['id'];
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
    $query = "SELECT id FROM person WHERE email = '$email' OR name = '$username'";
    $result = $conn->query($query);
     if(mysqli_num_rows($result) == 0){
        $stmt = $conn->prepare("INSERT INTO person (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        $stmt->execute();
        session_start(); 
        $query_id = "SELECT id FROM person WHERE email = '$email' OR name = '$username'";
        $result_id = $conn->query($query_id);
        $_SESSION['active'] = true;
        $_SESSION['user_id'] = $result_id->fetch_array(MYSQLI_BOTH)['id'];
            $array = [
            'status'=>false,
            'location'=>'category.php'
        ];
        echo json_encode($array);}

     else{
        $array =['status'=>TRUE];
        header("Content-Type: application/json");
        echo json_encode($array);   
     }
}
$conn->close();