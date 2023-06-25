<?php

session_start();
if (!(isset($_SESSION) && $_SESSION['active'])){ 
  session_destroy();
  header('Location: ./');
} 

include 'back_script/db.php';

  $html = file_get_contents("templates/__GENERIC__.html", true);
  $link = "<link rel='stylesheet' href='css/category.css'>
    <link rel='stylesheet' media='screen and (max-width:400px)' href='css/category_mobile.css' >
  ";
  
  $html = str_replace(['$$link$$', '$$archive$$', '$$script$$', '$$title$$'], [$link, 'checked', '','categories'], $html);

  $query = "SELECT * FROM task WHERE task_id = $_SESSION[user_id] AND task_category= '$_GET[category]' AND status='done' ";
  $result = $conn->query($query)->fetch_all(MYSQLI_BOTH);

  $main_html =
    '<section class="main-category scrolling">
      <table class="main-category-container">
        <thead>
          <tr>
            <th>Task Name</th>
            <th>Task Date</th>
          </tr>
        </thead>
        <tbody>';
  foreach ($result as $row) :
    $main_html .= "<tr><td>$row[task_name]</td><td>$row[dead_line]</td></tr>";
  endforeach;
  $main_html .=
    '   </tbody>
      </table>
    </section>';

  $final_html = str_replace('$$main$$', $main_html, $html);

  $conn->close();
  echo $final_html;