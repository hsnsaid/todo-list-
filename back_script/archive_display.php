<?php
session_start();
if(! isset($_SESSION)){
    session_destroy();
    header('Loction: ../login.html');
}
else {
include 'db.php';
$category = $_POST['task-category'];
$query = "SELECT task_name, FROM task WHERE task_id = $_SESSION[user_id] AND task_category= '$category' AND AND status='done' ";
$result = $conn->query($query);
$reponse= $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($reponse);
}
$conn->close();