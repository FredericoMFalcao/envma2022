#
# 1. TABELA: guarda apostas submetidas no pódio por utilizador
#
CREATE TABLE ApostasPodio (
    Campeonato VARCHAR(255) REFERENCES Campeonatos (Nome),
    Utilizador  CHAR(3) REFERENCES Utilizadores (Utilizador),
    PrimeiroClassificado CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    SegundoClassificado  CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    TerceiroClassificado CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    QuartoClassificado   CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    MelhorMarcador       VARCHAR(255) NULL,
    DataHoraAposta       TIMESTAMP,
    AlteradoEntreFases   INT DEFAULT (0)
  PRIMARY KEY (Campeonato, Utilizador)
);


#
# 2. ACÇÕES
#

CREATE TRIGGER ApostasPodioMarcarAlteradoEntreFases BEFORE UPDATE ON ApostasPodio FOR EACH ROW 
SET NEW.AlteradoEntreFases = (CASE WHEN (SELECT Estado FROM Campeonatos LIMIT 1) = "EntreFases" THEN 1 ELSE 0 END);



DROP VIEW IF EXISTS ApostasPodioComPontosCalculados;
CREATE VIEW ApostasPodioComPontosCalculados AS
SELECT
   a.Utilizador,
(
	( CASE WHEN a.PrimeiroClassificado = b.PrimeiroClassificado THEN 12 WHEN a.PrimeiroClassificado IN (b.SegundoClassificado,b.TerceiroClassificado,b.QuartoClassificado) THEN 6 ELSE 0 END)
	+
	( CASE WHEN a.SegundoClassificado  = b.SegundoClassificado  THEN 12 WHEN a.SegundoClassificado IN (b.PrimeiroClassificado,b.TerceiroClassificado,b.QuartoClassificado) THEN 6 ELSE 0 END)
	+
	( CASE WHEN a.TerceiroClassificado = b.TerceiroClassificado THEN 12 WHEN a.TerceiroClassificado IN (b.PrimeiroClassificado,b.SegundoClassificado,b.QuartoClassificado) THEN 6 ELSE 0 END)
	+
	( CASE WHEN a.QuartoClassificado   = b.QuartoClassificado   THEN 12 WHEN a.QuartoClassificado IN (b.PrimeiroClassificado,b.SegundoClassificado,b.TerceiroClassificado) THEN 6 ELSE 0 END)
	+
	( CASE WHEN a.MelhorMarcador       = b.MelhorMarcador       THEN 12 ELSE 0 END)
  ) * ( 1 - 0.5 * a.AlteradoEntreFases
) Pontos
FROM ApostasPodio a
CROSS JOIN Campeonatos b
;

CREATE PROCEDURE AutoCriarApostasPodioVaziasParaUtilizador( IN _Utilizador TEXT)
 INSERT INTO ApostasPodio (Campeonato, Utilizador,PrimeiroClassificado,SegundoClassificado ,TerceiroClassificado,QuartoClassificado,MelhorMarcador)
 VALUES("CampeonatoMundo2022", _Utilizador, NULL, NULL, NULL, NULL, NULL);
