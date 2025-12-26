<?php

declare(strict_types=1);

// Start session if not started already
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . "/../classes/userRepository.php";
require_once __DIR__ . "/../classes/validator.php";

require_once __DIR__ . "/database.php";


// Generate CSRF token if there is no
function csrf_token(): string
{
    if (empty($_SESSION["csrf_token"])) {
        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
    }

    return $_SESSION["csrf_token"];
}

// Verify CSRF token from POST
function csrf_verify(?string $token): bool
{
    return isset($_SESSION["csrf_token"])
        && is_string($token)
        && hash_equals($_SESSION["csrf_token"], $token);
}