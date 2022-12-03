#
#  1. TABELA
#
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


#
#  2. ACÇÕES
#
  
 DROP TRIGGER IF EXISTS AtualizarConsensoDeResultadoEmJogo;
 CREATE TRIGGER AtualizarConsensoDeResultadoEmJogo AFTER UPDATE ON ResultadosSubmetidoPelosUtilizadores FOR EACH ROW 
CALL AtualizaResultadoDeJogo(
    NEW.JogoId, 
    (SELECT a.GolosEqCasa FROM ResultadosSubmetidoPelosUtilizadores a WHERE a.JogoId = NEW.JogoId AND a.GolosEqCasa IS NOT NULL GROUP BY a.GolosEqCasa ORDER BY COUNT(a.Utilizador) DESC LIMIT 1),
    (SELECT a.GolosEqFora FROM ResultadosSubmetidoPelosUtilizadores a WHERE a.JogoId = NEW.JogoId AND a.GolosEqFora IS NOT NULL GROUP BY a.GolosEqFora ORDER BY COUNT(a.Utilizador) DESC LIMIT 1)
);




DROP PROCEDURE IF EXISTS AtualizaResultadoDeJogo;
CREATE PROCEDURE AtualizaResultadoDeJogo (IN _JogoId INT, IN _GolosEqCasa INT, IN _GolosEqFora INT)
UPDATE Jogos SET GolosEqCasa = _GolosEqCasa, GolosEqFora = _GolosEqFora, Estado = "Disputado" WHERE JogoID = _JogoId;


