<?php
require_once 'Prestable.php';

class Libro implements Prestable {
    // Propiedades de la clase
    private $titulo;
    private $autor;
    private $anioPublicacion;
    private $disponible;

    /**
     * Constructor para inicializar las propiedades del libro.
     */
    public function __construct($titulo, $autor, $anioPublicacion) {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->anioPublicacion = $anioPublicacion;
        $this->disponible = true;
    }

    /**
     * Método para obtener la información del libro.
     */
    public function obtenerInformacion() {
        return "Título: " . $this->titulo . ", Autor: " . $this->autor . ", Año: " . $this->anioPublicacion;
    }

    // Implementación de los métodos de la interfaz Prestable
    public function prestar() {
        if ($this->disponible) {
            $this->disponible = false;
            return true;
        }
        return false;
    }

    public function devolver() {
        $this->disponible = true;
    }

    public function estaDisponible() {
        return $this->disponible;
    }
}

// Ejemplo de uso
$libro = new Libro("Rayuela", "Julio Cortázar", 1963);
echo $libro->obtenerInformacion() . "\n";
echo "Disponible: " . ($libro->estaDisponible() ? "Sí" : "No") . "\n";
$libro->prestar();
echo "Disponible después de prestar: " . ($libro->estaDisponible() ? "Sí" : "No") . "\n";
$libro->devolver();
echo "Disponible después de devolver: " . ($libro->estaDisponible() ? "Sí" : "No") . "\n";
?>
