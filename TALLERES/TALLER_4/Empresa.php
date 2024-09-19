<?php
require_once 'Empleado.php';
require_once 'Gerente.php';
require_once 'Desarrollador.php';
require_once 'Evaluable.php';

// Clase para gestionar la empresa y sus empleados
class Empresa {
    private $empleados = [];

    // Método para agregar un empleado a la empresa
    public function agregarEmpleado(Empleado $empleado) {
        $this->empleados[] = $empleado;
    }

    // Método para listar todos los empleados de la empresa
    public function listarEmpleados() {
        if (empty($this->empleados)) {
            echo "No hay empleados en la empresa.\n";
            return;
        }

        foreach ($this->empleados as $empleado) {
            echo "Nombre: " . $empleado->getNombre() . "\n";
            echo "ID: " . $empleado->getId() . "\n";
            echo "Salario Base: $" . $empleado->getSalarioBase() . "\n";
            if ($empleado instanceof Gerente) {
                echo "Departamento: " . $empleado->getDepartamento() . "\n";
            }
            if ($empleado instanceof Desarrollador) {
                echo "Lenguaje Principal: " . $empleado->getLenguajePrincipal() . "\n";
                echo "Nivel de Experiencia: " . $empleado->getNivelExperiencia() . "\n";
            }
            echo "\n";
        }
    }

    // Método para calcular la nómina total de la empresa
    public function calcularNominaTotal() {
        $total = 0;
        foreach ($this->empleados as $empleado) {
            $total += $empleado->getSalarioBase();
        }
        return $total;
    }

    // Método para realizar evaluaciones de desempeño para todos los empleados evaluables
    public function evaluarDesempenio() {
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Evaluable) {
                echo $empleado->evaluarDesempenio() . "\n";
            } else {
                echo "El empleado " . $empleado->getNombre() . " no implementa la interfaz Evaluable.\n";
            }
        }
    }
}
?>
