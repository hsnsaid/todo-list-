 <?php
session_start();
if(! isset($_SESSION)){
    session_destroy();
    header('Loction: ../login.html');
}
else {
    include 'db.php';
    $opartion_type=$_POST['task_operation'];
    $name=$_POST['task_name'];
    if($opartion_type=='delete'){
        $stmt=$pdo->prepare("DELETE FROM task WHERE task_id =:user_id AND task_name= :name");
        $stmt->bindParam(":user_id",$_SESSION['user_id']);
        $stmt->bindParam(":name",$name);
        $stmt->execute();
        $array = ["operation_status" => TRUE,"message" => "the task $name has been deleted "];
        header("Content-Type: application/json");
        echo json_encode($array); 
    } 
    else{
        $stmt=$pdo->prepare("UPDATE task SET status = 'done' WHERE task_id =:user_id AND task_name= :name");
        $stmt->bindParam(":user_id",$_SESSION['user_id']);
        $stmt->bindParam(":name",$name);
        $stmt->execute();
        $array = ["operation_status" => TRUE,"message" => "the task $name has been done "];
        header("Content-Type: application/json");
        echo json_encode($array); 
    }
}
$pdo=null;