<?php
session_start();
if(! isset($_SESSION)){
    session_destroy();
    header('Loction: ../login.html');
}
else {
include 'db.php';
// $query = "SELECT count(*) AS task_per_status , status FROM task WHERE task_id = $_SESSION[user_id] GROUP BY status";
// $result = $conn->query($query);
// $reponse= $result->fetch_all(MYSQLI_ASSOC);
$result=$pdo->prepare("SELECT count(*) AS task_per_status , status FROM task WHERE task_id = :user_id  GROUP BY status");
$result->bindParam(":user_id", $_SESSION['user_id']);
$result->execute();
$reponse=$result->fetchAll(PDO::FETCH_ASSOC);
   $result = [];
for ($x = 0; $x < count($reponse); $x++) {
  $key = strtolower($reponse[$x]['status']);
  $value = $key . ' tasks';
  $num = $reponse[$x]['task_per_status'];
  $arr = [
    $key => $value,
    $key . "_num" => $num
  ];
  $result = array_merge($result, $arr);
}
if (!array_key_exists('done', $result)) {
  $arr = [
    'done' => 'done tasks',
    'done_num' => 0
  ];
  $result = array_merge($result, $arr);
}
if (!array_key_exists('pending', $result)) {
  $arr = [
    'pending' => 'pending tasks',
    'pending_num' => 0
  ];
  $result = array_merge($result, $arr);
}
echo json_encode($result);
}
$pdo=null;