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
	Admin              INT DEFAULT(0),
    PRIMARY KEY (Utilizador)
);

CREATE TABLE EstatisticasUtilizadores (
    Utilizador                     CHAR(3) REFERENCES Utilizadores (Utilizador),
    MaiorSeqDeCincos               INT DEFAULT(0),
	MaiorSeqDeTendenciaCorreta     INT DEFAULT(0),
	MaiorContribuinteDeResultados  INT DEFAULT(0)
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
  Estado               ENUM('EmPreparacao','Iniciado','Finalizado') DEFAULT ('EmPreparacao'),
    PRIMARY KEY (Nome)
);
INSERT INTO Campeonatos (Nome,Estado) VALUES ("CampeonatoMundo2022","EmPreparacao");

CREATE TABLE Jogos (
    JogoId        INT PRIMARY KEY AUTO_INCREMENT,
    EquipaCasa    CHAR(3) REFERENCES Equipas (NomeCurto),
    EquipaFora    CHAR(3) REFERENCES Equipas (NomeCurto),
    GolosEqCasa   INT NULL,
    GolosEqFora   INT NULL,
    DataHoraUTC   DATETIME NOT NULL,
    Fase          ENUM ('Grupos','Eliminatoria') DEFAULT('Grupos'), 
  Estado        ENUM('ApostasAbertas','ApostasFechadas','Disputado') DEFAULT ('ApostasAbertas')
);

CREATE TRIGGER AutoCriarApostaJogoVaziaParaCadaNovoJogo AFTER INSERT ON Jogos FOR EACH ROW
INSERT INTO ApostasJogos (Utilizador,JogoId,Fase) SELECT Utilizador, NEW.JogoId, NEW.Fase FROM Utilizadores;

CREATE TRIGGER ReCalculaBadges AFTER UPDATE ON Jogos FOR EACH ROW CALL CalcularBadges();


#   1.3. APOSTAS
###################
CREATE TABLE ApostasJogos (
    Utilizador  CHAR(3) REFERENCES Utilizadores (Utilizador),
    JogoId      INT REFERENCES Jogos (JogoId),
    Fase        ENUM('Grupos','Eliminatoria') DEFAULT('Grupos'),
    Boost       INT DEFAULT (0),
    GolosEqCasa INT NULL,
    GolosEqFora INT NULL,
  PRIMARY KEY (Utilizador, JogoId),
  CONSTRAINT UNIQUE (Utilizador, Fase, Boost)
);

CREATE TABLE ApostasPodio (
    Campeonato VARCHAR(255) REFERENCES Campeonatos (Nome),
    Utilizador  CHAR(3) REFERENCES Utilizadores (Utilizador),
    PrimeiroClassificado CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    SegundoClassificado  CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    TerceiroClassificado CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    QuartoClassificado   CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    MelhorMarcador       VARCHAR(255) NULL,
  PRIMARY KEY (Campeonato, Utilizador)
);

 DROP TABLE IF EXISTS ResultadosSubmetidoPelosUtilizadores;
 CREATE TABLE ResultadosSubmetidoPelosUtilizadores (
     Utilizador  CHAR(3) REFERENCES Utilizadores (Utilizador),
    JogoId      INT REFERENCES Jogos (JogoId),
     GolosEqCasa INT NULL,
     GolosEqFora INT NULL,
   DataHoraSubmissao TIMESTAMP
 
 );
 ## INIT TABLE:
# INSERT INTO ResultadosSubmetidoPelosUtilizadores (Utilizador,JogoId,GolosEqCasa,GolosEqFora)
# SELECT b.Utilizador, a.JogoId, a.GolosEqCasa, a.GolosEqFora FROM Jogos a CROSS JOIN Utilizadores b;
 
 DROP TRIGGER IF EXISTS AtualizarResultados;
 CREATE TRIGGER AtualizarResultados AFTER UPDATE ON ResultadosSubmetidoPelosUtilizadores FOR EACH ROW 
 UPDATE Jogos jj
 INNER JOIN ( SELECT j.JogoId, 
               (SELECT a.GolosEqCasa FROM ResultadosSubmetidoPelosUtilizadores a WHERE a.JogoId = j.JogoId AND a.GolosEqCasa IS NOT NULL GROUP BY a.GolosEqCasa ORDER BY COUNT(a.Utilizador) DESC LIMIT 1) GolosEqCasa, 
               (SELECT b.GolosEqFora FROM ResultadosSubmetidoPelosUtilizadores b WHERE b.JogoId = j.JogoId AND b.GolosEqFora IS NOT NULL GROUP BY b.GolosEqFora ORDER BY COUNT(b.Utilizador) DESC LIMIT 1) GolosEqFora
               FROM Jogos j
       ) as b ON b.JogoId = jj.JogoId
SET jj.GolosEqCasa = b.GolosEqCasa, jj.GolosEqFora = b.GolosEqFora, jj.Estado = "Disputado"
WHERE jj.JogoId = NEW.JogoId
 ;
 DROP TRIGGER IF EXISTS AtualizarResultados;
 CREATE TRIGGER AtualizarResultados AFTER UPDATE ON ResultadosSubmetidoPelosUtilizadores FOR EACH ROW 
