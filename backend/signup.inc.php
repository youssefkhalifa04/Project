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
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            require_once("./dbh.inc.php");
            $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$name, $email, $hashedPassword]);
            $stmt = null;
            $pdo = null;
            header("Location: ../frontend/login.php?signup=success");
            
            exit();
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
} else {
    header("Location: ../signup.php?signup=failure");
    exit();
}
