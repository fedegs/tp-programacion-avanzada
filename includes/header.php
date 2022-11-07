<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["user"])) {
    $username = $_SESSION["user"]["username"];
}

?>

<!DOCTYPE html>
<html lang="en" data-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <!-- pico.css -->
    <link rel="stylesheet" href="../css/pico.min.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Switcher -->
    <script src="../js/themeSwitcher.js" defer></script>
    <!-- Vanilla DataTables -->
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/a0f449ffa7.js" crossorigin="anonymous"></script>
    <title>Amaclon</title>
</head>
<body>
    <nav class="container-fluid">
        <ul>
            <li>
                <strong style="font-size: 24px;">
                    <a href="../home/">🛍️ Amaclon</a>
                </strong>
            </li>
        </ul>
        <ul>
            <?php if (isset($username)): ?>
            <li>
                <strong>
                    <a href="../products/">My products</a>
                </strong>
            </li>
            Logged as:
            <li>
                <details role="list" dir="rtl">
                    <summary aria-haspopup="listbox" role="link"><b><?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></b></summary>
                    <ul role="listbox">
                        <li><a href="../logout.php">Logout</a></li>
                    </ul>
                </details>
            </li>
            <?php else: ?>
            <li>
                <b>
                    <a href="../login/">Login</a>
                </b>
            </li>
            <li>
                <b>
                    <a href="../register/">Register</a>
                </b>    
            </li>
            <?php endif; ?>
        </ul> 
    </nav>

    <button id="theme-switcher" class="contrast switcher"></button>
