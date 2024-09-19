<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

// Clase Gerente que hereda de Empleado e implementa Evaluable
class Gerente extends Empleado implements Evaluable {
    private $departamento;

    // Constructor para inicializar las propiedades
    public function __construct($nombre, $id, $salarioBase, $departamento) {
        parent::__construct($nombre, $id, $salarioBase);
        $this->departamento = $departamento;
    }

    // Método getter y setter para departamento
    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    // Método para asignar un bono
    public function asignarBono($monto) {
        $this->salarioBase += $monto;
    }

    // Implementación del método evaluarDesempenio de la interfaz Evaluable
    public function evaluarDesempenio() {
        // Lógica específica para evaluar a un gerente
        return "Evaluación del desempeño del gerente " . $this->nombre;
    }
}
?>
