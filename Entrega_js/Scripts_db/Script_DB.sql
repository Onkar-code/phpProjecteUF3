create database testdb;

Drop table if exists Producte;
Drop table if exists Client;

CREATE TABLE Client ( 
  id smallint primary key auto_increment,
  nom varchar(30) not null, 
  cognom1 varchar(30) not null, 
  cognom2 varchar(30) not null, 
  usuari varchar(30) not null unique, 
  password varchar(60) not null, 
  email varchar(30) not null unique,
  telefon int not null check (telefon >= 100000000 and telefon < 1000000000),
  dni varchar(9) not null unique,
  latitud float not null check (latitud > -90 and latitud < 90),
  longitud float not null check (longitud > -180 and longitud < 180)
); 

CREATE TABLE Producte (
  id smallint primary key auto_increment,
  nom varchar(30) not null,
  descripcio varchar(200),
  preu numeric(6,2) not null check (preu > 0),
  categoria varchar(30) not null,
  data_publicacio Date not null,
  visites int default 0,
  idClient smallint not null,
  foto1 varchar(100) not null,
  foto2 varchar(100) not null,
  foto3 varchar(100) not null
);

ALTER TABLE Producte
  ADD CONSTRAINT CHK_Categoria 
  CHECK (categoria = 'Libros' or categoria = 'Moviles' or categoria = 'Videojuegos');

ALTER TABLE Producte
  ADD CONSTRAINT FK_Client
  FOREIGN KEY (idClient) REFERENCES Client(id)
  ON DELETE CASCADE;
