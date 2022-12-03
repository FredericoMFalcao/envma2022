#
#  1. TABELA
#

CREATE TABLE Jogos (
    JogoId        INT PRIMARY KEY AUTO_INCREMENT,
    EquipaCasa    CHAR(3) REFERENCES Equipas (NomeCurto),
    EquipaFora    CHAR(3) REFERENCES Equipas (NomeCurto),
    GolosEqCasa   INT NULL,
    GolosEqFora   INT NULL,
    DataHoraUTC   DATETIME NOT NULL,
    Fase          ENUM ('Grupos','Eliminatoria') DEFAULT('Grupos'), 
    Estado        ENUM('ApostasAbertas','ApostasFechadas','Disputado') DEFAULT ('ApostasAbertas')
);


#
#  1. Automaticamente Criar Apostas Vazias para cada novo jogo criado
#
DROP TRIGGER IF EXISTS AutoCriarApostaJogoVaziaParaCadaNovoJogo;
CREATE TRIGGER AutoCriarApostaJogoVaziaParaCadaNovoJogo AFTER INSERT ON Jogos FOR EACH ROW
INSERT INTO ApostasJogos (Utilizador,JogoId,Fase,Boost) SELECT Utilizador, NEW.JogoId, NEW.Fase, NULL FROM Utilizadores;

#
#  2. Automaticamente Criar resultados submetidos vazios para cada novo jogo criado
#
DROP TRIGGER IF EXISTS AutoCriarResultadosSubmetidosVaziosParaCadaNovoJogo;
CREATE TRIGGER AutoCriarResultadosSubmetidosVaziosParaCadaNovoJogo AFTER INSERT ON Jogos FOR EACH ROW
INSERT INTO `ResultadosSubmetidoPelosUtilizadores` (Utilizador, JogoId) SELECT u.Utilizador, NEW.JogoId FROM Utilizadores u;

CREATE TRIGGER ReCalculaBadges AFTER UPDATE ON Jogos FOR EACH ROW CALL CalcularBadges();
