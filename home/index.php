<?php include_once "../includes/header.php" ?>

<?php
session_start();

if (!isset($_SESSION["username"])) {
    header('Location: ../login/');
} else {
    $username = $_SESSION["username"];
}
?>

<main class="container" style="text-align: center;">
    <article>
        <h2>Bienvenido a Amaclon, <?php echo $username ?>!</h2>
        <h4 class="success">¡Ingresaste correctamente!</h4>

    </article>
</main>

<?php include_once "../includes/footer.php" ?>
