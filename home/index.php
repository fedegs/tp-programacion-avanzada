<?php include_once "../includes/header.php" ?>

<?php
include_once "../includes/db.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user"])) {
    header('Location: ../login/');
    exit();
} else {
    $username = $_SESSION["user"]["username"];
}

$dbInstance = DB::getInstance();
$conn = $dbInstance->getConnection();

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $searchVar = "%" . $search . "%";
    
    try {
        $sql = "SELECT 
            p.title, p.price, c.name, u.email 
        FROM 
            products p 
        INNER JOIN 
            categories c ON c.id = p.category_id 
        INNER JOIN 
            users u ON p.published_by = u.id 
        WHERE 
            p.title LIKE ? 
        ORDER BY p.published_at DESC, p.id DESC
        LIMIT 15";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $searchVar);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } catch (mysqli_sql_exception $mysqli_err) {
        header("Location: ../error/");
    }
} else {
    try {
        $sql = "SELECT 
                p.title, p.price, c.name, u.email 
            FROM 
                products p 
            INNER JOIN 
                categories c ON c.id = p.category_id 
            INNER JOIN 
                users u ON p.published_by = u.id
            ORDER BY p.published_at DESC, p.id  DESC
            LIMIT 15";
        
        $result = $conn->query($sql);
    } catch (mysqli_sql_exception $mysqli_err) {
        header("Location: ../error/");
    }
}


if ($result) {
    while ($data = $result->fetch_assoc()) {
        $products[] = [
            "title" => $data["title"],
            "price" => $data["price"],
            "category" => $data["name"],
            "email" => $data["email"]
        ];
    }
}

?>

<main class="container" style="padding-top: .5rem;">
    <form class="search-bar" action="." method="get">
        <input type="search" id="search" name="search" placeholder="Search">
        <button type="submit">Buscar</button>
    </form>
    <?php if (isset($search)): ?>
    <h4 style="margin: .5rem 0;">Resultados de la búsqueda <?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>:</h4>
    <?php else: ?>
    <h4 style="margin: .5rem 0;">Últimos productos añadidos:</h4>
    <?php endif; ?>
    <div class="products-container">
        <?php
        if (isset($products)) {
            foreach ($products as $product) {
                $title = htmlspecialchars($product["title"], ENT_QUOTES, 'UTF-8');
                $price = htmlspecialchars($product["price"], ENT_QUOTES, 'UTF-8');
                $email = htmlspecialchars($product["email"], ENT_QUOTES, 'UTF-8');
                $category = $product["category"];
                $categoryImgName = "cat_" . $category . ".webp";
                echo "
                    <article class='grid' style='gap: 0;'>
                        <div class='img-container'>
                            <img class='category-img' src='../img/$categoryImgName' alt='category image'>
                        </div>
                        <div style='padding: 1rem;'>
                            <p class='card-name'>
                                <b>$title</b>
                            </p>
                            <p>
                                $ $price
                            </p>
                            <a style='width: 100%;' href='mailto:$email?subject=Product%20$title%20on%20Amaclon' role='button'>Contactar</a>
                        </div>
                    </article>";
            }   
        } else {
            echo "<p>No hay productos 😢</p>";
        }
        ?>
    </div>
</main>

<?php include_once "../includes/footer.php" ?>