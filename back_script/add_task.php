<?php
session_start();
 if(! isset($_SESSION)){
    session_destroy();
    header('Loction: ../login.html');
}
else{
    include 'db.php';
    $name = $_POST['task-name'];
    $category = $_POST['task-category'];
    $date = $_POST['task-date'];
    $stmt = $pdo->prepare("INSERT INTO task (task_name, task_category, dead_line, task_id) VALUES (:task_name, :task_category, :dead_line, :user_id)");
    $stmt->bindParam(":task_name", $name);
    $stmt->bindParam(":task_category", $category);
    $stmt->bindParam(":dead_line", $date);
    $stmt->bindParam(":user_id",$_SESSION['user_id']);
    $stmt->execute();
    $array =['checking'=>TRUE];
    header("Content-Type: application/json");
    echo json_encode($array); 
}
$pdo=null;