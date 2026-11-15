
<?php
include("conexion.php");

$sql = "SELECT * FROM editoriales";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editoriales - Biblioteca García Sevilla</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f1f0fa;
    margin: 0;
}
header {
    background: #625a9c;
    color: white;
    text-align: center;
    padding: 25px;
}
.contenedor {
    max-width: 800px;
    margin: 35px auto;
    padding: 20px;
    background: white;
    border-radius: 12px;
}
h2 {
    color: #48417d;
    text-align: center;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
}
th {
    background: #625a9c;
    color: white;
}
a {
    color: #625a9c;
}
</style>
</head>
<body>

<header>
<h1>📚 Biblioteca García Sevilla</h1>
<p>Registro de editoriales</p>
</header>

<div class="contenedor">
<h2>Editoriales registradas</h2>

<table>
<tr>
<th>Información</th>
</tr>

<?php
if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr><td>";
        foreach ($fila as $dato) {
            echo htmlspecialchars($dato ?? "") . " | ";
        }
        echo "</td></tr>";
    }
} else {
    echo "<tr><td>No hay editoriales registradas.</td></tr>";
}
?>

</table>

<p><a href="menu.php">Volver al menú principal</a></p>
</div>

</body>
</html>
