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

    $sql = "DELETE FROM productos WHERE ProductoID = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Producto eliminado exitosamente";
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }
}
?>