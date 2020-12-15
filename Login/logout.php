<?php
  session_start();
  unset($_SESSION["account"]["name"]);
  unset($_SESSION["account"]["id"]);
  header('Location: ../Top_Page/top_page.php');
?>