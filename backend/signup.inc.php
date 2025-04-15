<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo "Please fill all the fields.";
    } elseif ($password !== $confirmPassword) {
        echo "Passwords do not match.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            require_once("./dbh.inc.php");

            // Start transaction
            $pdo->beginTransaction();

            // Insert into users
            $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$name, $email, $hashedPassword]);

            // Get the new user's ID
            $userId = $pdo->lastInsertId();

            // Create cart for the new user
            $cartQuery = "INSERT INTO cart (user_id) VALUES (?)";
            $cartStmt = $pdo->prepare($cartQuery);
            $cartStmt->execute([$userId]);

            // Commit transaction
            $pdo->commit();

            $stmt = null;
            $cartStmt = null;
            $pdo = null;

            header("Location: ../frontend/login.php?signup=success");
            exit();
        } catch (PDOException $e) {
            // Roll back on error
            $pdo->rollBack();
            die("Signup failed: " . $e->getMessage());
        }
    }
} else {
    header("Location: ../signup.php?signup=failure");
    exit();
}

