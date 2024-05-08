<?php
ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
session_start();
session_regenerate_id();
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}
session_destroy();
header("Location: index.php");
exit;

