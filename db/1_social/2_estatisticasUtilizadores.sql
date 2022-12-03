CREATE TABLE EstatisticasUtilizadores (
    Utilizador                     CHAR(3) REFERENCES Utilizadores (Utilizador),
    MaiorSeqDeCincos               INT DEFAULT(0),
	MaiorSeqDeTendenciaCorreta     INT DEFAULT(0),
	MaiorContribuinteDeResultados  INT DEFAULT(0)
);
