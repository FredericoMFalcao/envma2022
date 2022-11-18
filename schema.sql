###################
#
#   1. TABELAS
#
###################

#   1.1. SOCIAL
###################
CREATE TABLE Utilizadores (
    Utilizador         CHAR(3) NOT NULL,
    NomeLongo          VARCHAR(255) NOT NULL,
    FraseEpica         VARCHAR(1024) NULL,
    Token              VARCHAR(32) DEFAULT MD5(RAND()),
    LoginUrl           VARCHAR(255) AS (CONCAT("http://envma2022.duckdns.org/setCookie.php?loginID=",Token)) VIRTUAL,
    PRIMARY KEY (Utilizador)
);
CREATE TRIGGER AutoCriarApostasPodioVazias AFTER INSERT ON Utilizadores FOR EACH ROW AutoCriarApostasPodioVaziasParaUtilizador(Utilizador);
CREATE TRIGGER AutoCriarApostasJogosVazias AFTER INSERT ON Utilizadores FOR EACH ROW AutoCriarApostasJogosVaziasParaUtilizador(Utilizador);

#   1.2. DESPORTO
###################
CREATE TABLE Equipas (
    NomeCurto    CHAR(3) NOT NULL,
    NomeLongo    VARCHAR(255) NOT NULL,
	PRIMARY KEY (NomeCurto)
);

CREATE TABLE Campeonatos (
    Nome                 VARCHAR(255),
    PrimeiroClassificado CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    SegundoClassificado  CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    TerceiroClassificado CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    QuartoClassificado   CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    MelhorMarcador       VARCHAR(255) NULL,
	Estado               ENUM('EmPreparacao','Iniciado','Finalizado'),
    PRIMARY KEY (Nome)
);

CREATE TABLE Jogos (
    JogoId        INT PRIMARY KEY AUTO_INCREMENT,
    EquipaCasa    CHAR(3) REFERENCES Equipas (NomeCurto),
    EquipaFora    CHAR(3) REFERENCES Equipas (NomeCurto),
    GolosEqCasa   INT NULL,
    GolosEqFora   INT NULL,
    DataHoraUTC   DATE NOT NULL,
    Fase          ENUM ('Grupos','Eliminatoria')
);

#   1.3. APOSTAS
###################
CREATE TABLE ApostasJogos (
    Utilizador  CHAR(3) REFERENCES Utilizadores (Utilizador),
    JogoId      INT REFERENCES Jogos (JogoId),
	Fase        ENUM('Grupos','Eliminatoria'),
    Boost       INT DEFAULT (0),
    GolosEqCasa INT NULL,
    GolosEqFora INT NULL
);
CREATE TABLE ApostasBoosts (
    Utilizador  CHAR(3) REFERENCES Utilizadores (Utilizador),
	Fase        ENUM('Grupos','Eliminatoria'),
	JogoId      INT REFERENCES Jogos (JogoId),
	-- Apenas UM boost por utilizador / fase
	CONSTRAINT UNIQUE (Utilizador, Fase)
);

CREATE TABLE ApostasPodio (
    Campeonato VARCHAR(255) REFERENCES Campeonatos (Nome),
    Utilizador  CHAR(3) REFERENCES Utilizadores (Utilizador),
    PrimeiroClassificado CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    SegundoClassificado  CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    TerceiroClassificado CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    QuartoClassificado   CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    MelhorMarcador       VARCHAR(255) NULL    
);

#################################
#
#   2. VIEWS / FORMULAS / CALCULOS
#
################################
CREATE VIEW ApostasJogosComPontosCalculados AS
SELECT
    b.Utilizador,
    b.JogoId,
    (CASE WHEN a.GolosEqCasa = b.GolosEqCasa THEN 1 + 1 * b.Boost ELSE 0 END)
    +
    (CASE WHEN a.GolosEqFora = b.GolosEqFora THEN 1 + 1 * b.Boost ELSE 0 END)
    +
    (CASE WHEN 
        a.GolosEqCasa > a.GolosEqFora AND b.GolosEqCasa > b.GolosEqFora
        OR
        a.GolosEqCasa = a.GolosEqFora AND b.GolosEqCasa = b.GolosEqFora
        OR
        a.GolosEqCasa < a.GolosEqFora AND b.GolosEqCasa < b.GolosEqFora
        THEN 3 + 3 * b.Boost ELSE 0 END
    )
    AS Pontos
FROM Jogos AS a
INNER JOIN ApostasJogos AS b ON a.JogoId = b.JogoId
;

# CREATE VIEW ApostasPodioComPontosCalculados AS
# SELECT
# 	b.Utilizador
# FROM
# 
# 
CREATE VIEW Ranking AS
SELECT Utilizador, SUM(Pontos) 
FROM ApostasJogosComPontosCalculados
GROUP BY Utilizador
ORDER BY SUM(Pontos) DESC
;


#################################
#
#   3. FUNCOES / PREDICADOS
#
################################

CREATE PROCEDURE AutoCriarApostasPodioVaziasParaUtilizador( IN _Utilizador TEXT)
 INSERT INTO ApostasPodio (Campeonato, Utilizador,PrimeiroClassificado,SegundoClassificado ,TerceiroClassificado,QuartoClassificado,MelhorMarcador)
 VALUES("Euro2022", _Utilizador, NULL, NULL, NULL, NULL, NULL);

CREATE PROCEDURE AutoCriarApostasJogosVaziasParaUtilizador( IN _Utilizador TEXT)
  INSERT INTO ApostasJogos (Campeonato, Utilizador,PrimeiroClassificado,SegundoClassificado ,TerceiroClassificado,QuartoClassificado,MelhorMarcador)
  SELECT "Euro2022", _Utilizador, NULL, NULL, NULL, NULL, NULL FROM Jogos;

