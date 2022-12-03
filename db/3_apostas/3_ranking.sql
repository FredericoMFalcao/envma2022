DROP VIEW IF EXISTS Ranking;
CREATE VIEW Ranking AS
SELECT 
  a.Utilizador UtilizadorNomeCurto, 
  (CASE 
    WHEN c.Boosts = 1 THEN CONCAT(b.NomeLongo, " (b)") 
    WHEN c.Boosts = 2 THEN CONCAT(b.NomeLongo, " (b) (b)") 
    ELSE b.NomeLongo 
  END) Utilizador, 
  SUM(a.Pontos) + CAST(d.Pontos AS INT) as Pontos
FROM ApostasJogosComPontosCalculados a
INNER JOIN Utilizadores b ON b.Utilizador = a.Utilizador
LEFT JOIN (SELECT COUNT(*) Boosts, a.Utilizador FROM ApostasJogos a INNER JOIN Jogos b ON a.JogoId = b.JogoId and b.Estado = "Disputado" WHERE a.Boost = 1 GROUP BY a.Utilizador) c ON c.Utilizador = a.Utilizador
GROUP BY a.Utilizador
ORDER BY SUM(a.Pontos) DESC, b.NomeLongo DESC;