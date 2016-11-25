-- PROJEKT DO PREDMETU IDS ---

-- Autori: Karel Jiranek, Frantisek Kropac
-- Loginy: xjiran00, xkropa06
-- Datum: 12. 3. 2015
-- Zadani: zoologicka zahrada

SET NAMES 'utf8';

drop table if exists Osetrovatel CASCADE;
drop table if exists Vybeh CASCADE;
drop table if exists Zvire CASCADE;
drop table if exists Cizi_zoo CASCADE;
drop table if exists Prispivatel CASCADE;
drop table if exists Cisti CASCADE;
drop table if exists Stara_se CASCADE;
drop table if exists Skoleni CASCADE;
drop table if exists Pomucky CASCADE;
drop table if exists Opravy CASCADE;
drop table if exists Krmi CASCADE;
drop table if exists Prispiva CASCADE;
drop table if exists Zapujcuje CASCADE;
drop table if exists Hlavni_Osetrovatel  CASCADE;



/**********************   Osetrovatel **********************/
-- Osetrovatel
CREATE TABLE Osetrovatel (
  os_cislo SMALLINT NOT NULL AUTO_INCREMENT,
  jmeno VARCHAR(20) NOT NULL,
  primeni VARCHAR(20) NOT NULL,
  datum_narozeni DATE DEFAULT NULL,
  mesto VARCHAR(30) DEFAULT NULL,
  ulice VARCHAR(20) DEFAULT  NULL,
  nej_dosazene_vzdelani VARCHAR(20) DEFAULT NULL,
  PRIMARY KEY(os_cislo)
);

CREATE TABLE Uzivatel (
  pk SMALLINT NOT NULL AUTO_INCREMENT,
  username VARCHAR(40) UNIQUE NOT NULL,
  password VARCHAR(40) NOT NULL,
  privileges SMALLINT NOT NULL,
  pk_osetrovatel SMALLINT,
  PRIMARY KEY(pk)
);

CREATE TABLE Hlavni_Osetrovatel (
  os_cislo SMALLINT
);

CREATE TABLE Skoleni (
  os_cislo SMALLINT,
  jmeno_skoleni VARCHAR(60),
  PRIMARY KEY (os_cislo, jmeno_skoleni)
);

CREATE TABLE Vybeh (
  cislo_vybehu SMALLINT NOT NULL AUTO_INCREMENT,
  typ VARCHAR(50) NOT NULL,
  max_zvirat SMALLINT DEFAULT '1',
  cas_na_cisteni INT DEFAULT '10', -- minut
  otevren DATE DEFAULT '2000-10-10',
  PRIMARY KEY (cislo_vybehu)
);

CREATE TABLE Pomucky (
  cislo_vybehu SMALLINT,
  jmeno_pomucky VARCHAR(20),
  PRIMARY KEY (cislo_vybehu, jmeno_pomucky)
);

CREATE TABLE Opravy (
  cislo_vybehu SMALLINT,
  ev_opravy VARCHAR(20) DEFAULT 'oprava1', -- evdence opravy
  ucel_opravy VARCHAR(100) NOT NULL,
  datum_opravy DATE NOT NULL,
  PRIMARY KEY (cislo_vybehu, ev_opravy)
);

CREATE TABLE Zvire (
  kod_zvirete INTEGER NOT NULL AUTO_INCREMENT,
  jmeno VARCHAR(20) NOT NULL,
  pohlavi VARCHAR(10) DEFAULT NULL,
  zarazeni VARCHAR(50) NOT NULL,
  hmotnost DECIMAL(8,3) DEFAULT NULL, -- kilo
  datum_narozeni DATE DEFAULT NULL,
  datum_umrti DATE DEFAULT NULL,
  matka VARCHAR(20) DEFAULT NULL,
  otec VARCHAR (20) DEFAULT NULL,
  zdarvotni_stav VARCHAR(20) DEFAULT NULL,
  pos_zdrav_prohlidka DATE DEFAULT NULL,
  cislo_vybehu SMALLINT DEFAULT NULL,
  PRIMARY KEY (kod_zvirete)
);

CREATE TABLE Cizi_zoo (
  jmeno_zoo  VARCHAR(50) NOT NULL,
  mesto VARCHAR(30) DEFAULT 'Brno',
  ulice VARCHAR(20) DEFAULT 'Božetěchova 2',
  ICO NUMERIC(8,0) DEFAULT NULL,
  DIC NUMERIC(15,0) DEFAULT NULL,
  poverena_osoba VARCHAR(20) DEFAULT 'Petr Petrů',
  PRIMARY KEY(jmeno_zoo)
);

