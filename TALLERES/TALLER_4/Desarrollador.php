<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

// Clase Desarrollador que hereda de Empleado e implementa Evaluable
class Desarrollador extends Empleado implements Evaluable {
    private $lenguajePrincipal;
    private $nivelExperiencia;

    // Constructor para inicializar las propiedades
    public function __construct($nombre, $id, $salarioBase, $lenguajePrincipal, $nivelExperiencia) {
        parent::__construct($nombre, $id, $salarioBase);
        $this->lenguajePrincipal = $lenguajePrincipal;
        $this->nivelExperiencia = $nivelExperiencia;
    }

    // Métodos getter y setter para lenguaje principal
    public function getLenguajePrincipal() {
        return $this->lenguajePrincipal;
    }

    public function setLenguajePrincipal($lenguajePrincipal) {
        $this->lenguajePrincipal = $lenguajePrincipal;
    }

    // Métodos getter y setter para nivel de experiencia
    public function getNivelExperiencia() {
        return $this->nivelExperiencia;
    }

    public function setNivelExperiencia($nivelExperiencia) {
        $this->nivelExperiencia = $nivelExperiencia;
    }

    // Implementación del método evaluarDesempenio de la interfaz Evaluable
    public function evaluarDesempenio() {
        // Lógica específica para evaluar a un desarrollador
        return "Evaluación del desempeño del desarrollador " . $this->nombre;
    }
}
?>