CALL AtualizaResultadoDeJogo(
    NEW.JogoId, 
    (SELECT a.GolosEqCasa FROM ResultadosSubmetidoPelosUtilizadores a WHERE a.JogoId = NEW.JogoId AND a.GolosEqCasa IS NOT NULL GROUP BY a.GolosEqCasa ORDER BY COUNT(a.Utilizador) DESC LIMIT 1),
  (SELECT a.GolosEqFora FROM ResultadosSubmetidoPelosUtilizadores a WHERE a.JogoId = NEW.JogoId AND a.GolosEqFora IS NOT NULL GROUP BY a.GolosEqFora ORDER BY COUNT(a.Utilizador) DESC LIMIT 1)
);




#################################
#
#   2. VIEWS / FORMULAS / CALCULOS
#
################################
DROP VIEW IF EXISTS ApostasJogosComPontosCalculados;
CREATE VIEW ApostasJogosComPontosCalculados AS
SELECT
    b.Utilizador,
    b.JogoId,
    (CASE WHEN a.GolosEqCasa = b.GolosEqCasa THEN 1 + 1 * (CASE WHEN b.Boost IS NULL THEN 0 ELSE b.Boost END) ELSE 0 END)
    +
    (CASE WHEN a.GolosEqFora = b.GolosEqFora THEN 1 + 1 * (CASE WHEN b.Boost IS NULL THEN 0 ELSE b.Boost END) ELSE 0 END)
    +
    (CASE WHEN 
        a.GolosEqCasa > a.GolosEqFora AND b.GolosEqCasa > b.GolosEqFora
        OR
        a.GolosEqCasa = a.GolosEqFora AND b.GolosEqCasa = b.GolosEqFora
        OR
        a.GolosEqCasa < a.GolosEqFora AND b.GolosEqCasa < b.GolosEqFora
        THEN 3 + 3 * (CASE WHEN b.Boost IS NULL THEN 0 ELSE b.Boost END) ELSE 0 END
    )
    AS Pontos
FROM Jogos AS a
INNER JOIN ApostasJogos AS b ON a.JogoId = b.JogoId
;

# CREATE VIEW ApostasPodioComPontosCalculados AS
# SELECT
#   b.Utilizador
# FROM
# 
# 
DROP VIEW IF EXISTS Ranking;
CREATE VIEW Ranking AS
SELECT 
  a.Utilizador UtilizadorNomeCurto, 
  (CASE 
    WHEN c.Boosts = 1 THEN CONCAT(b.NomeLongo, " (b)") 
    WHEN c.Boosts = 2 THEN CONCAT(b.NomeLongo, " (b) (b)") 
    ELSE b.NomeLongo 
  END) Utilizador, 
  SUM(a.Pontos) as Pontos
FROM ApostasJogosComPontosCalculados a
INNER JOIN Utilizadores b ON b.Utilizador = a.Utilizador
LEFT JOIN (SELECT COUNT(*) Boosts, a.Utilizador FROM ApostasJogos a INNER JOIN Jogos b ON a.JogoId = b.JogoId and b.Estado = "Disputado" WHERE a.Boost = 1 GROUP BY a.Utilizador) c ON c.Utilizador = a.Utilizador
GROUP BY a.Utilizador
ORDER BY SUM(a.Pontos) DESC, b.NomeLongo DESC;

#################################
#
#   3. FUNCOES / PREDICADOS
#
################################

CREATE PROCEDURE AutoCriarApostasPodioVaziasParaUtilizador( IN _Utilizador TEXT)
 INSERT INTO ApostasPodio (Campeonato, Utilizador,PrimeiroClassificado,SegundoClassificado ,TerceiroClassificado,QuartoClassificado,MelhorMarcador)
 VALUES("CampeonatoMundo2022", _Utilizador, NULL, NULL, NULL, NULL, NULL);

CREATE PROCEDURE AutoCriarApostasJogosVaziasParaUtilizador( IN _Utilizador TEXT)
  INSERT INTO ApostasJogos (Utilizador,JogoId,Fase)
  SELECT _Utilizador, JogoId, Fase FROM Jogos;

CREATE TRIGGER AutoCriarApostasPodioVazias AFTER INSERT ON Utilizadores FOR EACH ROW CALL AutoCriarApostasPodioVaziasParaUtilizador(NEW.Utilizador);
CREATE TRIGGER AutoCriarApostasJogosVazias AFTER INSERT ON Utilizadores FOR EACH ROW CALL AutoCriarApostasJogosVaziasParaUtilizador(NEW.Utilizador);

DROP EVENT IF EXISTS AutoFechoApostasJogosDiaAntes; 
CREATE EVENT AutoFechoApostasJogosDiaAntes 
ON SCHEDULE EVERY 1 MINUTE
STARTS CURRENT_TIMESTAMP
ENDS CURRENT_TIMESTAMP + INTERVAL 1 YEAR
DO 
UPDATE Jogos SET Estado = 'ApostasFechadas' WHERE Estado = 'ApostasAbertas' AND NOW() > (DataHoraUTC - INTERVAL HOUR(DataHoraUTC) HOUR);


DROP PROCEDURE IF EXISTS AtualizaResultadoDeJogo;
CREATE PROCEDURE AtualizaResultadoDeJogo (IN _JogoId INT, IN _GolosEqCasa INT, IN _GolosEqFora INT)
UPDATE Jogos SET GolosEqCasa = _GolosEqCasa, GolosEqFora = _GolosEqFora, Estado = "Disputado" WHERE JogoID = _JogoId;


