<?php
  session_start();
  unset($_SESSION["account"]["user"]);
  unset($_SESSION["account"]["id"]);
  header('Location: ../Top_Page/top_page.php');
?>