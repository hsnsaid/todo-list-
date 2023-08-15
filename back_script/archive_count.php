<?php
session_start();
if(! isset($_SESSION)){
    session_destroy();
    header('Loction: ../login.html');
}
else {
    include 'db.php';
    $result=$pdo->prepare("SELECT count(*) AS task_numbers , task_category  FROM task WHERE task_id = :user_id AND status='done' GROUP BY task_category");
    $result->bindParam(":user_id", $_SESSION['user_id']);
    $result->execute();
    $reponse=$result->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($reponse);
}
$pdo=null;