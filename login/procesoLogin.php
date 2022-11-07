<?php
include_once "../includes/db.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit();
}

$username = $_POST["username"];
$password = $_POST["password"];
$token = $_POST["token"];

$ip = $_SERVER['REMOTE_ADDR'];
$captcha = $_POST["g-recaptcha-response"];
$secretkey = '6LfISmYiAAAAAPrfaOFWo9y7ojESAPMz96-SK4p2';

$respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");

$atributo = json_decode($respuesta, TRUE);

try {
    if (!$atributo['success']) {
        throw new Error("Verify captcha");
    }

    if ($token !== $_SESSION["token"]) {
        throw new Error("Invalid token");
    }

    if (!$username || !$password) {
        throw new Error("Username and password must be provided");
    }

    $dbInstance = DB::getInstance();
    $conn = $dbInstance->getConnection();
    $loginStatement = $conn->prepare("SELECT id, password, email FROM users WHERE username = ?");
    $loginStatement->bind_param("s", $username);
    $loginStatement->execute();
    $result = $loginStatement->get_result();
    $loginStatement->close();
    $data = $result->fetch_assoc();
    
    if (!$data) {
        throw new Error("Wrong username or password");
    }
    
    $passwordHash = $data["password"];
    $id = $data["id"];
    $email = $data["email"];
    
    if(!password_verify($password, $data["password"])) {
        throw new Error("Wrong username or password");
    }
    
    $_SESSION["user"] = [
        "username" => $username,
        "id" => $id,
        "email" => $email
    ];
    header("Location: ../home");
} catch (Error $e) {
    $_SESSION["loginError"] = $e->getMessage();
    header("Location: ./");
} catch (mysqli_sql_exception $mysqli_err) {
    header("Location: ../error/");
}