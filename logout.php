<?php
session_start();
session_destroy();
header("Location: loginToCheck.php");
?>
