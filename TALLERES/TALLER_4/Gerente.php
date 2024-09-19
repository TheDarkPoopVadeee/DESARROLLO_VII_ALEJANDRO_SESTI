<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

class Gerente extends Empleado implements Evaluable {
    private $departamento;
    private $bono;

    public function __construct($nombre, $idEmpleado, $salarioBase, $departamento) {
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        $this->departamento = $departamento;
        $this->bono = 0; // Inicialmente sin bono
    }

    // Getters y Setters
    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function getBono() {
        return $this->bono;
    }

    public function setBono($bono) {
        $this->bono = $bono;
    }

    // Métodos específicos
    public function asignarBono($monto) {
        $this->bono = $monto;
    }

    // Implementación del método de la interfaz
    public function evaluarDesempenio() {
        return "Evaluación de desempeño del gerente: Excelente.";
    }

    public function __toString() {
        return parent::__toString() . ", Departamento: $this->departamento, Bono: $this->bono";
    }
}
