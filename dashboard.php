Dashboard
<?php
require_once __DIR__ . "/bootstrap.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}


echo "Welcome, " . htmlspecialchars($_SESSION["username"], ENT_QUOTES);
?>
<?php if ($msg = flash_get("success")): ?>
<div class="alert alert-success">
    <?= htmlspecialchars($msg, ENT_QUOTES) ?>
</div>
<?php endif; ?>
<a href="logout.php">logout</a>