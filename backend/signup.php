<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $confirmPassword = htmlspecialchars($_POST["confirmPassword"]);
    
    if (!empty($name) && !empty($email) && !empty($password) && !empty($confirmPassword) &&  $password === $confirmPassword) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }
    else if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo "please fill all the fields";
    }
    else if ($password !== $confirmPassword) {
        echo "passwords do not match";
    }
    try{
        require_once("dbh.inc.php");
        $query = "INSERT INTO users (name, email, password) VALUES (`$name`, `$email`, `$password`)";
    }
    catch( PDOException $e){
        die("Connection failed: " . $e->getMessage());
    }
}
else{
    header("Location: ../index.php");
} 