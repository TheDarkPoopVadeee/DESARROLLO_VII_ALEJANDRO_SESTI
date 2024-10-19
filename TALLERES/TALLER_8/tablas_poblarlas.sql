
-- Crear tabla de publicaciones
CREATE TABLE publicaciones (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    titulo VARCHAR(100) NOT NULL,
    contenido TEXT,
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Insertar usuarios de ejemplo
INSERT INTO usuarios (nombre, email) VALUES
('Ana García', 'ana@example.com'),
('Carlos Rodríguez', 'carlos@example.com'),
('Elena Martínez', 'elena@example.com'),
('David López', 'david@example.com');

-- Insertar publicaciones de ejemplo
INSERT INTO publicaciones (usuario_id, titulo, contenido) VALUES
(1, 'Mi primera publicación', 'Contenido de la primera publicación de Ana'),
(1, 'Reflexiones del día', 'Ana comparte sus pensamientos'),
(2, 'Tecnología moderna', 'Carlos habla sobre avances tecnológicos'),
(3, 'Receta del día', 'Elena comparte una receta deliciosa'),
(3, 'Viaje a la montaña', 'Experiencias de Elena en su última excursión'),
(3, 'Reseña de libro', 'Elena analiza su libro favorito'),
(4, 'Ejercicios para principiantes', 'David comparte rutinas de ejercicio');