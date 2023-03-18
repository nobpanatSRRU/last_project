<?php
session_start();
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $uri = 'https://';
} else {
    $uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];
$_SESSION["uri"] = $uri;
header('Location: ' . $uri . '/project/view/member_view.php');
exit;
?>