<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $image = $_FILES["image"]; // Get the uploaded file
   
    if (empty($name) || empty($price) || empty($description) || empty($image)) {
        echo "Please fill all the fields.";
    } else {
 
        $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
        $imageExtension = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
        
        if (!in_array($imageExtension, $allowedExtensions)) {
            echo "Invalid image file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            exit();
        }

       
        $uploadDir = "../frontend/assets/"; 
        $imagePath = $uploadDir . uniqid() . "." . $imageExtension; // Unique filename
       
        if (move_uploaded_file($image["tmp_name"], $imagePath)) {
            try {
                require_once("./dbh.inc.php");
                
               
                $query = "INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$name, $price, $description, $imagePath]);

                $stmt = null;
                $pdo = null;

                header("Location: ../frontend/admin.php?addproduct=success");
                exit();
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        } else {
            echo "Failed to upload the image.";
        }
    }
}
?>
