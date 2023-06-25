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
    $stmt = $conn->prepare("INSERT INTO task (task_name, task_category, dead_line, task_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $category, $date, $_SESSION['user_id']);
    $stmt->execute();
    $array =['checking'=>TRUE];
    header("Content-Type: application/json");
    echo json_encode($array); 
}
$conn->close();