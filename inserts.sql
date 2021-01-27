INSERT INTO Client(nom, cognom1, cognom2, usuari, password, email) VALUES ('Celio','Lark','Durand', 'C.Lark', '0123456ABC', 'CelioLark.Duran@gmail.com');
INSERT INTO Client(nom, cognom1, cognom2, usuari, password, email) VALUES ('Victor','Blas','Gallo', 'V.Blas', '0123456DEF', 'VictorBlas.Gallo@gmail.com');
INSERT INTO Client(nom, cognom1, cognom2, usuari, password, email)  VALUES ('Angel','Emilio','Gil', 'A.Emilio', '0123456GHI', 'AngelEmilio.Gil@gmail.com');


INSERT INTO Producte(nom, descripcio, preu, altura, ample, fons, pes, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('Avengers 1','Semi nuevo, se vende por desuso', 10.50, 15, 10, 3, 0.300, 'Libros', "20/01/2021", default, 1,1);
INSERT INTO Producte(nom, descripcio, preu, altura, ample, fons, pes, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('Avengers 2','Semi nuevo', 11.50, 15, 10, 3, 0.300, 'Libros', "21/12/2020", default, 1,1);
INSERT INTO Producte(nom, descripcio, preu, altura, ample, fons, pes, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('CyberPunk','Basura de juego', 20.50, 15, 10, 1, 0.300, 'Videojuegos', "23/01/2021", default, 1,1);

INSERT INTO Producte(nom, descripcio, preu, altura, ample, fons, pes, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('Spider-man','Nuevo, collección', 14.50, 15, 10, 5, 0.350, 'Libros', "23/01/2021", default, 2,1);
INSERT INTO Producte(nom, descripcio, preu, altura, ample, fons, pes, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('Minecraft','Para otakus', 5.0, 15, 10, 1, 0.400, 'Videojuegos', "01/02/2021", default, 2,1);
INSERT INTO Producte(nom, descripcio, preu, altura, ample, fons, pes, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('Iphone10','Quiero pasarme a samsung', 699.0, 9, 4, 0.3, 0.400, 'Moviles', "29/01/2021", default, 2,1);


INSERT INTO Producte(nom, descripcio, preu, altura, ample, fons, pes, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('Samsung','Quiero pasarme a Iphone', 499.50, 12, 5, 0.3,, 0.350, 'Moviles', "23/01/2021", default, 3,1);
INSERT INTO Producte(nom, descripcio, preu, altura, ample, fons, pes, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('San andreas','Para gangsters', 20.0, 15, 10, 1, 0.400, 'Videojuegos', "01/07/2020", default, 3,1);
INSERT INTO Producte(nom, descripcio, preu, altura, ample, fons, pes, categoria, data_publicacio, visites, idClient, numFotos) VALUES ('Blacklist','Sinopsis: en mi vida lo he leído julio', 10.0, 10, 10, 2, 0.400, 'Libros', "29/01/2021", default, 3,1);

COMMIT;

