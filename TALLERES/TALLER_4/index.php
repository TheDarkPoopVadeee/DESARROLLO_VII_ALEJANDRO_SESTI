<?php
require_once 'Empleado.php';
require_once 'Gerente.php';
require_once 'Desarrollador.php';
require_once 'Evaluable.php';
require_once 'Empresa.php';

// Crear instancias de empleados
$gerente = new Gerente("Juan Pérez", "G001", 5000, "Ventas");
$desarrollador = new Desarrollador("Ana Gómez", "D001", 4000, "PHP", "Intermedio");

// Crear una instancia de la empresa
$empresa = new Empresa();

// Agregar empleados a la empresa
$empresa->agregarEmpleado($gerente);
$empresa->agregarEmpleado($desarrollador);

// Listar todos los empleados
echo "Listado de empleados:\n";
$empresa->listarEmpleados();

// Calcular la nómina total
echo "Nómina total: $" . $empresa->calcularNominaTotal() . "\n";

// Evaluar desempeño de los empleados
echo "Evaluaciones de desempeño:\n";
$empresa->evaluarDesempenio();
?>
