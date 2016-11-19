-- PROJEKT DO PREDMETU IDS ---

-- Autori: Karel Jiranek, Frantisek Kropac
-- Loginy: xjiran00, xkropa06
-- Datum: 12. 3. 2015
-- Zadani: zoologicka zahrada


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
  jmeno VARCHAR(20),
  primeni VARCHAR(20),
  datum_narozeni DATE,
  mesto VARCHAR(30),
  ulice VARCHAR(20),
  nej_dosazene_vzdelani VARCHAR(20),


  CONSTRAINT PK_os_cislo PRIMARY KEY (os_cislo)
);

INSERT INTO Osetrovatel VALUES (NULL, 'Antonín', 'Novotný', '1965-02-15', 'Praha', 'Nová 957', 'Vysokoškolské' );
INSERT INTO Osetrovatel VALUES (NULL, 'Josef', 'Vomáčka', '1980-12-30', 'Brno', 'Cejl 8', 'Vysokoškolské' );
INSERT INTO Osetrovatel VALUES (NULL, 'Bedřich', 'Nebojácný', '1950-06-04', 'Vyškov', 'Za lesem 5', 'Středoškolské' );
INSERT INTO Osetrovatel VALUES (NULL, 'Jaromír', 'Kolář','1976-11-25','Praha','Hlavní 98/10','Vysokoškolské');
INSERT INTO Osetrovatel VALUES (NULL, 'Gabriela', 'Soukalová', '1989-11-01' , 'Jablonec nad Nisou', 'Biatlonská 26', 'Vysokoškolské');
INSERT INTO Osetrovatel VALUES (NULL, 'Martina', 'Záblová', '1988-07-31' , 'Louny', 'Nová 199', 'Vysokoškolské');
INSERT INTO Osetrovatel VALUES (NULL, 'Martin', 'Jásal', '1990-10-31' , 'Brno', 'Vánoční 199', 'Vysokoškolské');

CREATE TABLE Uzivatel (
  pk SMALLINT NOT NULL AUTO_INCREMENT,
  username VARCHAR(40) UNIQUE NOT NULL,
  password VARCHAR(40) NOT NULL,
  privileges SMALLINT NOT NULL,
  pk_osetrovatel SMALLINT,

  CONSTRAINT PK_pk PRIMARY KEY (pk),

  CONSTRAINT FK_uzivatel FOREIGN KEY (pk_osetrovatel)
  REFERENCES Osetrovatel(os_cislo)
);

INSERT INTO Uzivatel VALUES (NULL, 'ant', '1', '1', (SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 1));
INSERT INTO Uzivatel VALUES (NULL, 'jos', '1', '2', (SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 2));
INSERT INTO Uzivatel VALUES (NULL, 'admin', 'admin', '3', null);




-- HLavni osetrovatel
CREATE TABLE Hlavni_Osetrovatel (
  os_cislo SMALLINT,


  CONSTRAINT FK_Hlavni_O_nadrizeny
      FOREIGN KEY (os_cislo)
      REFERENCES Osetrovatel (os_cislo)
);

INSERT INTO Hlavni_Osetrovatel VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 2));


-- Skoleni
CREATE TABLE Skoleni (
  os_cislo SMALLINT,
  jmeno_skoleni VARCHAR(60),

  CONSTRAINT PK_os_cislo_jmeno_skoleni PRIMARY KEY(os_cislo, jmeno_skoleni),

  CONSTRAINT FK_os_cislo_osetrovatel
      FOREIGN KEY (os_cislo)
      REFERENCES Osetrovatel (os_cislo)

);

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
CREATE TABLE Vybeh (
  cislo_vybehu SMALLINT NOT NULL AUTO_INCREMENT,
  typ VARCHAR(50) NOT NULL,
  max_zvirat SMALLINT,
  cas_na_cisteni INT, -- minut
  otevren DATE,

  CONSTRAINT PK_cislo_vybehu PRIMARY KEY (cislo_vybehu)
);

