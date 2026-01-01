<?php

declare(strict_types=1);

require_once __DIR__ . "/bootstrap.php";

$errors = [];

$username = "";
$password = "";

if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // CSRF
    if (!csrf_verify($_POST["csrf_token"] ?? null)) {
        $errors[] = "Invalid request. Please refresh and try again.";
    }

    // INPUT
    $username = trim($_POST["username"] ?? "");
    $username = preg_replace("/\s+/", " ", $username);

    $password = $_POST["password"] ?? "";

    $validator = new Validator();
    // VALIDATION
    // required
    $validator->required("username", $username);
    $validator->required("password", $password);

    // Format validation not required

    // Collect errors
    $errors = array_values($validator->errors());

    if (empty($errors)) {
        $repo = new UserRepository($pdo);
        $user = $repo->findByUsername($username);

        if (!$user || !password_verify($password, $user["password"])) {
            $errors[] = "Invalid username or password.";
        } else {
            session_regenerate_id(true);
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];

            flash_set("success", "Login successful.");
            header("Location: dashboard.php");
            exit;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="mb-3">Login</h2>
        <?php if ($msg = flash_get('success')): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($msg, ENT_QUOTES) ?>
        </div>
        <?php endif; ?>


        <?php
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>"
                . htmlspecialchars($error, ENT_QUOTES, 'UTF-8')
                . "</div>";
        }
        ?>

        <form method="post">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES) ?>">

            <div class="form-group">
                <input type="text" class="form-control" name="username"
                    value="<?= htmlspecialchars($username ?? '', ENT_QUOTES) ?>" placeholder="Username">
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>

            <div class="text-center form-btn">
                <button class="btn btn-primary mt-3">Login</button>
            </div>

            <div class="text-center mt-3">
                <span>Don't have an account?</span>
                <a href="registration.php" class="btn btn-link">Register here</a>
            </div>

        </form>

    </div>

</body>

</html>