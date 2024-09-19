<?php

// Clase base para los empleados
class Empleado {
    protected $nombre;
    protected $id;
    protected $salarioBase;

    // Constructor para inicializar las propiedades
    public function __construct($nombre, $id, $salarioBase) {
        $this->nombre = $nombre;
        $this->id = $id;
        $this->salarioBase = $salarioBase;
    }

    // Métodos getter y setter para nombre
    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    // Métodos getter y setter para ID
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Métodos getter y setter para salario base
    public function getSalarioBase() {
        return $this->salarioBase;
    }

    public function setSalarioBase($salarioBase) {
        $this->salarioBase = $salarioBase;
    }
}
?>