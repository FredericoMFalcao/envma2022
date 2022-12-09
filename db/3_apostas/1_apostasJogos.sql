#
# 1. TABELA : guarda as apostas dos utilizadores
#

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



#
# 2. VIEW : calcula os pontos baseados nas apostas
#

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


DROP VIEW IF EXISTS vApostasJogos;
CREATE VIEW vApostasJogos AS 
SELECT 
	a.Utilizador UtilizadorSigla, 
	b.NomeLongo NomeLongo, 
	a.JogoId, 
	d.NomeLongo EqCasa, 
	e.NomeLongo EqFora, 
	a.Fase, 
	c.GolosEqCasa ResultadoEqCasa, 
	c.GolosEqFora ResultadoEqFora, 
	a.Boost, 
	a.GolosEqCasa ApostaGolosEqCasa, 
	a.GolosEqFora ApostaGolosEqFora, 
	a.DataHoraAposta,
	f.Pontos Pontos 
FROM `ApostasJogos` a 
INNER JOIN Utilizadores b ON b.Utilizador = a.Utilizador
INNER JOIN Jogos c ON c.JogoId = a.JogoId
INNER JOIN Equipas d ON d.NomeCurto = c.EquipaCasa
INNER JOIN Equipas e ON e.NomeCurto = c.EquipaFora
INNER JOIN ApostasJogosComPontosCalculados f ON f.JogoId = a.JogoId
WHERE c.Estado <> "ApostasAbertas"
;



#
# 3. ACÇÕES
#
DROP EVENT IF EXISTS AutoFechoApostasJogosDiaAntes; 
CREATE EVENT AutoFechoApostasJogosDiaAntes 
ON SCHEDULE EVERY 1 MINUTE
STARTS CURRENT_TIMESTAMP
ENDS CURRENT_TIMESTAMP + INTERVAL 1 YEAR
DO 
UPDATE Jogos SET Estado = 'ApostasFechadas' WHERE Estado = 'ApostasAbertas' AND NOW() > (DataHoraUTC - INTERVAL HOUR(DataHoraUTC) HOUR);


CREATE PROCEDURE AutoCriarApostasJogosVaziasParaUtilizador( IN _Utilizador TEXT)
  INSERT INTO ApostasJogos (Utilizador,JogoId,Fase)
  SELECT _Utilizador, JogoId, Fase FROM Jogos;