CREATE TABLE Prispivatel (
  cislo_prispivatele SMALLINT NOT NULL AUTO_INCREMENT,
  jmeno VARCHAR(30) DEFAULT NULL,
  typ_prispivani VARCHAR(30) DEFAULT NULL,
  mesto VARCHAR(30) DEFAULT NULL,
  ulice VARCHAR(20) DEFAULT NULL,
  castka INTEGER DEFAULT NULL,
  celkova_castka INTEGER DEFAULT NULL,
  PRIMARY KEY(cislo_prispivatele)
);

CREATE TABLE Stara_se (
    os_cislo SMALLINT,
    kod_zvirete INTEGER,
    PRIMARY KEY(os_cislo, kod_zvirete)
);

CREATE TABLE Cisti (
    os_cislo SMALLINT,
    cislo_vybehu SMALLINT,
    datum_cisteni date,
    od TIME NOT NULL,
    do TIME NOT NULL,
    stav_po VARCHAR(30),
    PRIMARY KEY(os_cislo, cislo_vybehu)
);

CREATE TABLE Krmi (
    os_cislo SMALLINT,
    kod_zvirete INT,
    datum_krmeni DATE NOT NULL,
    od TIME NOT NULL,
    do TIME NOT NULL,
    mnozstvi_zradla DECIMAL(8,3), -- Kg
    PRIMARY KEY(os_cislo, kod_zvirete, datum_krmeni, od)
);

CREATE TABLE Prispiva (
    cislo_prispivatele SMALLINT,
    kod_zvirete INT,
    PRIMARY KEY(cislo_prispivatele, kod_zvirete)
);

CREATE TABLE Zapujcuje (
    jmeno_zoo  VARCHAR(50),
    kod_zvirete INT,
    od DATE NOT NULL,
    do DATE,
    ucel_zapujceni VARCHAR(80),
    PRIMARY KEY(jmeno_zoo, kod_zvirete)
);


ALTER TABLE Uzivatel ADD CONSTRAINT FK_uzivatel FOREIGN KEY (pk_osetrovatel)
REFERENCES Osetrovatel(os_cislo) ON DELETE CASCADE;

ALTER TABLE Hlavni_Osetrovatel ADD CONSTRAINT FK_Hlavni_O_nadrizeny FOREIGN KEY (os_cislo)
REFERENCES Osetrovatel(os_cislo) ON DELETE CASCADE;

ALTER TABLE Skoleni ADD CONSTRAINT FK_os_cislo_osetrovatel FOREIGN KEY (os_cislo)
REFERENCES Osetrovatel(os_cislo) ON DELETE CASCADE;

ALTER TABLE Pomucky ADD CONSTRAINT FK_cislo_vybehu FOREIGN KEY (cislo_vybehu)
REFERENCES Vybeh (cislo_vybehu) ON DELETE CASCADE;

ALTER TABLE Opravy ADD CONSTRAINT FK_opravy_vybeh FOREIGN KEY (cislo_vybehu)
REFERENCES Vybeh (cislo_vybehu) ON DELETE CASCADE;

ALTER TABLE Zvire ADD CONSTRAINT FK_Vybeh FOREIGN KEY (cislo_vybehu)
REFERENCES Vybeh (cislo_vybehu) ON DELETE CASCADE;

ALTER TABLE Stara_se ADD CONSTRAINT FK_Osetrovatel_Stara_se FOREIGN KEY (os_cislo)
REFERENCES Osetrovatel (os_cislo) ON DELETE CASCADE;

ALTER TABLE Stara_se ADD CONSTRAINT FK_Osetrovatel_Skoleni FOREIGN KEY (kod_zvirete)
REFERENCES Zvire (kod_zvirete) ON DELETE CASCADE;

ALTER TABLE Cisti ADD CONSTRAINT FK_Stara_os_cislo FOREIGN KEY (os_cislo)
REFERENCES Osetrovatel (os_cislo) ON DELETE CASCADE;

ALTER TABLE Cisti ADD CONSTRAINT FK_Stara_se_cislo_vybehu FOREIGN KEY (cislo_vybehu)
REFERENCES Vybeh (cislo_vybehu) ON DELETE CASCADE;

ALTER TABLE Krmi ADD CONSTRAINT FK_Krmi_os_cislo FOREIGN KEY (os_cislo)
REFERENCES Osetrovatel (os_cislo) ON DELETE CASCADE;

