DROP PROCEDURE IF EXISTS CalcularBadges;
DELIMITER $$
CREATE PROCEDURE CalcularBadges()
  BEGIN

  CALL CalcularMaiorSeqDeCincos();
  CALL CalcularMaiorSeqDeTendenciaCorreta();
  UPDATE EstatisticasUtilizadores a SET a.MaiorContribuinteDeResultados = (SELECT COUNT(*) FROM ResultadosSubmetidoPelosUtilizadores WHERE GolosEqCasa IS NOT NULL AND Utilizador = a.Utilizador);
	    
  END; 
$$
DELIMITER ;
