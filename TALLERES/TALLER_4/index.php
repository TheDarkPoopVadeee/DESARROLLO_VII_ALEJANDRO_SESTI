<?php
require_once 'Empleado.php';
require_once 'Gerente.php';
require_once 'Desarrollador.php';
require_once 'Evaluable.php';
require_once 'Empresa.php';

// Crear instancias de empleados
$gerente = new Gerente("Juan Pérez", "G123", 5000, "TI");
$gerente->asignarBono(1000);

$desarrollador = new Desarrollador("Ana Gómez", "D456", 3000, "PHP", "Senior");

// Crear una instancia de empresa y agregar empleados
$empresa = new Empresa();
$empresa->agregarEmpleado($gerente);
$empresa->agregarEmpleado($desarrollador);

// Listar empleados
echo "Listado de empleados:\n";
$empresa->listarEmpleados();

// Calcular nómina total
echo "Nómina total: " . $empresa->calcularNominaTotal() . "\n";

// Evaluar desempeño
echo "Evaluaciones de desempeño:\n";
$empresa->evaluarDesempenio();
