INSERT INTO Client(nom, cognom1, cognom2, usuari, password, email) VALUES ('Onkar','Singh','Kaur', 'Onkar-Singh', '$2y$10$nhL3R6VrAGNsqpcywTWADe/L1JsRH1yurJCVbfFVFGq4a0Yy0b9NK', 'onkarsingh@gmail.com');
INSERT INTO Client(nom, cognom1, cognom2, usuari, password, email) VALUES ('Gabriel','Maria','Pujol', 'Gabriel-Maria', '$2y$10$BxEeBuc7zCV9TwcIhjjcneuWUnxLwvCs6aEiLayW7/LNB/V65xlua', 'gabrielmaria@gmail.com');
INSERT INTO Client(nom, cognom1, cognom2, usuari, password, email)  VALUES ('Jordi','Quesada','Balaguer', 'Jordi-Quesada', '$2y$10$7eYxfnvJJEl5Oh6UY.kSDuZ0ZU3jD1giXYW6/u4ptUhZzmoNuanyC', 'jordiquesada@gmail.com');


INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, foto1, foto2, foto3) VALUES ('La Santa Biblia','Edición Letra Grande. Tapa Dura, Marrón, Con Virgen de Guadalupe En Cubierta', 30, 'Libros', "2021-02-20", default, 1,'1_1.jpg','1_2.jpg','1_3.jpg');
INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, foto1, foto2, foto3) VALUES ('Clean Code','Código limpio / Clean code: Manual de estilo para el desarrollo ágil de software / A Handbook of Agile Software Craftsmanship (Programación) (Spanish Edition)', 80, 'Libros', "2020-12-21", default, 1,'2_1.jpg','2_2.jpg','2_3.jpg');
INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, foto1, foto2, foto3) VALUES ('CyberPunk','La Edición coleccionista premium en tapa dura está impresa en papel satinado de calidad superior y además incluye material adicional', 110, 'Videojuegos', "2021-01-23", default, 1,'3_1.jpg','3_2.jpg','3_3.jpg');

INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, foto1, foto2, foto3) VALUES ('Spiderman: Toda una vida','Tapa dura:200 páginas. 720 g. Editorial : Panini Comics (23 enero 2020) ', 10,'Libros', "2020-11-04", default, 2,'4_1.jpg','4_2.jpg','4_3.jpg');
INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, foto1, foto2, foto3) VALUES ('Genshin Impact',' PS4 ARPG de mundo abierto free-to-play con una mecánica de monetización de Gacha para conseguir elementos adicionales como personajes especiales y armas. Para otakus', 15, 'Videojuegos', "2020-05-03", default, 2,'5_1.jpg','5_2.jpg','5_3.jpg');
INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, foto1, foto2, foto3) VALUES ('Iphone 10','Pantalla Liquid Retina HD de 6,1 pulgadas. Red %G Chip A13 Bionic. Quiero pasarme al Samsung', 1399.99, 'Moviles', "2019-01-29", default, 2,'6_1.jpg','6_2.jpg','6_3.jpg');


INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, foto1, foto2, foto3) VALUES ('Samsung Galaxy A21s','RAM, 128 GB de Memoria Interna, WiFi, Procesador Octa Core, Cámara Principal de 48 MP, Android 10.0. Quiero pasarme a Iphone', 1199.99, 'Moviles', "2020-01-23", default, 3,'7_1.jpg','7_2.jpg','7_3.jpg');
INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, foto1, foto2, foto3) VALUES ('Xiaomi Redemi 9C','NFC-Smartphone con Pantalla HD+ de 6.53" DotDrop (3GB+64GB, Triple cámara trasera de 13MP con IA, MediaTek Helio G35, Batería de 5000 mAh, 10 W de carga rápida), Gris', 300, 'Moviles ', "2020-07-01", default, 3,'8_1.jpg','8_2.jpg','8_3.jpg');
INSERT INTO Producte(nom, descripcio, preu, categoria, data_publicacio, visites, idClient, foto1, foto2, foto3) VALUES ('Assasins Creed Odyssey','Sinopsis: en mi vida lo he leído julio', 25, 'Videojuegos', "2020-03-23", default, 3,'9_1.jpg','9_2.jpg','9_3.jpg');

COMMIT;

