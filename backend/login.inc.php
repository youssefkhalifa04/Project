<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    try{
        require_once("./dbh.inc.php");
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
        $pdo = null;
        
        if ($result && password_verify($password, $result["password"])) {
            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["user_id"] = $result["id"]; // Store user_id in session
            $_SESSION["email"] = $result["email"];
            header("Location: ../frontend/index.php?login=success");
           
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    
}