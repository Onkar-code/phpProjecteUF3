create table Producte (
  id serial primary key,
  nom varchar(30) not null,
  descripcio varchar(100) not null,
  preu numeric(5,2) not null check > 0,
  altura int check > 0,
  ample int check > 0,
  fons int check > 0,
  pes numeric(5,3) not null check > 0,
  categoria varchar(30) not null,
  data_publicacio Date not null,
  visites int default 0,
  idClient int not null,
  numFotos int default 0
);

ALTER TABLE Producte
ADD CONSTRAINT CHK_Fotos CHECK (numFotos < 4);

ALTER TABLE Producte
ADD CONSTRAINT CHK_Categoria CHECK (categoria = 'Libros' or categoria = 'Moviles' or categoria = 'Videojuegos');

ALTER TABLE Producte
ADD CONSTRAINT FK_Client
FOREIGN KEY (idClient) REFERENCES Client(id);

create table Client (
  id serial primary key,
  nom varchar(30) not null,
  cognom1 varchar(30) not null,
  cognom2 varchar(30),
  usuari varchar(30) not null,
  password varchar(50) not null,
  email varchar(30) not null
);

create table Fotografies (
  idFoto serial primary key,
  idProducte int not null,
  url varchar(100)
);

ALTER TABLE Fotografies
ADD CONSTRAINT FK_Producte
FOREIGN KEY (idProducte) REFERENCES Producte(id);
