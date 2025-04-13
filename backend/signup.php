<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $confirmPassword = htmlspecialchars($_POST["confirmPassword"]);
    try{
        require_once("dbh.inc.php");
    }
    catch( PDOException $e){
        die("Connection failed: " . $e->getMessage());
    }
    if (!empty($name) && !empty($email) && !empty($password) && !empty($confirmPassword) &&  $password === $confirmPassword) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }
}
else{
    header("Location: ../index.php");
} 