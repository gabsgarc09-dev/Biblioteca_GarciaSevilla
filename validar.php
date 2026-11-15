
<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $matricula = $_POST["matricula"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM usuarios WHERE `Matrícula` = ? AND password = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $matricula, $password);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        header("Location: menu.php");
        exit();
    } else {
        echo "Matrícula o contraseña incorrectas.";
        echo "<br><a href='index.php'>Volver al inicio</a>";
    }

    $stmt->close();
}

$conn->close();
?>
