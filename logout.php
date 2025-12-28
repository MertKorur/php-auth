<?php

require_once __DIR__ . "/bootstrap.php";

session_unset();
session_destroy();

flash_set("success", "You have now been logged out.");
header("Location: login.php");
exit;