<?php
session_start();
if (!(isset($_SESSION) && $_SESSION['active'])) {
  session_destroy(); 
  header("location: login.html");
}

if (!isset($_GET['file']))
  header('Location: index.php?file=add');
else if (in_array($_GET['file'], ['task', 'add', 'archive', 'analysis'])) {
  $html = file_get_contents("templates/$_GET[file].html", true);
  $template = file_get_contents("templates/__GENERIC__.html", true);
  $link = <<<LINK
    <link rel="stylesheet" href="css/$_GET[file].css" />
    <link rel="stylesheet" media="screen and (max-width:900px)" href="css/$_GET[file]_tablet.css" />
    <link rel="stylesheet" media="screen and (max-width:400px)" href="css/$_GET[file]_mobile.css" />
  LINK;
  $script = <<<SCRIPT
    <script src="front_scripts/$_GET[file].js" defer> </script>
  SCRIPT;
  echo str_replace(
    ['$$main$$', '$$title$$', '$$' . $_GET['file'] . '$$', '$$link$$', '$$script$$'],
    [$html, $_GET['file'], 'checked', $link, $script],
    $template
  );
} else if ($_GET['file'] === 'logout') {
  session_unset();
  session_destroy();
  header('Location: login.html');
}
else
  echo " <h1> 404 page undefined </h1>";