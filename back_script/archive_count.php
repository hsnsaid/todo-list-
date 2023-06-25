<?php
session_start();
if(! isset($_SESSION)){
    session_destroy();
    header('Loction: ../login.html');
}
else {
include 'db.php';
$query = "SELECT count(*) AS task_numbers , task_category  FROM task WHERE task_id = $_SESSION[user_id] AND status='done' GROUP BY task_category";
$result = $conn->query($query);
$reponse= $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($reponse);
}
$conn->close();