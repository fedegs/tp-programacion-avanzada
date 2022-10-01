<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    if ($username !== "fcytuader" && $username !== "programacionavanzada") {
        $_SESSION["loginError"] = "Wrong username or password!";
        header("Location: ./");
    } else {
        $_SESSION["username"] = $username;
        header("Location: ../");
    }
}