INSERT INTO Vybeh VALUES (1, 'Aqarium', 10, 30, '2020-10-15');
INSERT INTO Vybeh VALUES (2, 'Savana',   3, 60, '1999-09-08');
INSERT INTO Vybeh VALUES (3, 'Arktik',  5, 20, '2001-12-17' );
INSERT INTO Vybeh VALUES (5, 'Terarium', NULL , 30, NULL);
INSERT INTO Vybeh VALUES (4, 'Poušť', 10, 45, '2005-01-01');
INSERT INTO Vybeh VALUES (6, 'Prales', 10, 35, '2015-04-12');
INSERT INTO Vybeh VALUES (7, 'Tajga', 3, 20, '2013-06-26');
INSERT INTO Vybeh VALUES (8, 'Vodní nádrž', 3, 20, '2015-08-15');

-- Pomucky
CREATE TABLE Pomucky (
  cislo_vybehu SMALLINT,
  jmeno_pomucky VARCHAR(20),

  CONSTRAINT PK_jmeno_pomucky PRIMARY KEY (cislo_vybehu, jmeno_pomucky),

  CONSTRAINT FK_cislo_vybehu
      FOREIGN KEY (cislo_vybehu)
      REFERENCES Vybeh (cislo_vybehu)

);


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
CREATE TABLE Opravy (
  cislo_vybehu SMALLINT,
  ev_opravy VARCHAR(20), -- evdence opravy
  ucel_opravy VARCHAR(100) NOT NULL,
  datum_opravy DATE NOT NULL,

  CONSTRAINT PK_cislo_opravy PRIMARY KEY (cislo_vybehu, ev_opravy),

  CONSTRAINT FK_opravy_vybeh
      FOREIGN KEY (cislo_vybehu)
      REFERENCES Vybeh (cislo_vybehu)


);

INSERT INTO Opravy VALUES ((SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 1), '1aqa0001', 'Vadné těsnění fitrace', '2000-10-16');
INSERT INTO Opravy VALUES ((SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 2), '2sava0001', 'Vyměna porušeného plotu v sekci 20', '2010-05-20');



/**********************  Zvire ****************************/
-- Zvire
CREATE TABLE Zvire (
  kod_zvirete INTEGER,
  jmeno VARCHAR(20),
  pohlavi VARCHAR(10) CHECK (pohlavi = 'female' OR pohlavi = 'male' OR pohlavi = 'N/A' or pohlavi = 'hermafrodit'),
  zarazeni VARCHAR(50) NOT NULL,
  hmotnost DECIMAL(8,3) CHECK (hmotnost > 0), -- kilo
  datum_narozeni DATE,
  datum_umrti DATE,
  matka VARCHAR(20),
  otec VARCHAR (20),
  zdarvotni_stav VARCHAR(20) NOT NULL CHECK(zdarvotni_stav = 'OK' OR zdarvotni_stav = 'Nemocný' OR zdarvotni_stav = 'N/A'),
  pos_zdrav_prohlidka DATE,
  cislo_vybehu SMALLINT,

  CONSTRAINT PK_kod_zvirete PRIMARY KEY (kod_zvirete),

  CONSTRAINT FK_Vybeh
      FOREIGN KEY (cislo_vybehu)
      REFERENCES Vybeh(cislo_vybehu)

);

INSERT INTO Zvire VALUES (1, 'Alex', 'male', 'Kočkovité šelmy - Lvi', 150, '2000-01-20', NULL, 'Ala', 'Alan', 'OK', '2010-01-19',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 2));
INSERT INTO Zvire VALUES (2, 'Lila', 'female', 'Kočkovité šelmy - Lvi', 120, '2002-01-15', NULL, 'Ela', 'Elan', 'OK', '2012-06-22',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 2));
INSERT INTO Zvire VALUES (3, 'Kometa', 'female', 'Lední medvědi', 10, '2014-12-11', NULL, 'Mako', 'Bako', 'OK', '2015-11-23',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 3));
INSERT INTO Zvire VALUES (4, 'Ondra', 'male', 'Velbloudi', 450, '2012-11-13', NULL, 'Max', 'Kyle', 'OK', '2015-12-19',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 4));
INSERT INTO Zvire VALUES (5, 'Otto', 'male', 'Pavouci', 0.010, '2014-10-10', NULL, 'Lenny', 'Tracy', 'OK', '2013-07-20',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 5));
INSERT INTO Zvire VALUES (6, 'Alžběta', 'female', 'Pavouci', 0.020, '2015-06-30', NULL, NULL, NULL, 'OK', '2013-07-20',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 5));
INSERT INTO Zvire VALUES (8, 'Johny', 'male', 'Lachtan hřivnatý', 340, '1998-06-06', NULL, 'Jimmy', NULL, 'Nemocný', '2016-05-20',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 8));
INSERT INTO Zvire VALUES (9, 'Tonny', 'male', 'Lachtan hřivnatý', 320, '1997-10-08', NULL, 'Jimmy', 'Lola', 'OK', '2013-07-20',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 8));
INSERT INTO Zvire VALUES (10, 'Barbara', 'female', 'Lachtan hřivnatý', 250, '1996-10-07', NULL, NULL, 'Satra', 'OK', '2013-07-20',
  (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 8));


