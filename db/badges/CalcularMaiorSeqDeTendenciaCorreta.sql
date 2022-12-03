DROP PROCEDURE IF EXISTS CalcularMaiorSeqDeTendenciaCorreta;
DELIMITER $$
CREATE PROCEDURE CalcularMaiorSeqDeTendenciaCorreta()
  BEGIN

  DECLARE currentUtilizador, lastUtilizador CHAR(3);
  DECLARE currentJogoId, currentPontos INT;
  DECLARE _MaiorSeqDeTendenciaCorreta INT;

  DECLARE done INT DEFAULT FALSE;
  DECLARE cur1 CURSOR FOR SELECT Utilizador, JogoId, Pontos FROM ApostasJogosComPontosCalculados ORDER BY Utilizador ASC, JogoId ASC;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

  
  
  SET _MaiorSeqDeTendenciaCorreta = 0;
  SET lastUtilizador    = "";
  
  OPEN cur1;
  
  the_loop: LOOP
    FETCH cur1 INTO currentUtilizador, currentJogoId, currentPontos;
	IF done THEN LEAVE the_loop; END IF;
	
	IF (currentUtilizador <> lastUtilizador AND lastUtilizador <> "") THEN
        UPDATE EstatisticasUtilizadores SET MaiorSeqDeTendenciaCorreta = GREATEST(_MaiorSeqDeTendenciaCorreta,MaiorSeqDeTendenciaCorreta) WHERE Utilizador = lastUtilizador;
		SET _MaiorSeqDeTendenciaCorreta = 0;
	ELSEIF (currentPontos >= 3) THEN
		SET _MaiorSeqDeTendenciaCorreta = _MaiorSeqDeTendenciaCorreta + 1;
	ELSE
        UPDATE EstatisticasUtilizadores SET MaiorSeqDeTendenciaCorreta = GREATEST(_MaiorSeqDeTendenciaCorreta,MaiorSeqDeTendenciaCorreta) WHERE Utilizador = lastUtilizador; 
		SET _MaiorSeqDeTendenciaCorreta = 0;
	END IF;
	

	
	SET lastUtilizador = currentUtilizador;
	
  END LOOP;
  
     UPDATE EstatisticasUtilizadores SET MaiorSeqDeTendenciaCorreta = GREATEST(_MaiorSeqDeTendenciaCorreta,MaiorSeqDeTendenciaCorreta) WHERE Utilizador = lastUtilizador;
	 
  CLOSE cur1;
  
  END; 
$$
DELIMITER ;
