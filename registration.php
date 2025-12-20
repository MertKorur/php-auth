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
    <div class="container">

        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {

            $username = $_POST["username"] ?? "";
            $email = $_POST["email"] ?? "";
            $password = $_POST["password"] ?? "";
            $passwordRepeat = $_POST["repeat_password"] ?? "";

            // Sanitize inputs
            $username = trim($username);
            $username = preg_replace("/\s+/", " ", $username);

            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            $errors = [];
        
            // Checks
            if ($username === "") {
                $errors[] = "Username is required.";
            }

            if ($email === "") {
                $errors[] = "Email is required.";
            }

            if ($password === "") {
                $errors[] = "Password is required.";
            }

            if ($passwordRepeat === "") {
                $errors[] = "Please repeat your password.";
            }

            // Validation
            if ($username !== "" && !preg_match("/^[a-zA-Z0-9_]{3,20}$/", $username)) {
                $errors[] = "Username must be 3-20 characters long and can only contain letters, numbers, and underscores.";
            }

            if ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            }
            /*
            if ($email !== "" && !$email) {
                $errors[] = "Invalid email format.";
            }
            */

            if ($password !== "" && strlen($password) < 8) {
                $errors[] = "Password must be at least 8 characters long.";
            }

            // Strict password rules (uncomment to enforce)
            /*
            if ($password !== "" && !preg_match('/[A-Z]/', $password)) {
                $errors[] = "Password must contain at least one uppercase letter.";
            }

            if ($password !== "" && !preg_match('/[a-z]/', $password)) {
                $errors[] = "Password must contain at least one lowercase letter.";
            }

            if ($password !== "" && !preg_match('/[0-9]/', $password)) {
                $errors[] = "Password must contain at least one number.";
            }
            */

            if ($password !== "" && $passwordRepeat !== "" && $password !== $passwordRepeat) {
                $errors[] = "Passwords do not match.";
            }

            // Output
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger' role='alert'>"
                        . htmlspecialchars($error, ENT_QUOTES, 'UTF-8')
                        . "</div>";
                }
            } else {
                echo "<div class='alert alert-success' role='alert'>Registration successful!</div>";
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // save to db
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username*">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email*">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password*">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password*">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
    </div>
</body>

</html>