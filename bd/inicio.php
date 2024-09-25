<?php
include 'conexion.php'; // Conectar a la base de datos

// Obtener el nombre del paciente desde la base de datos
$consultaPaciente = "SELECT nombre_completo FROM pacientes WHERE id_paciente = 1"; // Cambia según tu lógica
$resultadoPaciente = mysqli_query($conn, $consultaPaciente);
$nombrePaciente = mysqli_fetch_assoc($resultadoPaciente)['nombre_completo'];

// Verificar si se ha enviado el formulario de búsqueda
if (isset($_GET['numero_orden']) && isset($_GET['fecha_desde']) && isset($_GET['fecha_hasta'])) {
    $numero_orden = $_GET['numero_orden'];
    $fecha_desde = $_GET['fecha_desde'];
    $fecha_hasta = $_GET['fecha_hasta'];

    // Consulta para obtener las órdenes del paciente
    $consultaOrdenes = "SELECT fecha_orden, codigo_documento, numero_orden 
                        FROM ordenes_laboratorio 
                        WHERE id_orden = '$numero_orden' 
                        AND fecha_orden BETWEEN '$fecha_desde' AND '$fecha_hasta'";

    $resultadoOrdenes = mysqli_query($conn, $consultaOrdenes);
}
?>