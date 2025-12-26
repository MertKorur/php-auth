Dashboard
<?php
require_once __DIR__ . "/bootstrap.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}


echo "Welcome, " . htmlspecialchars($_SESSION["user_id"], ENT_QUOTES);
?>
<a href="logout.php">logout</a>