<?php

declare(strict_types=1);

require_once __DIR__ . "/bootstrap.php";

$errors = [];
$success = false;

$username = "";
$email = "";
$password = "";
$passwordRepeat = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!csrf_verify($_POST["csrf_token"] ?? null)) {
        http_response_code(403);
        exit("Invalid CSRF token.");
    }

    // INPUT
    $username = trim($_POST["username"] ?? "");
    $username = preg_replace("/\s+/", " ", $username);

    $email = trim($_POST["email"] ?? "");
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $password = $_POST["password"] ?? "";
    $passwordRepeat = $_POST["repeat_password"] ?? "";

    $validator = new Validator();

    // VALIDATION
    // required
    $validator->required("username", $username);
    $validator->required("email", $email);
    $validator->required("password", $password);
    $validator->required("repeat_password", $passwordRepeat);

    // format
    $validator->username("username", $username);
    $validator->email("email", $email);
    $validator->password("password", $password);
    // match
    $validator->match("repeat_password", $password, $passwordRepeat);

    // Collect errors
    $errors = array_values($validator->errors());

    if (empty($errors)) {
        $repo = new UserRepository($pdo);

        if ($repo->userExists($username, $email)) {
            $errors[] = "Username or email already exists.";
        } else {
            $repo->createUser(
                $username,
                $email,
                password_hash($password, PASSWORD_DEFAULT)
            );
            $success = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="mb-3">Register</h2>
        <?php
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>"
                . htmlspecialchars($error, ENT_QUOTES, 'UTF-8')
                . "</div>";
        }

        if ($success) {
            echo "<div class='alert alert-success'>Registration successful!</div>";
        }

        ?>

        <form method="post">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES) ?>">
            <div class="form-group">
                <input type="text" class="form-control" name="username"
                    value="<?= htmlspecialchars($username, ENT_QUOTES) ?>" placeholder="Username">
            </div>

            <div class="form-group">
                <input type="email" class="form-control" name="email"
                    value="<?= htmlspecialchars($email, ENT_QUOTES) ?>" placeholder="Email">
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password">
            </div>

            <div class="text-center form-btn">
                <button class="btn btn-primary mt-3">Register</button>
            </div>

            <div class="text-center mt-3">
                <span>Already have an account?</span>
                <a href="login.php" class="btn btn-link">Login here</a>
            </div>

        </form>
    </div>
</body>

</html>