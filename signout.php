<?php
  session_start();
  var_dump($user);
  unset($access_token);
  unset($connection);
  unset($user);
  var_dump($user);
  session_destroy();
  header('Location: index.php');
?>
