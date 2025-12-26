<?php

declare(strict_types=1);

// Start session if not started already
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . "/classes/userRepository.php";
require_once __DIR__ . "/classes/validator.php";

require_once __DIR__ . "/config/database.php";

require_once __DIR__ . "/security/csrf.php";