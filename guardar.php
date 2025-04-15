<?php
// Conectar a la base de datos
require_once '../conexion/conexion.php';

// Obtener los datos enviados desde el cliente
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $semestre = $data['semestre'];
    $materia = $data['materia'];
    $paralelo = $data['paralelo'];
    $notasMenores = $data['notasMenores'];
    $notasMayores = $data['notasMayores'];
    $aprobados = $data['aprobados'];
    $reprobados = $data['reprobados'];
    $retirados = $data['retirados'];
    $totalEstudiantes = $data['totalEstudiantes'];
    $promedioMenores = $data['promedioMenores'];
    $promedioMayores = $data['promedioMayores'];

    // Aquí puedes insertar los datos en la base de datos
    $query = "INSERT INTO tutoria (semestre, materia, paralelo, notas_menores, notas_mayores, aprobados, reprobados, retirados, total_estudiantes, promedio_menores, promedio_mayores) VALUES ('$semestre', '$materia', '$paralelo', '$notasMenores', '$notasMayores', '$aprobados', '$reprobados', '$retirados', '$totalEstudiantes', '$promedioMenores', '$promedioMayores')";

    if (mysqli_query($conexion, $query)) {
        echo "Datos guardados correctamente.";
    } else {
        echo "Error al guardar los datos: " . mysqli_error($conexion);
    }
} else {
    echo "No se recibieron datos.";
}
?>
