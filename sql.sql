CREATE DATABASE gestion_automoviles;

USE gestion_automoviles;

CREATE TABLE marcas (
  id BIGINT PRIMARY KEY AUTO_INCREMENT, 
  nombre TEXT NOT NULL
);

CREATE TABLE modelos (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  nombre TEXT NOT NULL,
  marca_id BIGINT REFERENCES marcas(id)
);

CREATE TABLE tipos_vehiculo (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  nombre TEXT NOT NULL UNIQUE
);

CREATE TABLE automoviles (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  placa TEXT NOT NULL UNIQUE,
  marca_id BIGINT REFERENCES marcas(id),
  modelo_id BIGINT REFERENCES modelos(id),
  ano INT NOT NULL,
  color TEXT NOT NULL,
  numero_motor TEXT NOT NULL,
  numero_chasis TEXT NOT NULL,
  tipo_vehiculo_id BIGINT REFERENCES tipos_vehiculo(id)
);

INSERT INTO marcas (nombre) 
VALUES 
    ('Toyota'),
    ('Honda'),
    ('Ford'),
    ('Chevrolet'),
    ('BMW');

INSERT INTO modelos (nombre, marca_id)
VALUES
    ('Corolla', 1), 
    ('Civic', 2),    
    ('Focus', 3),     
    ('Cruze', 4),     
    ('Serie 3', 5);   

INSERT INTO tipos_vehiculo (nombre)
VALUES
    ('Sedán'),
    ('Hatchback'),
    ('SUV'),
    ('Camioneta'),
    ('Microbús');


-----------------------------------------------------------------

CREATE DATABASE gestion_automoviles;

USE gestion_automoviles;

CREATE TABLE marcas (
  id BIGINT PRIMARY KEY AUTO_INCREMENT, 
  nombre TEXT NOT NULL UNIQUE
);

CREATE TABLE tipos_vehiculo (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  nombre TEXT NOT NULL UNIQUE
);

CREATE TABLE modelos (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  nombre TEXT NOT NULL,
  marca_id BIGINT REFERENCES marcas(id),
  tipo_vehiculo_id BIGINT REFERENCES tipos_vehiculo(id)
);

CREATE TABLE automoviles (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  placa TEXT NOT NULL UNIQUE,
  marca_id BIGINT REFERENCES marcas(id),
  modelo_id BIGINT REFERENCES modelos(id),
  ano INT NOT NULL,
  color TEXT NOT NULL,
  numero_motor TEXT NOT NULL,
  numero_chasis TEXT NOT NULL,
  tipo_vehiculo_id BIGINT REFERENCES tipos_vehiculo(id)
);

CREATE TABLE propietarios (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  nombre TEXT NOT NULL,
  apellido TEXT NOT NULL,
  telefono TEXT NOT NULL,
  documentacion TEXT NOT NULL UNIQUE,
  tipo_propietario ENUM('natural', 'juridico') NOT NULL
);

CREATE TABLE propietario_automovil (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  documentacion TEXT NOT NULL REFERENCES propietarios(documentacion),
  placa TEXT NOT NULL REFERENCES automoviles(placa)
);
ALTER TABLE propietarios_automoviles
ADD nombre VARCHAR(50),
    apellido VARCHAR(50);


INSERT INTO marcas (nombre) 
VALUES 
    ('Toyota'),
    ('Honda'),
    ('Ford'),
    ('Chevrolet'),
    ('BMW');

INSERT INTO tipos_vehiculo (nombre)
VALUES
    ('Sedán'),
    ('Hatchback'),
    ('SUV'),
    ('Camioneta'),
    ('Microbús');

INSERT INTO modelos (nombre, marca_id, tipo_vehiculo_id)
VALUES
    ('Corolla', 1, 1),  -- Corolla - Toyota - Sedán
    ('Civic', 2, 1),    -- Civic - Honda - Sedán
    ('Focus', 3, 1),    -- Focus - Ford - Sedán
    ('Cruze', 4, 1),    -- Cruze - Chevrolet - Sedán
    ('Serie 3', 5, 1),  -- Serie 3 - BMW - Sedán
    
    ('Yaris', 1, 2),     -- Yaris - Toyota - Hatchback
    ('Fit', 2, 2),       -- Fit - Honda - Hatchback
    ('Fiesta', 3, 2),    -- Fiesta - Ford - Hatchback
    ('Spark', 4, 2),      -- Spark - Chevrolet - Hatchback
    ('X1', 5, 2),        -- X1 - BMW - Hatchback
    
    ('RAV4', 1, 3),       -- RAV4 - Toyota - SUV
    ('CR-V', 2, 3),       -- CR-V - Honda - SUV
    ('Escape', 3, 3),     -- Escape - Ford - SUV
    ('Equinox', 4, 3),    -- Equinox - Chevrolet - SUV
    ('X5', 5, 3),         -- X5 - BMW - SUV
    
    ('T100', 1, 4),        -- T100 - Toyota - Camión
    ('Silverado', 4, 4),   -- Silverado - Chevrolet - Camión
    ('F150', 3, 4),       -- F150 - Ford - Camión
    ('X7', 5, 4),          -- X7 - BMW - Camión
    ('Land Cruiser', 1, 4),-- Land Cruiser - Toyota - Camión
    
    ('Coaster', 1, 5),      -- Coaster - Toyota - Microbús
    ('Transit', 3, 5),      -- Transit - Ford - Microbús
    ('City Bus', 4, 5),    -- City Bus - Chevrolet - Microbús
    ('Neptunus', 5, 5),    -- Neptunus - BMW - Microbús
    ('Scopio', 2, 5);      -- Scopio - Honda - Microbús




-----------------------------------------------------------------

CREATE DATABASE gestion_automoviles;

USE gestion_automoviles;

-- Creación de la tabla Marcas
CREATE TABLE marcas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

-- Creación de la tabla Tipos de Vehículo
CREATE TABLE tipos_vehiculo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

-- Creación de la tabla Modelos
CREATE TABLE modelos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    marca_id INT NOT NULL,
    tipo_vehiculo_id INT NOT NULL,
    FOREIGN KEY (marca_id) REFERENCES marcas(id),
    FOREIGN KEY (tipo_vehiculo_id) REFERENCES tipos_vehiculo(id)
);

-- Creación de la tabla Automóviles
CREATE TABLE automoviles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    placa VARCHAR(15) NOT NULL UNIQUE,
    marca_id INT NOT NULL,
    modelo_id INT NOT NULL,
    ano YEAR NOT NULL,
    color VARCHAR(50) NOT NULL,
    numero_motor VARCHAR(50),
    numero_chasis VARCHAR(50),
    tipo_vehiculo_id INT NOT NULL,
    FOREIGN KEY (marca_id) REFERENCES marcas(id),
    FOREIGN KEY (modelo_id) REFERENCES modelos(id),
    FOREIGN KEY (tipo_vehiculo_id) REFERENCES tipos_vehiculo(id)
);

-- Creación de la tabla Propietarios
CREATE TABLE propietarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    telefono VARCHAR(15),
    documentacion VARCHAR(20) NOT NULL UNIQUE,
    tipo_propietario ENUM('natural', 'juridico') NOT NULL
);

-- Creación de la tabla Propietario_Automóvil (relación entre propietarios y automóviles)
CREATE TABLE propietario_automovil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    documentacion VARCHAR(20) NOT NULL,
    placa VARCHAR(15) NOT NULL,
    FOREIGN KEY (documentacion) REFERENCES propietarios(documentacion),
    FOREIGN KEY (placa) REFERENCES automoviles(placa)
);
