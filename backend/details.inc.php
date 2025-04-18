<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $product_id = $_POST["product_id"];
        header("Location: ../frontend/productdetails.php?id=$product_id");
    }