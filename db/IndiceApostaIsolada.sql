DROP VIEW IF EXISTS BadgesIndiceApostaIsolada;
CREATE VIEW BadgesIndiceApostaIsolada AS
SELECT 
 d.Utilizador Utilizador,
 SUM(d.IndiceApostaIsolada) IndiceApostaIsolada
 FROM (
	SELECT 
	  a.Utilizador Utilizador, 
	  a.JogoId JogoId,
	  (CASE WHEN a.GolosEqCasa IS NOT NULL AND a.GolosEqFora IS NOT NULL THEN
		  (SELECT 
			  COUNT(*) 
		    FROM ApostasJogos b 
			WHERE b.GolosEqCasa = a.GolosEqCasa AND b.GolosEqFora = a.GolosEqFora AND b.JogoId = a.JogoId And a.Utilizador <> b.Utilizador
		) 
		ELSE (SELECT COUNT(*) / 4 FROM Utilizadores)
		END) * -1  AS IndiceApostaIsolada
	FROM ApostasJogos a 
	INNER JOIN Jogos c ON a.JogoId = c.JogoId 
	 AND c.Estado IN ("ApostasFechadas","Disputado")
) d
GROUP BY d.Utilizador
ORDER BY SUM(d.IndiceApostaIsolada) DESC;
