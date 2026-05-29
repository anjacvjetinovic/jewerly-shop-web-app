<?php
session_start();

unset($_SESSION['omiljeni']);

header("Location: omiljeni.php");
exit();
?>