-- Uhynulá zvířata
INSERT INTO Zvire VALUES (7, 'Marty', 'male', 'Sloni', 1500, '1910-08-07', '1999-12-31', NULL, NULL, 'N/A', '1999-12-30', NULL);

-- Cizi ZOO
CREATE TABLE Cizi_zoo (
  jmeno_zoo  VARCHAR(50),
  mesto VARCHAR(30) NOT NULL,
  ulice VARCHAR(20) NOT NULL,
  ICO NUMERIC(8,0),
  DIC NUMERIC(15,0),
  poverena_osoba VARCHAR(20) NOT NULL,

  CONSTRAINT PK_jmeno_zoo PRIMARY KEY(jmeno_zoo)
);

INSERT INTO Cizi_zoo VALUES ('ZOO Hradec Králové', 'Hradec Králové', 'Zologická 12', 23465735, 574936255967153, 'Aleš Smutný');
INSERT INTO Cizi_zoo VALUES ('ZOO Praha', 'Praha', 'Trója 132', 85649323, 928374654738291, 'Petr Spálený');
INSERT INTO Cizi_zoo VALUES ('NYC ZOO', 'New York City', 'Manhattan 150', 0, 0, 'Anny Whitestone');

-- Prispivatel

CREATE TABLE Prispivatel (
  cislo_prispivatele SMALLINT,
  typ_prispivani VARCHAR(30) NOT NULL CHECK (typ_prispivani = 'Měsíční' OR typ_prispivani = 'Jednorázový' OR typ_prispivani = 'Roční'),
  mesto VARCHAR(30) NOT NULL,
  ulice VARCHAR(20) NOT NULL,
  castka INTEGER NOT NULL,
  celkova_castka INTEGER NOT NULL,

  CONSTRAINT PK_cislo_prispivatele PRIMARY KEY(cislo_prispivatele)

);

INSERT INTO Prispivatel VALUES (1, 'Měsíční', 'Brno', 'Cejl 12', 10000, 10000);
INSERT INTO Prispivatel VALUES (2, 'Jednorázový', 'Praha', 'Brněnská 13', 20000, 20000);

/*** VZTAHY ***/


-- Stara se (o zvire)
CREATE TABLE Stara_se (
    os_cislo SMALLINT,
    kod_zvirete INTEGER,
    CONSTRAINT PK_os_cislo_kod_zvirete PRIMARY KEY(os_cislo, kod_zvirete),

    CONSTRAINT FK_Osetrovatel_Stara_se
      FOREIGN KEY (os_cislo)
      REFERENCES Osetrovatel (os_cislo),

    CONSTRAINT FK_Osetrovatel_Skoleni
      FOREIGN KEY (kod_zvirete)
      REFERENCES Zvire(kod_zvirete)

);

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
CREATE TABLE Cisti (
    os_cislo SMALLINT,
    cislo_vybehu SMALLINT,
    datum_cisteni date,
    od DATE NOT NULL,
    do DATE NOT NULL,
    stav_po VARCHAR(30),
    CONSTRAINT PK_Cisti_os_cislo_cislo_vybehu PRIMARY KEY(os_cislo, cislo_vybehu),

    CONSTRAINT FK_Stara_os_cislo
      FOREIGN KEY (os_cislo)
      REFERENCES Osetrovatel (os_cislo),

    CONSTRAINT FK_Stara_se_cislo_vybehu
      FOREIGN KEY (cislo_vybehu)
      REFERENCES Vybeh(cislo_vybehu)

);

INSERT INTO Cisti VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 4),
                          (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 1),
                         str_to_date('2015,12,15', '%Y,%m,%d'),
                         str_to_date('06,30', '%H, %i'),
                         str_to_date('07,01', '%H, %i'),
                         'OK');
