<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Productos</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
        <div class="logo">
            <img src="tu_logo.png" alt="Logo de la Página">
        </div>
        <nav>
        <ul>
                <li><a href="pagina.php">Home</a></li>
                <li><a href="quienesomos.php">Quienes Somos</a></li>
                <li><a href="alta_productos.php">Alta de Productos</a></li>
                <li><a href="mostrar_tabla.php">Tabla de Productos</a></li>
    </ul>
  </div>
        </nav>
</header>
<?php
$servername = "localhost";
$username = "root";
$passworddb = "";
$dbname = "registro";

$conn = new mysqli($servername, $username, $passworddb, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "SELECT ProductoID, NombreProducto, Precio, Stock FROM productos WHERE ProductoID = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo "<section class='form-login'>";
        echo "<form action='actualizar_producto.php' method='post'>";
        echo "Nombre: <input type='text' name='nombre' value='" . $row["NombreProducto"] . "'><br>";
        echo "Precio: <input type='text' name='precio' value='" . $row["Precio"] . "'><br>";
        echo "Stock: <input type='text' name='stock' value='" . $row["Stock"] . "'><br>";
        echo "<input type='hidden' name='id' value='" . $row["ProductoID"] . "'>";
        echo "<input type='submit' value='Actualizar Producto'>";
        echo "</form>";
        echo "</section>";
    } else {
        echo "Producto no encontrado";
    }
}
?>
<footer>
        <div class="social-media">
            <a href="http://www.facebook.com" target="_blank"><img src="logof.png" alt="Facebook"></a>
            <a href="http://www.twitter.com" target="_blank"><img src="x.png" alt="Twitter" class="twitter"></a>
            <a href="http://www.instagram.com" target="_blank"><img src="instagram.png" alt="Instagram"></a>
        </div>
    </footer>
</body>
</html>