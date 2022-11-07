<?php

include_once "../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit();
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$productId = $_POST["id"];
$title = $_POST["title"];
$price = $_POST["price"];
$description = $_POST["description"];
$category = $_POST["category"];

try {
    if (!$title) {
        throw new Error("Title is required");
    }

    if (!preg_match("/^[a-zA-Z0-9-'_!() ]*$/", $title)) {
        throw new Error("Invalid title");
    }

    if (!$price) {
        throw new Error("Price is required");
    }

    if (!is_numeric($price)) {
        throw new Error("Pirce must be a number");
    }

    if (!$category) {
        throw new Error("Category is required");
    }

    if (!is_numeric($category)) {
        throw new Error("Invalid category");
    }

    if (!$productId) {
        throw new Error("Id is required");
    }

    if (!is_numeric($productId)) {
        throw new Error("Invalid id");
    }

    $dbInstance = DB::getInstance();
    $conn = $dbInstance->getConnection();

    $sql = "UPDATE products
    SET title = ?, description = ?, price = ?, category_id = ?
    WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $title, $description, $price, $category, $productId);
    $stmt->execute();
    $stmt->close();
    header("Location: ./");
} catch (Error $e) {
    $_SESSION["editProductError"] = $e->getMessage();
    header("Location: ./");
} catch (mysqli_sql_exception $mysqli_err) {
    header("Location: ../error/");
}