ALTER TABLE Krmi ADD CONSTRAINT FK_Krmni_kod_zvirete FOREIGN KEY (kod_zvirete)
REFERENCES Zvire (kod_zvirete) ON DELETE CASCADE;

ALTER TABLE Prispiva ADD CONSTRAINT FK_Prispiva_cislo_prispivatele FOREIGN KEY (cislo_prispivatele)
REFERENCES Prispivatel(cislo_prispivatele) ON DELETE CASCADE;

ALTER TABLE Prispiva ADD CONSTRAINT FK_Prispiva_kod_zvirete FOREIGN KEY (kod_zvirete)
REFERENCES Zvire(kod_zvirete) ON DELETE CASCADE;

ALTER TABLE Zapujcuje ADD CONSTRAINT FK_Zapujcuje_jmeno_zoo FOREIGN KEY (jmeno_zoo)
REFERENCES Cizi_zoo (jmeno_zoo) ON DELETE CASCADE;

ALTER TABLE Zapujcuje ADD CONSTRAINT FK_Zapujcuje_kod_zvirete FOREIGN KEY (kod_zvirete)
REFERENCES Zvire(kod_zvirete) ON DELETE CASCADE;

INSERT INTO Osetrovatel VALUES (NULL, 'Antonín', 'Novotný', '1965-02-15', 'Praha', 'Nová 957', 'Vysokoškolské' );
INSERT INTO Osetrovatel VALUES (NULL, 'Josef', 'Vomáčka', '1980-12-30', 'Brno', 'Cejl 8', 'Vysokoškolské' );
INSERT INTO Osetrovatel VALUES (NULL, 'Bedřich', 'Nebojácný', '1950-06-04', 'Vyškov', 'Za lesem 5', 'Středoškolské' );
INSERT INTO Osetrovatel VALUES (NULL, 'Jaromír', 'Kolář','1976-11-25','Praha','Hlavní 98/10','Vysokoškolské');
INSERT INTO Osetrovatel VALUES (NULL, 'Gabriela', 'Soukalová', '1989-11-01' , 'Jablonec nad Nisou', 'Biatlonská 26', 'Vysokoškolské');
INSERT INTO Osetrovatel VALUES (NULL, 'Martina', 'Záblová', '1988-07-31' , 'Louny', 'Nová 199', 'Vysokoškolské');
INSERT INTO Osetrovatel VALUES (NULL, 'Martin', 'Jásal', '1990-10-31' , 'Brno', 'Vánoční 199', 'Vysokoškolské');


INSERT INTO Uzivatel VALUES (NULL, 'ant', '1', '1', (SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 1));
INSERT INTO Uzivatel VALUES (NULL, 'jos', '1', '2', (SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 2));
INSERT INTO Uzivatel VALUES (NULL, 'admin', 'admin', '3', null);


INSERT INTO Hlavni_Osetrovatel VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 2));

-- Skoleni

INSERT INTO Skoleni VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 1), 'Krmení plachých lesních dravců');
INSERT INTO Skoleni VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 3), 'Čištěná těžko dostupných prostorů');
INSERT INTO Skoleni VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 3), 'Bezpečnost práce s agresivnímmi ledními medvědy');
INSERT INTO Skoleni VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 2), 'Plazi a jejich rozmnožování');
INSERT INTO Skoleni VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 4), 'Chov a výcvik divokých šelem');
INSERT INTO Skoleni VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 4), 'Chov exotického ptactva');
INSERT INTO Skoleni VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 5), 'Péče o slony');
INSERT INTO Skoleni VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 6), 'Péče o žirafy');
INSERT INTO Skoleni VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 6), 'Chov stepních lišek');


/**********************   Vybeh   **********************/
-- Vybeh
INSERT INTO Vybeh VALUES (NULL, 'Aqarium', 10, 30, '2010-10-15');
INSERT INTO Vybeh VALUES (NULL, 'Savana',   3, 60, '1999-09-08');
INSERT INTO Vybeh VALUES (NULL, 'Arktik',  5, 20, '2001-12-17' );
INSERT INTO Vybeh VALUES (NULL, 'Terarium', NULL , 30, NULL);
INSERT INTO Vybeh VALUES (NULL, 'Poušť', 10, 45, '2005-01-01');
INSERT INTO Vybeh VALUES (NULL, 'Prales', 10, 35, '2015-04-12');
INSERT INTO Vybeh VALUES (NULL, 'Tajga', 3, 20, '2013-06-26');
INSERT INTO Vybeh VALUES (NULL, 'Vodní nádrž', 3, 20, '2015-08-15');

