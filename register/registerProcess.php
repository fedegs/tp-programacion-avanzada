<?php 
include_once "../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit();
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$passwordRepeated = $_POST["passwordRepeated"];

try {
    if (!$username) {
        throw new Error("Username is required");
    }

    if (!preg_match("/^[a-zA-Z0-9-'_]*$/", $username)) {
        throw new Error("Invalid username");
    }
    
    $dbInstance = DB::getInstance();
    $conn = $dbInstance->getConnection();

    $userQuery = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $userQuery->bind_param("s", $username);
    $result = $userQuery->execute();
    $resultados = $userQuery->get_result();
    $userQuery->close();
    
    $data = $resultados->fetch_assoc();

    if ($data) {
        throw new Error("Username is already taken");
    }
    
    if (!$email) {
        throw new Error("Email is required");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Error("Invalid email format");
    }

    if (!$password || !$passwordRepeated) {
        throw new Error("Password is required");
    }

    if (strlen($password) < 6) {
        throw new Error("Password min length is 6");
    }

    if ($password !== $passwordRepeated) {
        throw new Error("Password doesnt match");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $query = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $query->bind_param("sss", $username, $hashedPassword, $email);
    $query->execute();
    $query->close();

    $_SESSION["registerSuccessful"] = true;
    header("Location: ./");
    exit();
} catch (Error $e) {
    $_SESSION["registerError"] = $e->getMessage();
    header("Location: ./");
} catch (mysqli_sql_exception $mysqli_err) {
    header("Location: ../error/");
}