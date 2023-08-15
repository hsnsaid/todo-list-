<?php
try{
  $dns="mysql:host=localhost;dbname=todo_list;user=root";
  $pdo=new PDO($dns);
  }
  catch(PDOException $e){
    throw new PDOException($e->getMessage());
}