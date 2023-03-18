<?php
session_start();
session_destroy();
header('Location:' . $_SESSION['uri'] . "/project/view/login_view.php");
?>