-- Pomucky
INSERT INTO Pomucky VALUES ((SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 1), 'Kyblik 4,5 L');
INSERT INTO Pomucky VALUES ((SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 1), 'Houba velká') ;
INSERT INTO Pomucky VALUES ((SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 1), 'Saponát');
INSERT INTO Pomucky VALUES ((SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 2), 'Koště velké');
INSERT INTO Pomucky VALUES ((SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 2), 'Houba malá');
INSERT INTO Pomucky VALUES ((SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 2), 'Sláma 10 kg');
INSERT INTO Pomucky VALUES ((SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 3), 'Kyblík 4,5 L');
INSERT INTO Pomucky VALUES ((SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 5), 'Kartáč');
INSERT INTO Pomucky VALUES ((SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 5), 'Houba malá');
INSERT INTO Pomucky VALUES ((SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 4), 'Smeták');
INSERT INTO Pomucky VALUES ((SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 6), 'Lopata');
INSERT INTO Pomucky VALUES ((SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 6), 'Koš na odpadky');

-- Opravy
INSERT INTO Opravy VALUES ((SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 1), '1aqa0001', 'Vadné těsnění fitrace', '2000-10-16');
INSERT INTO Opravy VALUES ((SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 2), '2sava0001', 'Vyměna porušeného plotu v sekci 20', '2010-05-20');


/**********************  Zvire ****************************/
-- Zvire
INSERT INTO Zvire VALUES (NULL, 'Alex', 'male', 'Kočkovité šelmy - Lvi', 150, '2000-01-20', NULL, 'Ala', 'Alan', 'OK', '2010-01-19',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 2));
INSERT INTO Zvire VALUES (NULL, 'Lila', 'female', 'Kočkovité šelmy - Lvi', 120, '2002-01-15', NULL, 'Ela', 'Elan', 'OK', '2012-06-22',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 2));
INSERT INTO Zvire VALUES (NULL, 'Kometa', 'female', 'Lední medvědi', 10, '2014-12-11', NULL, 'Mako', 'Bako', 'OK', '2015-11-23',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 3));
INSERT INTO Zvire VALUES (NULL, 'Ondra', 'male', 'Velbloudi', 450, '2012-11-13', NULL, 'Max', 'Kyle', 'OK', '2015-12-19',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 4));
INSERT INTO Zvire VALUES (NULL, 'Otto', 'male', 'Pavouci', 0.010, '2014-10-10', NULL, 'Lenny', 'Tracy', 'OK', '2013-07-20',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 5));
INSERT INTO Zvire VALUES (NULL, 'Alžběta', 'female', 'Pavouci', 0.020, '2015-06-30', NULL, NULL, NULL, 'OK', '2013-07-20',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 5));
-- uhynule zvire
INSERT INTO Zvire VALUES (NULL, 'Marty', 'male', 'Sloni', 1500, '1910-08-07', '1999-12-31', NULL, NULL, 'N/A', '1999-12-30', NULL);

INSERT INTO Zvire VALUES (NULL, 'Johny', 'male', 'Lachtan hřivnatý', 340, '1998-06-06', NULL, 'Jimmy', NULL, 'Nemocný', '2016-05-20',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 8));
INSERT INTO Zvire VALUES (NULL, 'Tonny', 'male', 'Lachtan hřivnatý', 320, '1997-10-08', NULL, 'Jimmy', 'Lola', 'OK', '2013-07-20',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 8));
INSERT INTO Zvire VALUES (NULL, 'Barbara', 'female', 'Lachtan hřivnatý', 250, '1996-10-07', NULL, NULL, 'Satra', 'OK', '2013-07-20',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 8));


-- Cizi ZOO
INSERT INTO Cizi_zoo VALUES ('ZOO Hradec Králové', 'Hradec Králové', 'Zologická 12', 23465735, 574936255967153, 'Aleš Smutný');
INSERT INTO Cizi_zoo VALUES ('ZOO Praha', 'Praha', 'Trója 132', 85649323, 928374654738291, 'Petr Spálený');
INSERT INTO Cizi_zoo VALUES ('NYC ZOO', 'New York City', 'Manhattan 150', 0, 0, 'Anny Whitestone');

-- Prispivatel

