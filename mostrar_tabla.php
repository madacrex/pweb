<?php

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
if(isset($_POST['cerrar_sesion'])) {
  session_destroy();
  header("location: pagina.php");
  exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Alta De Productos</title>
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
                <li><a href="quienes_somos.php">Quienes Somos</a></li>
                <li><a href="alta_productos.php">Alta de Productos</a></li>
                <li><a href="mostrar_tabla.php">Tabla de Productos</a></li>
        </ul>
        </nav>
        <form method="post" action="">
        <input type="submit" name="cerrar_sesion" value="Cerrar Sesión" class="cerrar_sesion">
    </form>
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

$sql = "SELECT ProductoID, NombreProducto, Precio, Stock FROM productos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Editar</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["ProductoID"] . "</td>";
        echo "<td>" . $row["NombreProducto"] . "</td>";
        echo "<td>" . $row["Precio"] . "</td>";
        echo "<td>" . $row["Stock"] . "</td>";
        echo "<td>";
        echo "<a href='modificar_productos.php?id=" . $row["ProductoID"] . "'>Modificar</a> | ";
        echo "<a href='baja_productos.php?id=" . $row["ProductoID"] . "'>Eliminar</a>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "0 resultados";
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