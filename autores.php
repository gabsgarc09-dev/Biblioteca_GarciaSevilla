
<?php
$conexion = new mysqli("127.0.0.1", "root", "", "Biblioteca_GarciaSevilla");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $paterno = $_POST["paterno"];
    $materno = $_POST["materno"];
    $nacionalidad = $_POST["nacionalidad"];

    $sql = $conexion->prepare(
        "INSERT INTO Autores (nombre, apellido_paterno, apellido_materno, nacionalidad)
        VALUES (?, ?, ?, ?)"
    );

    $sql->bind_param("ssss", $nombre, $paterno, $materno, $nacionalidad);
    $sql->execute();

    header("Location: autores.php");
    exit;
}

$autores = $conexion->query("SELECT * FROM Autores");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Autores - Biblioteca</title>

<style>
body {
    font-family: Arial;
    background: #f1f0fa;
    margin: 0;
    color: #333;
}

header {
    background: #625a9c;
    color: white;
    padding: 22px;
    text-align: center;
}

.contenedor {
    background: white;
    max-width: 850px;
    margin: 25px auto;
    padding: 20px;
    border-radius: 12px;
}

input {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 7px;
    box-sizing: border-box;
}

button {
    background: #625a9c;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 7px;
    width: 100%;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 9px;
    text-align: left;
}

th {
    background: #dedafa;
}

a {
    color: #625a9c;
}
</style>
</head>

<body>

<header>
    <h1>📚 Biblioteca García Sevilla</h1>
    <p>Administración de autores</p>
</header>

<div class="contenedor">

<h2>Registrar autor</h2>

<form method="POST">

    <input type="text" name="nombre"
    placeholder="Nombre" required>

    <input type="text" name="paterno"
    placeholder="Apellido paterno" required>

    <input type="text" name="materno"
    placeholder="Apellido materno" required>

    <input type="text" name="nacionalidad"
    placeholder="Nacionalidad">

    <button type="submit">Guardar autor</button>

</form>

<h2>Autores registrados</h2>

<table>
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Apellido paterno</th>
    <th>Apellido materno</th>
    <th>Nacionalidad</th>
</tr>

<?php while($a = $autores->fetch_assoc()) { ?>
<tr>
    <td><?= $a['id_autor'] ?></td>
    <td><?= htmlspecialchars($a['nombre']) ?></td>
    <td><?= htmlspecialchars($a['apellido_paterno']) ?></td>
    <td><?= htmlspecialchars($a['apellido_materno']) ?></td>
    <td><?= htmlspecialchars($a['nacionalidad']) ?></td>
</tr>
<?php } ?>

</table>

<br>
<a href="menu.php">← Volver al menú principal</a>

</div>

</body>
</html>
