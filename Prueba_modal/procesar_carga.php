<?php
require_once '../conexion_db.php';

$tipo = $_FILES['archivo_excel']['type'];
$tamanio = $_FILES['archivo_excel']['size'];
$archivotmp = $_FILES['archivo_excel']['tmp_name'];
$lineas = file($archivotmp);
$i = 0;
$cantidad_regist_agregados = 0;
$cantidad_regist_actualizados = 0;

foreach ($lineas as $linea) {
    $cantidad_registros = count($lineas);
    $cantidad_regist_agregados = ($cantidad_registros - 1);

    if ($i != 0) {
        $datos = explode(';', $linea);

        // Asegúrate de validar y convertir los datos según corresponda
        $producto = mysqli_real_escape_string($conexion, $datos[0]);
        $codigo = mysqli_real_escape_string($conexion, $datos[1]);
        $precio = floatval($datos[2]);
        $stock = intval($datos[4]);

        // Validar si el producto con el mismo código ya existe
        $query = "SELECT id FROM inventario WHERE codigo = '$codigo'";
        $resultado = mysqli_query($conexion, $query);

        if (!$resultado) {
            die("Error en la consulta: " . mysqli_error($conexion));
        }

        if (mysqli_num_rows($resultado) == 0) {
            // Realizar la inserción en la base de datos
            $query = "INSERT INTO inventario (producto, codigo, precio, stock) VALUES ('$producto', '$codigo', $precio, $stock)";

            if (!mysqli_query($conexion, $query)) {
                die("Error al insertar datos: " . mysqli_error($conexion));
            }

            // Contar la cantidad de registros agregados
            $cantidad_regist_agregados++;
        } else {
            if (isset($_POST['actualizar']) && $_POST['actualizar'] == 'on') {
            //Actualizar el producto existente en la base de datos
            $query = "UPDATE inventario SET producto = '$producto', precio = $precio, stock = $stock WHERE codigo = '$codigo'";

            if (!mysqli_query($conexion, $query)) {
                die("Error al actualizar datos: " . mysqli_error($conexion));
            }

            } 
            else {
                // El checkbox no está marcado, no se ejecuta el código
                echo "El checkbox no está marcado.";
            }
            // Contar la cantidad de registros actualizados
            $cantidad_regist_actualizados++;
        }
    }

    $i++;
}

// Mostrar un mensaje de éxito con la cantidad de registros agregados y actualizados
if ($cantidad_regist_agregados > 0 || $cantidad_regist_actualizados > 0) {
    echo "$cantidad_regist_agregados registros agregados y $cantidad_regist_actualizados registros actualizados exitosamente";

    // Agregar la variable al script JavaScript
    echo '<script>';
    echo 'const cantidadRegistros = ' . json_encode($cantidad_regist_agregados) . ';';
    echo '</script>';
    header('Location: index.php?actualizacion_masiva_exitosa=true');
    exit();
}


// Cerrar la conexión
mysqli_close($conexion);
?>
