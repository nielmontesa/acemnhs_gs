<?php
session_start();
session_unset();
session_destroy();
header("Location: ../index.php"); // Change this to your login page
exit();
?>