<?php
include_once "../includes/header.php";
?>

<?php

// if (isset($_POST["submit"])) {
//     $username = $_POST["username"];
//     $password = $_POST["password"];
    
//     if ($username !== "fcytuader" && $username !== "programacionavanzada") {
//         $errorMsg = "Wrong username or password!";
//     } else {
//         $loginSuccessful = "Login successful!! :)";
//     }
// } 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    if ($username !== "fcytuader" && $username !== "programacionavanzada") {
        $errorMsg = "Wrong username or password!";
    } else {
        $loginSuccessful = "Login successful!! :)";
    }
} 


?>

<!-- HTML START -->

<main class="container login-main">
    <article class="grid" style="padding: 0; overflow: hidden;">
        <div style="padding: 2rem;">
            <hgroup>
                <h1>Login</h1>
                <h2>Hello! Welcome Back</h2>
            </hgroup>
            <form method="POST">
                <label>
                    Username:
                    <input type="text"
                        name="username"
                        required />
                </label>
                <label>
                    Password:
                    <input type="password"
                        name="password"
                        required />
                </label>
                <?php
                if (!empty($errorMsg)) {
                    echo "<small class='warning'>{$errorMsg}</small>";
                } else if (!empty($loginSuccessful)) {
                    echo "<small class='success'>{$loginSuccessful}</small>";
                }
                ?>
                <input type="submit" name="submit" value="Login">
            </form>
        </div>
        <div class="login-img"></div>    
    </article>
</main>

<!-- HTML END -->

<?php
include_once "../includes/footer.php";
?>