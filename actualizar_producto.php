<?php
$servername = "localhost";
$username = "root";
$passworddb = "";
$dbname = "registro";

$conn = new mysqli($servername, $username, $passworddb, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];

    $sql = "UPDATE productos SET NombreProducto = '$nombre', Precio = $precio, Stock = $stock WHERE ProductoID = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Producto actualizado exitosamente";
    } else {
        echo "Error al actualizar el producto: " . $conn->error;
    }
}
?>
