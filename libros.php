
<?php
include("conexion.php");

$mensaje = "";
$libroEditar = null;

// ELIMINAR LIBRO
if (isset($_POST["eliminar"])) {
    $id = intval($_POST["id_libro"]);

    $stmt = $conn->prepare("DELETE FROM Libros WHERE id_libro = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: libros.php");
    exit;
}

// REGISTRAR O MODIFICAR LIBRO
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guardar"])) {

    $titulo = trim($_POST["titulo"]);
    $isbn = trim($_POST["isbn"]);
    $anio = $_POST["anio"] === "" ? null : intval($_POST["anio"]);
    $autor = intval($_POST["autor"]);
    $editorial = intval($_POST["editorial"]);
    $disponibilidad = $_POST["disponibilidad"];

    if ($_POST["id_libro"] != "") {

        $id = intval($_POST["id_libro"]);

        $stmt = $conn->prepare(
            "UPDATE Libros SET titulo=?, ISBN=?, anio_publicacion=?,
            id_autor=?, id_editorial=?, disponibilidad=?
            WHERE id_libro=?"
        );

        $stmt->bind_param(
            "ssiiisi",
            $titulo, $isbn, $anio, $autor,
            $editorial, $disponibilidad, $id
        );

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO Libros
            (titulo, ISBN, anio_publicacion, id_autor,
            id_editorial, disponibilidad)
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssiiis",
            $titulo, $isbn, $anio, $autor,
            $editorial, $disponibilidad
        );
    }

    $stmt->execute();
    $stmt->close();

    header("Location: libros.php");
    exit;
}

// OBTENER LIBRO PARA EDITAR
if (isset($_GET["editar"])) {

    $id = intval($_GET["editar"]);

    $stmt = $conn->prepare(
        "SELECT * FROM Libros WHERE id_libro = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $resultadoEditar = $stmt->get_result();
    $libroEditar = $resultadoEditar->fetch_assoc();

    $stmt->close();
}

// CONSULTAR AUTORES Y EDITORIALES
$autores = $conn->query("SELECT id_autor, nombre FROM Autores");
$editoriales = $conn->query("SELECT id_editorial, nombre FROM Editoriales");

// CONSULTAR LIBROS
$libros = $conn->query("SELECT * FROM Libros ORDER BY id_libro DESC");

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Libros - Biblioteca García Sevilla</title>

<style>
body {
    font-family: Arial, sans-serif;
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
    max-width: 950px;
    margin: 25px auto;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 3px 10px #0002;
}

h2 {
    color: #48417d;
    text-align: center;
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
    cursor: pointer;
    margin-top: 8px;
}

button:hover {
    background: #48417d;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

th {
    background: #dedafa;
    color: #48417d;
}

.editar {
    color: #625a9c;
    font-weight: bold;
}

.eliminar {
    background: #a94455;
}

.volver {
    display: block;
    margin-top: 25px;
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

<h2>
<?php echo $libroEditar ? "Modificar libro" : "Registrar nuevo libro"; ?>
</h2>

<form method="POST">

    <input type="hidden" name="id_libro"
    value="<?= $libroEditar['id_libro'] ?? '' ?>">

    <input type="text" name="titulo"
    placeholder="Título del libro"
    value="<?= htmlspecialchars($libroEditar['titulo'] ?? '') ?>"
    required>

    <input type="text" name="isbn"
    placeholder="ISBN"
    value="<?= htmlspecialchars($libroEditar['ISBN'] ?? '') ?>">

    <input type="number" name="anio"
    placeholder="Año de publicación"
    value="<?= htmlspecialchars($libroEditar['anio_publicacion'] ?? '') ?>">

    <select name="autor" required>
        <option value="">Seleccionar autor</option>

        <?php while($a = $autores->fetch_assoc()) { ?>
        <option value="<?= $a['id_autor'] ?>"
        <?= ($libroEditar && $libroEditar['id_autor'] == $a['id_autor']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($a['nombre']) ?>
        </option>
        <?php } ?>
    </select>

    <select name="editorial" required>
        <option value="">Seleccionar editorial</option>

        <?php while($e = $editoriales->fetch_assoc()) { ?>
        <option value="<?= $e['id_editorial'] ?>"
        <?= ($libroEditar && $libroEditar['id_editorial'] == $e['id_editorial']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($e['nombre']) ?>
        </option>
        <?php } ?>
    </select>

    <select name="disponibilidad">
        <option value="Disponible"
        <?= ($libroEditar && $libroEditar['disponibilidad'] == 'Disponible') ? 'selected' : '' ?>>
            Disponible
        </option>

        <option value="Prestado"
        <?= ($libroEditar && $libroEditar['disponibilidad'] == 'Prestado') ? 'selected' : '' ?>>
            Prestado
        </option>
    </select>

    <button type="submit" name="guardar">
        <?= $libroEditar ? "Actualizar libro" : "Guardar libro" ?>
    </button>

</form>

<?php if ($libroEditar) { ?>
<p><a href="libros.php">Cancelar modificación</a></p>
<?php } ?>

<h2>📖 Libros registrados</h2>

<table>
<tr>
    <th>ID</th>
    <th>Título</th>
    <th>ISBN</th>
    <th>Año</th>
    <th>Disponibilidad</th>
    <th>Acciones</th>
</tr>

<?php while($l = $libros->fetch_assoc()) { ?>

<tr>
    <td><?= $l['id_libro'] ?></td>

    <td><?= htmlspecialchars($l['titulo']) ?></td>

    <td><?= htmlspecialchars($l['ISBN'] ?? '') ?></td>

    <td><?= htmlspecialchars($l['anio_publicacion'] ?? '') ?></td>

    <td><?= htmlspecialchars($l['disponibilidad'] ?? '') ?></td>

    <td>
        <a class="editar"
        href="libros.php?editar=<?= $l['id_libro'] ?>">
        Editar</a>

        <form method="POST"
        onsubmit="return confirm('¿Deseas eliminar este libro?');">

            <input type="hidden" name="id_libro"
            value="<?= $l['id_libro'] ?>">

            <button class="eliminar"
            type="submit" name="eliminar">
                Eliminar
            </button>

        </form>
    </td>
</tr>

<?php } ?>

</table>

<a class="volver" href="menu.php">
← Volver al menú principal
</a>

</div>

</body>
</html>
