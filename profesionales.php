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

    // Para llamar la tabla profesionales de la base de datos
    if (isset($_GET['id_profesional'])) {

        $idpro = $_GET['id_profesional'];

        $sentencia = $conexion->prepare("SELECT * FROM profesionales WHERE id_profesional LIKE CONCAT(?)");

        $sentencia->bind_param('i', $idpro);

        $sentencia->execute();

        $resultado = $sentencia->get_result();

        if ($resultado->num_rows > 0) {

            $fila = $resultado->fetch_all(MYSQLI_ASSOC);

            echo json_encode(['data' => $fila], JSON_UNESCAPED_UNICODE);

        } else {

            echo json_encode(['error' => 'No se encontro el id.'], JSON_UNESCAPED_UNICODE);
        }

        
        $sentencia->close();

    // Si se proporciona la profesional en la URL
    }elseif (isset($_GET['nombre_profesional'])) {

        $nompro = $_GET['nombre_profesional'];

        $sentencia = $conexion->prepare("SELECT * FROM profesionales WHERE nombre_profesional LIKE CONCAT(?,'%')");

        $sentencia->bind_param('s', $nompro);

        $sentencia->execute();

        $resultado = $sentencia->get_result();

        if ($resultado->num_rows > 0) {

            $fila = $resultado->fetch_all(MYSQLI_ASSOC);

            echo json_encode(['data' => $fila], JSON_UNESCAPED_UNICODE);

        } else {

            echo json_encode(['error' => 'No se encontro la profesional.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();

    // Si se proporciona un numero en la URL
    }elseif (isset($_GET['numero_licencia'])) {

        $numli = $_GET['numero_licencia'];

        $sentencia = $conexion->prepare("SELECT * FROM profesionales WHERE numero_licencia LIKE CONCAT(?,'%')");

        $sentencia->bind_param('s', $numli);

        $sentencia->execute();

        $resultado = $sentencia->get_result();

        if ($resultado->num_rows > 0) {

            $fila = $resultado->fetch_all(MYSQLI_ASSOC);

            echo json_encode(['data' => $fila], JSON_UNESCAPED_UNICODE);

        } else {

            echo json_encode(['error' => 'No se encontro este numero de licencia.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();
    
    // Si se proporciona esta especialidad en la URL
    }elseif (isset($_GET['especialidad'])) {

        $esp= $_GET['especialidad'];

        $sentencia = $conexion->prepare("SELECT * FROM profesionales WHERE especialidad LIKE CONCAT(?,'%')");

        $sentencia->bind_param('s', $esp);

        $sentencia->execute();

        $resultado = $sentencia->get_result();

        if ($resultado->num_rows > 0) {

            $fila = $resultado->fetch_all(MYSQLI_ASSOC);

            echo json_encode(['data' => $fila], JSON_UNESCAPED_UNICODE);

        } else {

            echo json_encode(['error' => 'No se encontro el esta especialidad.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();

    // Si se proporciona un direccion en la URL
    }elseif (isset($_GET['telefono'])) {

        $tel = $_GET['telefono'];

        $sentencia = $conexion->prepare("SELECT * FROM profesionales WHERE telefono LIKE CONCAT(?,'%')");

        $sentencia->bind_param('s', $tel);

        $sentencia->execute();

        $resultado = $sentencia->get_result();

        if ($resultado->num_rows > 0) {

            $fila = $resultado->fetch_all(MYSQLI_ASSOC);

            echo json_encode(['data' => $fila], JSON_UNESCAPED_UNICODE);

        } else {

            echo json_encode(['error' => 'No se encontro el direccion.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();


        // Si se proporciona el correo electronico en la URL
    }elseif (isset($_GET['correo_electronico'])) {

        $correo = $_GET['correo_electronico'];

        $sentencia = $conexion->prepare("SELECT * FROM profesionales WHERE correo_electronico LIKE CONCAT(?,'%')");

        $sentencia->bind_param('s', $correo);

        $sentencia->execute();

        $resultado = $sentencia->get_result();

        if ($resultado->num_rows > 0) {

            $fila = $resultado->fetch_all(MYSQLI_ASSOC);

            echo json_encode(['data' => $fila], JSON_UNESCAPED_UNICODE);

        } else {

            echo json_encode(['error' => 'No se encontro el correo electronico.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();
      

    // Si no se proporciona ningun parametro en la URL
    }else {

        $resultado = $conexion->query("SELECT * FROM profesionales");

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
        isset($_POST['t4']) &&
        isset($_POST['t5']) 
    ) {
        
        // Obtener datos desde la solicitud POST
        $nompro = $_POST['t1'];
        $numli = $_POST['t2']; 
        $esp = $_POST['t3'];
        $tel = $_POST['t4'];
        $correo = $_POST['t5'];

        // Evitar SQL Injection usando consultas preparadas
        $sentencia = $conexion->prepare("INSERT INTO profesionales ( nombre_profesional, numero_licencia, especialidad, telefono, correo_electronico) VALUES (?, ?, ?, ?, ?)");
        $sentencia->bind_param('isssss', $nompro, $numli, $esp, $tel,  $correo);

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
        isset($_PUT['t5']) &&
        isset($_PUT['t6']) 
    ) {
        
        // Obtener datos desde la solicitud POST
        $idpro = $_PUT['t1'];
        $nompro = $_PUT['t2'];
        $numli = $_PUT['t3'];
        $esp= $_PUT['t4'];
        $tel= $_PUT['t5'];
        $correo =$_PUT['t6'];
        
        // Evitar SQL Injection usando consultas preparadas
        $sentencia = $conexion->prepare("UPDATE profesionales SET nombre_profesional=?, numero_licencia=?, especialidad=?, telefono=?, correo_electronico=? WHERE id_profesional=?");
        $sentencia->bind_param('sssssi', $nompro, $numli, $esp, $tel,  $correo, $idpro);

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
        isset($_DELETE['id_profesional']) 
    ) {
        
        // Obtener datos desde la solicitud POST
        $idpro = $_DELETE['id_profesional'];
        
        // Evitar SQL Injection usando consultas preparadas
        $sentencia = $conexion->prepare("DELETE FROM profesionales  WHERE id_profesional=?");
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
