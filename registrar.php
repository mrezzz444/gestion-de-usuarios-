<?php
header("Access-Control-Allow-Origin: *");
$conexion = new mysqli("localhost", "root", "", "losusuarios");

if ($conexion->connect_error) {
    echo json_encode(["error" => "No se pudo conectar"]);
    exit;
}

$resultado = $conexion->query("SELECT * FROM usuarios");

$datos = [];

while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
}

echo json_encode($datos);
$conexion->close();