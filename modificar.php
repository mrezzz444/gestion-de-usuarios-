<body>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conexion = mysqli_connect("localhost", "root", "", "losusuarios") or die("Problemas de conexión");

function mostrarRegistro($conexion, $matricula, $titulo = "REGISTRO") {
    $registro = mysqli_query($conexion, "SELECT * FROM usuarios WHERE matricula='$matricula'");
    if (mysqli_num_rows($registro) > 0) {
        echo "<div><b>$titulo</b><br>";
        while ($reg = mysqli_fetch_array($registro)) {
            echo "Matrícula: {$reg['matricula']}<br>";
            echo "Nombre: {$reg['nombre']}<br>";
            echo "Correo: {$reg['correo']}<br><br>";
        }
        echo "</div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $campos = $_POST['modificar'] ?? [];

    if (empty($matricula)) {
        echo "<div style='color:red;'>¡La matrícula es obligatoria!</div>";
    } else {
        $existe = mysqli_query($conexion, "SELECT * FROM usuarios WHERE matricula='$matricula'");

        if (mysqli_num_rows($existe) == 0) {
            echo "<div style='color:red;'>NO EXISTE LA MATRÍCULA $matricula</div>";
        } else {
            mostrarRegistro($conexion, $matricula, "REGISTRO ANTES DE ACTUALIZAR");

            if (in_array("nombre", $campos) && !empty($nombre)) {
                mysqli_query($conexion, "UPDATE usuarios SET nombre='$nombre' WHERE matricula='$matricula'");
            }
            if (in_array("correo", $campos) && !empty($correo)) {
                mysqli_query($conexion, "UPDATE usuarios SET correo='$correo' WHERE matricula='$matricula'");
            }

            echo "<div style='color:green;'>REGISTRO ACTUALIZADO</div>";
            mostrarRegistro($conexion, $matricula, "REGISTRO DESPUÉS DE ACTUALIZAR");
        }
    }
}

mysqli_close($conexion);
?>

</body>
