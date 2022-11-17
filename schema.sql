###################
#
#   1. TABELAS
#
###################

#   1.1. SOCIAL
###################
CREATE TABLE Utilizadores (
    NomeCurto          CHAR(3) NOT NULL,
    NomeLongo          VARCHAR(255) NOT NULL,
    FraseEpica         VARCHAR(1024) NULL,
    Token              VARCHAR(32) DEFAULT MD5(RAND()),
    LoginUrl           VARCHAR(255) AS (CONCAT("http://envma2022.duckdns.org/setCookie.php?loginID=",Token)) VIRTUAL,
    PRIMARY KEY (NomeCurto)
);

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
    Utilizador  CHAR(3) REFERENCES Utilizadores (NomeCurto),
    JogoId      INT REFERENCES Jogos (JogoId),
	Fase        ENUM('Grupos','Eliminatoria'),
    Boost       INT DEFAULT (0),
    GolosEqCasa INT,
    GolosEqFora INT

);
-- ALTER TABLE ApostasJogos ADD CONSTRAINT UmBoostPorFase CHECK ( NOT Boost OR NOT (SELECT COUNT(*) FROM ApostasJogos WHERE Utilizador = _Utilizador AND _Fase = _Fase AND Boost = 1));

CREATE TABLE ApostasPodio (
    Campeonato VARCHAR(255) REFERENCES Campeonatos (Nome),
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

CREATE VIEW ApostasPodioComPontosCalculados AS
SELECT
	b.Utilizador
FROM


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

CREATE FUNCTION BoostJaUsadosParaUtilizadorEFase(_Utilizador CHAR(3), _Fase INT) RETURNS INT DETERMINISTIC
RETURN (SELECT COUNT(*) FROM ApostasJogos WHERE Utilizador = _Utilizador AND _Fase = _Fase AND Boost = 1);


