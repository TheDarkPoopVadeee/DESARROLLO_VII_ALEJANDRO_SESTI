<?php

class Estudiante {
    private int $id;
    private string $nombre;
    private int $edad;
    private string $carrera;
    private array $materias; // ['materia' => calificacion]

    public function __construct(int $id, string $nombre, int $edad, string $carrera) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->carrera = $carrera;
        $this->materias = [];
    }

    public function agregarMateria(string $materia, float $calificacion): void {
        $this->materias[$materia] = $calificacion;
    }

    public function obtenerPromedio(): float {
        return array_sum($this->materias) / count($this->materias);
    }

    public function obtenerDetalles(): array {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'edad' => $this->edad,
            'carrera' => $this->carrera,
            'materias' => $this->materias,
            'promedio' => $this->obtenerPromedio()
        ];
    }

    public function __toString(): string {
        return $this->nombre . " (ID: {$this->id}) - Promedio: " . number_format($this->obtenerPromedio(), 2);
    }
}

class SistemaGestionEstudiantes {
    private array $estudiantes = [];
    private array $graduados = [];

    public function agregarEstudiante(Estudiante $estudiante): void {
        $this->estudiantes[$estudiante->obtenerDetalles()['id']] = $estudiante;
    }

    public function obtenerEstudiante(int $id): ?Estudiante {
        return $this->estudiantes[$id] ?? null;
    }

    public function listarEstudiantes(): array {
        return $this->estudiantes;
    }

    public function calcularPromedioGeneral(): float {
        $suma = array_reduce($this->estudiantes, function ($carry, $estudiante) {
            return $carry + $estudiante->obtenerPromedio();
        }, 0);
        return $suma / count($this->estudiantes);
    }

    public function obtenerEstudiantesPorCarrera(string $carrera): array {
        return array_filter($this->estudiantes, function ($estudiante) use ($carrera) {
            return stripos($estudiante->obtenerDetalles()['carrera'], $carrera) !== false;
        });
    }

    public function obtenerMejorEstudiante(): ?Estudiante {
        return array_reduce($this->estudiantes, function ($mejor, $estudiante) {
            return ($mejor === null || $estudiante->obtenerPromedio() > $mejor->obtenerPromedio()) ? $estudiante : $mejor;
        });
    }

    public function graduarEstudiante(int $id): void {
        if (isset($this->estudiantes[$id])) {
            $this->graduados[] = $this->estudiantes[$id];
            unset($this->estudiantes[$id]);
        }
    }

    // Implementar más métodos según sea necesario...
}

// Ejemplo de uso
$sistema = new SistemaGestionEstudiantes();

// Crear estudiantes
$estudiante1 = new Estudiante(1, "Juan Perez", 20, "Ingeniería");
$estudiante1->agregarMateria("Matemáticas", 85);
$estudiante1->agregarMateria("Física", 90);

$estudiante2 = new Estudiante(2, "Maria Gomez", 22, "Derecho");
$estudiante2->agregarMateria("Historia", 95);
$estudiante2->agregarMateria("Ética", 80);

// Agregar estudiantes al sistema
$sistema->agregarEstudiante($estudiante1);
$sistema->agregarEstudiante($estudiante2);

// Mostrar detalles de estudiantes
foreach ($sistema->listarEstudiantes() as $estudiante) {
    echo $estudiante . "\n";
}

// Mejor estudiante
$mejorEstudiante = $sistema->obtenerMejorEstudiante();
echo "Mejor estudiante: " . $mejorEstudiante . "\n";

// Calcular promedio general
echo "Promedio general: " . number_format($sistema->calcularPromedioGeneral(), 2) . "\n";

?>
