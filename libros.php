
<?php
$conexion = new mysqli("127.0.0.1", "root", "", "Biblioteca_GarciaSevilla");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $isbn = $_POST["isbn"];
    $anio = $_POST["anio"];
    $autor = $_POST["autor"];
    $editorial = $_POST["editorial"];

    $sql = $conexion->prepare(
        "INSERT INTO Libros (titulo, ISBN, anio_publicacion, id_autor, id_editorial)
         VALUES (?, ?, ?, ?, ?)"
    );

    $sql->bind_param("ssiii", $titulo, $isbn, $anio, $autor, $editorial);
    $sql->execute();

    header("Location: libros.php");
    exit;
}

$autores = $conexion->query("SELECT id_autor, nombre FROM Autores");
$editoriales = $conexion->query("SELECT id_editorial, nombre FROM Editoriales");
$libros = $conexion->query("SELECT * FROM Libros");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Libros - Biblioteca</title>

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

input, select {
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
    <p>Administración de libros</p>
</header>

<div class="contenedor">

<h2>Registrar nuevo libro</h2>

<form method="POST">

    <input type="text" name="titulo"
    placeholder="Título del libro" required>

    <input type="text" name="isbn"
    placeholder="ISBN">

    <input type="number" name="anio"
    placeholder="Año de publicación">

    <select name="autor" required>
        <option value="">Seleccionar autor</option>
        <?php while($a = $autores->fetch_assoc()) { ?>
        <option value="<?= $a['id_autor'] ?>">
            <?= htmlspecialchars($a['nombre']) ?>
        </option>
        <?php } ?>
    </select>

    <select name="editorial" required>
        <option value="">Seleccionar editorial</option>
        <?php while($e = $editoriales->fetch_assoc()) { ?>
        <option value="<?= $e['id_editorial'] ?>">
            <?= htmlspecialchars($e['nombre']) ?>
        </option>
        <?php } ?>
    </select>

    <button type="submit">Guardar libro</button>

</form>

<h2>Libros registrados</h2>

<table>
<tr>
    <th>ID</th>
    <th>Título</th>
    <th>ISBN</th>
    <th>Año</th>
    <th>Disponibilidad</th>
</tr>

<?php while($l = $libros->fetch_assoc()) { ?>
<tr>
    <td><?= $l['id_libro'] ?></td>
    <td><?= htmlspecialchars($l['titulo']) ?></td>
    <td><?= htmlspecialchars($l['ISBN'] ?? '') ?></td>
    <td><?= $l['anio_publicacion'] ?></td>
    <td><?= htmlspecialchars($l['disponibilidad']) ?></td>
</tr>
<?php } ?>

</table>

<br>
<a href="menu.php">← Volver al menú principal</a>

</div>
</body>
</html>
