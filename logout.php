<?php
session_start();

if (isset($_POST)) {
    session_destroy();
    header('Location: index.php');
  }
?>