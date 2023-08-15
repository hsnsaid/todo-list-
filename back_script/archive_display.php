<?php
session_start();
if(! isset($_SESSION)){
    session_destroy();
    header('Loction: ../login.html');
}
else {
include 'db.php';
$category = $_POST['task-category'];
$result=$pdo->prepare("SELECT task_name, FROM task WHERE task_id = :user_id AND task_category= :category AND status='done'");
$result->bindParam(":user_id", $_SESSION['user_id']);
$result->bindParam(":task_category", $category);
$result->execute();
$reponse=$result->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($reponse);
}
$pdo=null;