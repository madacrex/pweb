<?php
// Procesar la información de pago y almacenarla en la base de datos (puedes adaptar según tu estructura de base de datos)

include 'con_db.php';

$idCompra = bin2hex(openssl_random_pseudo_bytes(16)); // Genera un ID único para la compra
$fechaCompra = date("Y-m-d"); // Fecha de la compra (formato YYYY-MM-DD)
$horaCompra = date("H:i:s"); // Hora de la compra (formato HH:MM:SS)

// Consulta SQL para obtener los productos desde la base de datos
$sqlProductos = "SELECT NombreProducto, Precio, Stock FROM productos";
$resultProductos = $conn->query($sqlProductos);

// Almacenar información de la compra en la base de datos
while ($rowProducto = $resultProductos->fetch_assoc()) {
    $nombreProducto = $rowProducto['NombreProducto'];
    $precioProducto = $rowProducto['Precio'];
    $cantidadProducto = 1; // Supongamos que siempre compras una unidad de cada producto

    // Verificar si el ID ya existe
    $result = $conn->query("SELECT COUNT(*) FROM compras WHERE id_compra = '$idCompra'");
    $row = $result->fetch_assoc();

    // Si el ID ya existe, genera uno nuevo
    if ($row['COUNT(*)'] > 0) {
        $idCompra = bin2hex(openssl_random_pseudo_bytes(16));
    }

    // Aquí puedes realizar la inserción en tu base de datos con la información de la compra
    // Ejemplo de inserción:
    $sql = "INSERT INTO compras (id_compra, fecha, hora, nombre_producto, precio, cantidad) VALUES ('$idCompra', '$fechaCompra', '$horaCompra', '$nombreProducto', $precioProducto, $cantidadProducto)";
    $conn->query($sql);
}

// Finalmente, redireccionar a la página de agradecimiento
header("Location: gracias_por_la_compra.php");
exit();

$conn->close();
?>
