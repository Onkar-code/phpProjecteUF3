INSERT INTO Client(nom, cognom1, cognom2, usuari, password, email) VALUES ('Celio','Lark','Durand', 'C.Lark', '0123456ABC', 'CelioLark.Duran@gmail.com');
INSERT INTO Client(nom, cognom1, cognom2, usuari, password, email) VALUES ('Victor','Blas','Gallo', 'V.Blas', '0123456DEF', 'VictorBlas.Gallo@gmail.com');
INSERT INTO Client(nom, cognom1, cognom2, usuari, password, email)  VALUES ('Angel','Emilio','Gil', 'A.Emilio', '0123456GHI', 'AngelEmilio.Gil@gmail.com');


INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('Avengers 1','Semi nuevo, se vende por desuso', 10.50, 'Libros', "20/01/2021", default, 1,1);
INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('Avengers 2','Semi nuevo', 11.50, 'Libros', "21/12/2020", default, 1,1);
INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('CyberPunk','Basura de juego', 20.50, 'Videojuegos', "23/01/2021", default, 1,1);

INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('Spider-man','Nuevo, collección', 14.50,'Libros', "23/01/2021", default, 2,1);
INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('Minecraft','Para otakus', 5.0, 'Videojuegos', "01/02/2021", default, 2,1);
INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('Iphone10','Quiero pasarme a samsung', 699.0, 'Moviles', "29/01/2021", default, 2,1);


INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('Samsung','Quiero pasarme a Iphone', 499.50, 'Moviles', "23/01/2021", default, 3,1);
INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('San andreas','Para gangsters', 20.0, 'Videojuegos', "01/07/2020", default, 3,1);
INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('Blacklist','Sinopsis: en mi vida lo he leído julio', 10.0, 'Libros', "29/01/2021", default, 3,1);

COMMIT;

