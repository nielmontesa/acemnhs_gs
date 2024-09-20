<?php
session_start();
session_unset();
session_destroy();
header("Location: /Capstone/acemnhs_gs/src/index.php"); // Change this to your login page
exit();
?>
