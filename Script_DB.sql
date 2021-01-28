Drop table Client;
Drop table Producte;
Drop table Fotografies;

CREATE TABLE Client ( 
  id smallint primary key auto_increment,
  nom varchar(30) not null, 
  cognom1 varchar(30) not null, 
  cognom2 varchar(30), 
  usuari varchar(30) not null, 
  password varchar(50) not null, 
  email varchar(30) not null 
); 

CREATE TABLE Producte (
  id smallint primary key auto_increment,
  nom varchar(30) not null,
  descripcio varchar(100) not null,
  preu numeric(5,2) not null check (preu > 0),
  categoria varchar(30) not null,
  data_publicacio Date not null,
  visites int default 0,
  idClient smallint not null,
  numFotos int default 0
);

ALTER TABLE Producte
  ADD CONSTRAINT CHK_Fotos 
  CHECK (numFotos < 4);

ALTER TABLE Producte
  ADD CONSTRAINT CHK_Categoria 
  CHECK (categoria = 'Libros' or categoria = 'Moviles' or categoria = 'Videojuegos');

ALTER TABLE Producte
  ADD CONSTRAINT FK_Client
  FOREIGN KEY (idClient) REFERENCES Client(id)
  ON DELETE CASCADE;

CREATE TABLE Fotografies ( 
  idFoto smallint primary key auto_increment,
  idProducte smallint not null,
  url varchar(100) 
); 

ALTER TABLE Fotografies
  ADD CONSTRAINT FK_Producte
  FOREIGN KEY (idProducte) REFERENCES Producte(id);
