#
#  TABELA
#

CREATE TABLE Utilizadores (
    Utilizador         CHAR(3) NOT NULL,
    NomeLongo          VARCHAR(255) NOT NULL,
    FraseEpica         VARCHAR(1024) NULL,
    Token              VARCHAR(32) DEFAULT MD5(RAND()),
    LoginUrl           VARCHAR(255) AS (CONCAT("http://envma2022.duckdns.org/setCookie.php?loginID=",Token)) VIRTUAL,  
	Admin              INT DEFAULT(0),
    PRIMARY KEY (Utilizador)
);

#
#  TRIGGERS 
#

CREATE TRIGGER AutoCriarApostasPodioVazias AFTER INSERT ON Utilizadores FOR EACH ROW CALL AutoCriarApostasPodioVaziasParaUtilizador(NEW.Utilizador);
CREATE TRIGGER AutoCriarApostasJogosVazias AFTER INSERT ON Utilizadores FOR EACH ROW CALL AutoCriarApostasJogosVaziasParaUtilizador(NEW.Utilizador);