INSERT INTO Prispivatel VALUES (NULL, "Dopravní podnik města Brna", 'Měsíční', 'Brno', 'Cejl 12', 10000, 10000);
INSERT INTO Prispivatel VALUES (NULL, "Dopravní podnik hlavního města Prahy", 'Jednorázový', 'Praha', 'Brněnská 13', 20000, 20000);

/*** VZTAHY ***/


-- Stara se (o zvire)
INSERT INTO Stara_se VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 1), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 1));
INSERT INTO Stara_se VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 2), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 2));
INSERT INTO Stara_se VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 3), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 3));
INSERT INTO Stara_se VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 4), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 4));
INSERT INTO Stara_se VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 5), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 5));
INSERT INTO Stara_se VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 6), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 8));
INSERT INTO Stara_se VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 6), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 9));
INSERT INTO Stara_se VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 6), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 10));
INSERT INTO Stara_se VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 3), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 8));

-- Cisti



INSERT INTO Cisti VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 4),
                          (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 1),
                         str_to_date('2015,12,15', '%Y,%m,%d'),
                         time('06:30'),
                         time('07:01'),
                         'OK');
INSERT INTO Cisti VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 5),
                          (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 2),
                         str_to_date('2015,12,15', '%Y,%m,%d'),
                         time('06:30'),
                         time('07:40'),
                          'OK');
INSERT INTO Cisti VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 6),
                          (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 3),
                         str_to_date('2015,12,16', '%Y,%m,%d'),
                         time('06:30'),
                         time('07:00'),
                          'Potřeba dočistit!');
INSERT INTO Cisti VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 6),
                          (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 8),
                         str_to_date('2016,5,20', '%Y,%m,%d'),
                         time('07:30'),
                         time('08:00'),
                          'N/A');


-- Krmi


INSERT INTO Krmi VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 1),
                         (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 1),
                         str_to_date('2016,12,26', '%Y,%m,%d'),
                         time('12:30'),
                         time('12:40'),
                         10);
INSERT INTO Krmi VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 2),
                         (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 1),
                         str_to_date('2016,12,26', '%Y,%m,%d'),
                         time('19:30'),
                         time('12:40'),
                         5);
INSERT INTO Krmi VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 1),
                         (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 2),
                         str_to_date('2016,12,16', '%Y,%m,%d'),
                         time('11:00'),
                         time('11:31'),
                         12);
INSERT INTO Krmi VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 3),
                         (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 3),
                         str_to_date('2016,06,06', '%Y,%m,%d'),
                         time('11:00'),
                         time('11:21'),
                         3);
INSERT INTO Krmi VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 6),
                         (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 8),
                         str_to_date('2016,05,15', '%Y,%m,%d'),
                         time('11:00'),
                         time('11:21'),
                         2);
INSERT INTO Krmi VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 6),
                         (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 9),
                         str_to_date('2016,2,15', '%Y,%m,%d'),
                         time('11:00'),
                         time('11:21'),
                         2);
INSERT INTO Krmi VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 6),
                         (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 10),
                         str_to_date('2016,2,15', '%Y,%m,%d'),
                         time('11:00'),
                         time('11:21'),
                         2);



-- Prispiva


INSERT INTO Prispiva VALUES ((SELECT cislo_prispivatele FROM Prispivatel WHERE cislo_prispivatele = 1), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 1));
INSERT INTO Prispiva VALUES ((SELECT cislo_prispivatele FROM Prispivatel WHERE cislo_prispivatele = 1), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 2));
INSERT INTO Prispiva VALUES ((SELECT cislo_prispivatele FROM Prispivatel WHERE cislo_prispivatele = 1), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 3));
INSERT INTO Prispiva VALUES ((SELECT cislo_prispivatele FROM Prispivatel WHERE cislo_prispivatele = 2), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 4));




-- Zapujcuje


INSERT INTO Zapujcuje VALUES ('ZOO Hradec Králové', (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 1), '2015-09-01', NULL, 'Rozmnožování');
INSERT INTO Zapujcuje VALUES ('ZOO Praha', (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 2), '2015-10-01', NULL, 'Rozmnožování');


-- delimiter $$
-- CREATE TRIGGER vybeh_delete BEFORE DELETE ON Vybeh
-- FOR EACH ROW
-- BEGIN
-- UPDATE Zvire SET Zvire.cislo_vybehu=NULL;
-- UPDATE Pomucky SET Pomucky.cislo_vybehu=NULL;
-- UPDATE Cisti SET Cisti.cislo_vybehu=NULL;
-- UPDATE Opravy SET Opravy.cislo_vybehu=NULL;
-- END
-- $$
-- delimiter ;
