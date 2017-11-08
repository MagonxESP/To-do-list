DROP DATABASE IF EXISTS todo_list;

CREATE DATABASE IF NOT EXISTS todo_list CHARACTER SET utf8 COLLATE utf8_unicode_ci;

USE todo_list;

CREATE TABLE usuarios (
  id_usuario INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL UNIQUE,
  password CHAR(32) NOT NULL
)ENGINE=INNODB;

CREATE TABLE tareas (
	id_tarea INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT NOT NULL,
    acabado BOOLEAN NOT NULL DEFAULT false,
    fecha_creacion DATE NOT NULL,
    fecha_entrega DATE NOT NULL,
    usuario INT NOT NULL,
    FOREIGN KEY (usuario) REFERENCES usuarios(id_usuario)
		ON UPDATE CASCADE
        ON DELETE CASCADE
)ENGINE=INNODB;