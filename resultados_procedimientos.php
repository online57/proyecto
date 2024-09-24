<?php
// Incluir el archivo de conexion a la base de datos
include 'bd/conexion.php';

//Permitir los metodos GET, POST, PUT, DELETE, OPTIONS
// Encabezados CORS para permitir todas las solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Verificar el método de solicitud
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

//***************************************METODO GET*************************************************
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Para llamar la tabla id resultado de la base de datos
    if (isset($_GET['id_resultado'])) {

        $idre = $_GET['id_resultado'];

        $sentencia = $conexion->prepare("SELECT * FROM resultados_procedimientos WHERE 	id_resultado LIKE CONCAT(?)");

        $sentencia->bind_param('i', $idre);

        $sentencia->execute();

        $resultado = $sentencia->get_result();

        if ($resultado->num_rows > 0) {

            $fila = $resultado->fetch_all(MYSQLI_ASSOC);

            echo json_encode(['data' => $fila], JSON_UNESCAPED_UNICODE);

        } else {

            echo json_encode(['error' => 'No se encontro el id.'], JSON_UNESCAPED_UNICODE);
        }

        
        $sentencia->close();

    // Si se proporciona el id del procedimiento en la URL
    }elseif (isset($_GET['id_procedimiento '])) {

        $idproced = $_GET['id_procedimiento '];

        $sentencia = $conexion->prepare("SELECT * FROM resultados_procedimientos WHERE id_procedimiento  LIKE CONCAT(?,'%')");

        $sentencia->bind_param('s', $idproced);

        $sentencia->execute();

        $resultado = $sentencia->get_result();

        if ($resultado->num_rows > 0) {

            $fila = $resultado->fetch_all(MYSQLI_ASSOC);

            echo json_encode(['data' => $fila], JSON_UNESCAPED_UNICODE);

        } else {

            echo json_encode(['error' => 'No se encontro la numero del procedimiento.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();

    // Si se proporciona resultado en la URL
    }elseif (isset($_GET['resultado'])) {

        $res = $_GET['resultado'];

        $sentencia = $conexion->prepare("SELECT * FROM resultados_procedimientos WHERE resultado LIKE CONCAT(?,'%')");

        $sentencia->bind_param('s', $res);

        $sentencia->execute();

        $resultado = $sentencia->get_result();

        if ($resultado->num_rows > 0) {

            $fila = $resultado->fetch_all(MYSQLI_ASSOC);

            echo json_encode(['data' => $fila], JSON_UNESCAPED_UNICODE);

        } else {

            echo json_encode(['error' => 'No se encontro este resultado.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();
    
    // Si se proporciona esta unidad en la URL
    }elseif (isset($_GET['unidad'])) {

        $unidad= $_GET['unidad'];

        $sentencia = $conexion->prepare("SELECT * FROM resultados_procedimientos WHERE unidad LIKE CONCAT(?,'%')");

        $sentencia->bind_param('s', $esp);

        $sentencia->execute();

        $resultado = $sentencia->get_result();

        if ($resultado->num_rows > 0) {

            $fila = $resultado->fetch_all(MYSQLI_ASSOC);

            echo json_encode(['data' => $fila], JSON_UNESCAPED_UNICODE);

        } else {

            echo json_encode(['error' => 'No se encontro esta unidad.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();

    // Si se proporciona un rango de referencia en la URL
    }elseif (isset($_GET['rango_referencia'])) {

        $ranre = $_GET['rango_referencia'];

        $sentencia = $conexion->prepare("SELECT * FROM resultados_procedimientos WHERE rango_referencia LIKE CONCAT(?,'%')");

        $sentencia->bind_param('s', $ranre);

        $sentencia->execute();

        $resultado = $sentencia->get_result();

        if ($resultado->num_rows > 0) {

            $fila = $resultado->fetch_all(MYSQLI_ASSOC);

            echo json_encode(['data' => $fila], JSON_UNESCAPED_UNICODE);

        } else {

            echo json_encode(['error' => 'No se encontro el rango de referencia.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();


      

    // Si no se proporciona ningun parametro en la URL
    }else {

        $resultado = $conexion->query("SELECT * FROM resultados_procedimientos");

        if ($resultado->num_rows > 0) {

            $fila = $resultado->fetch_all(MYSQLI_ASSOC);

            echo json_encode(['data' => $fila], JSON_UNESCAPED_UNICODE);

        } else {

            echo json_encode(['error' => 'No se encontraron resultados.'], JSON_UNESCAPED_UNICODE);
        }
    }
}

//***************************************METODO POST*************************************************

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si los campos estan presentes
    if (
        isset($_POST['t1']) &&
        isset($_POST['t2']) &&
        isset($_POST['t3']) &&
        isset($_POST['t4'])  
    ) {
        
        // Obtener datos desde la solicitud POST
        $idproced = $_POST['t1'];
        $res = $_POST['t2']; 
        $unidad = $_POST['t3'];
        $ranre = $_POST['t4'];
        

        // Evitar SQL Injection usando consultas preparadas
        $sentencia = $conexion->prepare("INSERT INTO resultados_procedimientos ( id_procedimiento, resultado, unidad, rango_referencia) VALUES (?, ?, ?, ?)");
        $sentencia->bind_param('isss', $idproced, $res, $unidad, $ranre);

        // Ejecutar la consulta
        if ($sentencia->execute()) {
            echo json_encode(['message' => 'Registro exitoso.'], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['error' => 'Error no se pudo guardar.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();
    } else {
        echo json_encode(['error' => 'Se necesitan todos los campos para poder guardar.'], JSON_UNESCAPED_UNICODE);
    }

    $conexion->close();
}

//***************************************METODO PUT*************************************************

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT); 
    // Verificar si los campos estan presentes
    if (
        isset($_PUT['t1']) &&
        isset($_PUT['t2']) &&
        isset($_PUT['t3']) &&
        isset($_PUT['t4']) &&
        isset($_PUT['t5']) 
    ) {
        
        // Obtener datos desde la solicitud POST
        $idre = $_PUT['t1'];
        $idproced = $_PUT['t2'];
        $res = $_PUT['t3'];
        $unidad= $_PUT['t4'];
        $ranre= $_PUT['t5'];
    
        
        // Evitar SQL Injection usando consultas preparadas
        $sentencia = $conexion->prepare("UPDATE resultados_procedimientos SET  id_procedimiento =?, resultado=?, unidad=?, rango_referencia=? WHERE id_resultado=?");
        $sentencia->bind_param('isssi', $idproced, $res, $unidad, $ranre,  $idre);

        // Ejecutar la consulta
        if ($sentencia->execute()) {
            echo json_encode(['message' => 'Edicion exitosa.'], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['error' => 'Error no se pudo editar.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();
    } else {
        echo json_encode(['error' => 'Se necesitan todos los campos para poder editar.'], JSON_UNESCAPED_UNICODE);
    }

    $conexion->close();
}

//***************************************METODO DELETE*************************************************

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE); 
    // Verificar si los campos estan presentes
    if (
        isset($_DELETE['id_resultado']) 
    ) {
        
        // Obtener datos desde la solicitud POST
        $idpro = $_DELETE['id_resultado'];
        
        // Evitar SQL Injection usando consultas preparadas
        $sentencia = $conexion->prepare("DELETE FROM resultados_procedimientos  WHERE id_resultado=?");
        $sentencia->bind_param('i', $idpro);

        // Ejecutar la consulta
        if ($sentencia->execute()) {
            echo json_encode(['message' => 'profesional eliminado con exito.'], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['error' => 'Error no se pudo eliminar.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();
    } else {
        echo json_encode(['error' => 'Se necesitan todos los campos para poder eliminar.'], JSON_UNESCAPED_UNICODE);
    }

    $conexion->close();
}

?>