INSERT INTO Cisti VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 5),
                          (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 2),
                         str_to_date('2015,12,15', '%Y,%m,%d'),
                         str_to_date('06,30', '%H,%i'),
                         str_to_date('07,40', '%H,%i'),
                          'OK');
INSERT INTO Cisti VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 6),
                          (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 3),
                         str_to_date('2015,12,16', '%Y,%m,%d'),
                         str_to_date('06,30', '%H,%i'),
                         str_to_date('07,00', '%H,%i'),
                          'Potřeba dočistit!');
INSERT INTO Cisti VALUES ((SELECT os_cislo FROM Osetrovatel WHERE os_cislo = 6),
                          (SELECT cislo_vybehu FROM Vybeh WHERE cislo_vybehu = 8),
                         str_to_date('2016,5,20', '%Y,%m,%d'),
                         str_to_date('07,30', '%H,%i'),
                         str_to_date('08,00', '%H,%i'),
                          'N/A');


-- Krmi
CREATE TABLE Krmi (
    os_cislo SMALLINT,
    kod_zvirete INT,
    datum_krmeni DATE NOT NULL,
    od TIME NOT NULL,
    do TIME NOT NULL,
    mnozstvi_zradla DECIMAL(8,3) NOT NULL CHECK (mnozstvi_zradla > 0), -- Kg
    CONSTRAINT PK_krmi_os_cislo_kod_zvirete PRIMARY KEY(os_cislo, kod_zvirete, datum_krmeni, od),

    CONSTRAINT FK_Krmi_os_cislo
      FOREIGN KEY (os_cislo)
      REFERENCES Osetrovatel (os_cislo),

    CONSTRAINT FK_Krmni_kod_zvirete
      FOREIGN KEY (kod_zvirete)
      REFERENCES Zvire(kod_zvirete)

);

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
CREATE TABLE Prispiva (
    cislo_prispivatele SMALLINT,
    kod_zvirete INT,

    CONSTRAINT PK_Prispiva_CP_KZ PRIMARY KEY(cislo_prispivatele, kod_zvirete),

    CONSTRAINT FK_Prispiva_cislo_prispivatele
      FOREIGN KEY (cislo_prispivatele)
      REFERENCES Prispivatel(cislo_prispivatele),

    CONSTRAINT FK_Prispiva_kod_zvirete
      FOREIGN KEY (kod_zvirete)
      REFERENCES Zvire(kod_zvirete)

);

INSERT INTO Prispiva VALUES ((SELECT cislo_prispivatele FROM Prispivatel WHERE cislo_prispivatele = 1), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 1));
INSERT INTO Prispiva VALUES ((SELECT cislo_prispivatele FROM Prispivatel WHERE cislo_prispivatele = 1), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 2));
INSERT INTO Prispiva VALUES ((SELECT cislo_prispivatele FROM Prispivatel WHERE cislo_prispivatele = 1), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 3));
INSERT INTO Prispiva VALUES ((SELECT cislo_prispivatele FROM Prispivatel WHERE cislo_prispivatele = 2), (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 4));




-- Zapujcuje
CREATE TABLE Zapujcuje (
    jmeno_zoo  VARCHAR(50),
    kod_zvirete INT,
    od DATE NOT NULL,
    do DATE,
    ucel_zapujceni VARCHAR(80),
    CONSTRAINT PK_Zapujcuje_JZ_KZ PRIMARY KEY(jmeno_zoo, kod_zvirete),

    CONSTRAINT FK_Zapujcuje_jmeno_zoo
      FOREIGN KEY (jmeno_zoo)
      REFERENCES Cizi_zoo (jmeno_zoo),

    CONSTRAINT FK_Zapujcuje_kod_zvirete
      FOREIGN KEY (kod_zvirete)
      REFERENCES Zvire(kod_zvirete)

);

INSERT INTO Zapujcuje VALUES ('ZOO Hradec Králové', (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 1), '2015-09-01', NULL, 'Rozmnožování');
INSERT INTO Zapujcuje VALUES ('ZOO Praha', (SELECT kod_zvirete FROM Zvire WHERE kod_zvirete = 2), '2015-10-01', NULL, 'Rozmnožování');
