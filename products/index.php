<?php include_once "../includes/header.php" ?>

<?php

include_once "../includes/db.php";

$dbInstance = DB::getInstance();
$conn = $dbInstance->getConnection();

$result = $conn->query("SELECT id, name FROM categories");
if ($result) {
    while ($data = $result->fetch_assoc()) {
        $categories[] = [
            "name" => $data["name"],
            "id" => $data["id"] 
        ];
    }
}

?>

<main class="container">
    <button id="btnAddProduct">Add product</button>

    <h3>Mis productos</h3>

    <table role="grid">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Título prueba</td>
                <td>Descripción prueba</td>
                <td>$100</td>
                <td>Categoría prueba</td>
                <td>
                    <a href="">Editar</a>
                    <a class="warning" href="">Eliminar</a>
                </td>
            </tr>
            <tr>
                <td>Título prueba</td>
                <td>Descripción prueba</td>
                <td>$100</td>
                <td>Categoría prueba</td>
                <td>
                    <a href="">Editar</a>
                    <a class="warning" href="">Eliminar</a>
                </td>
            </tr>
            <tr>
                <td>Título prueba</td>
                <td>Descripción prueba</td>
                <td>$100</td>
                <td>Categoría prueba</td>
                <td>
                    <a href="">Editar</a>
                    <a class="warning" href="">Eliminar</a>
                </td>
            </tr>
            <tr>
                <td>Título prueba</td>
                <td>Descripción prueba</td>
                <td>$100</td>
                <td>Categoría prueba</td>
                <td>
                    <a href="">Editar</a>
                    <a class="warning" href="">Eliminar</a>
                </td>
            </tr>
            <tr>
                <td>Título prueba</td>
                <td>Descripción prueba</td>
                <td>$100</td>
                <td>Categoría prueba</td>
                <td>
                    <a href="">Editar</a>
                    <a class="warning" href="">Eliminar</a>
                </td>
            </tr>
        </tbody>
    </table>

    <dialog id="modalProduct">
        <article>
            <header style="padding-bottom: .5rem; margin-bottom: 1rem;">
                <a id="closeModalProduct" href="" aria-label="Close" class="close"></a>
                <h3 style="margin-bottom: .5rem;">Añadir nuevo producto</h3>
            </header>
            <form action="./addProductProcess.php" method="post">
                <div class="grid">
                    <label>
                        Título
                        <input name="title" type="text" required />
                    </label>
                    <label>
                        Precio
                        <input name="price" type="number" step=".01" required />
                    </label>
                </div>
                <label>
                    Descripción
                    <textarea style="resize: none;" name="description" id="" cols="60" rows="5"></textarea>
                </label>
                <label>
                    Categoría
                    <select name="category" required>
                        <option value="" selected>Select a category…</option>
                            <?php
                            foreach ($categories as $category) {
                                $id = $category["id"];
                                $name = $category["name"];
                                echo "<option value=$id>$name</option>";
                            }                            
                            ?>
                    </select>
                </label>
                <div class="grid">
                    <button class="secondary" type="reset">Resetear</button>
                    <button type="submit">Agregar</button>
                </div>
            </form>
        </article>
    </dialog>

</main>

<script>
    const btnClose = document.querySelector("#closeModalProduct")
    const btnAddProduct = document.querySelector("#btnAddProduct")
    const modalProduct = document.querySelector("#modalProduct")

    btnAddProduct.addEventListener("click", () => {
        modalProduct.setAttribute("open", true)
    })

    btnClose.addEventListener("click", () => {
        modalProduct.removeAttribute("open")
    })
</script>

<?php include_once "../includes/footer.php" ?>