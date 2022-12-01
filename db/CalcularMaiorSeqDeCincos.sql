DROP PROCEDURE IF EXISTS CalcularMaiorSeqDeCincos;
DELIMITER $$
CREATE PROCEDURE CalcularMaiorSeqDeCincos()
  BEGIN

  DECLARE currentUtilizador, lastUtilizador CHAR(3);
  DECLARE currentJogoId, currentPontos INT;
  DECLARE _MaiorSeqDeCincos INT;

  DECLARE done INT DEFAULT FALSE;
  DECLARE cur1 CURSOR FOR SELECT Utilizador, JogoId, Pontos FROM ApostasJogosComPontosCalculados ORDER BY Utilizador ASC, JogoId ASC;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

  
  
  SET _MaiorSeqDeCincos = 0;
  SET lastUtilizador    = "";
  
  OPEN cur1;
  
  the_loop: LOOP
    FETCH cur1 INTO currentUtilizador, currentJogoId, currentPontos;
	IF done THEN LEAVE the_loop; END IF;
	
	IF (currentUtilizador <> lastUtilizador AND lastUtilizador <> "") THEN
        UPDATE EstatisticasUtilizadores SET MaiorSeqDeCincos = GREATEST(_MaiorSeqDeCincos,MaiorSeqDeCincos) WHERE Utilizador = lastUtilizador;
		SET _MaiorSeqDeCincos = 0;
	ELSEIF (currentPontos = 5) THEN
		SET _MaiorSeqDeCincos = _MaiorSeqDeCincos + 1;
	ELSE
        UPDATE EstatisticasUtilizadores SET MaiorSeqDeCincos = GREATEST(_MaiorSeqDeCincos,MaiorSeqDeCincos) WHERE Utilizador = lastUtilizador; 
		SET _MaiorSeqDeCincos = 0;
	END IF;
	

	
	SET lastUtilizador = currentUtilizador;
	
  END LOOP;
  
     UPDATE EstatisticasUtilizadores SET MaiorSeqDeCincos = GREATEST(_MaiorSeqDeCincos,MaiorSeqDeCincos) WHERE Utilizador = lastUtilizador;
	 
  CLOSE cur1;
  
  END; 
$$
DELIMITER ;
