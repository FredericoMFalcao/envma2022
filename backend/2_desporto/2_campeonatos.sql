CREATE TABLE Campeonatos (
    Nome                 VARCHAR(255),
    PrimeiroClassificado CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    SegundoClassificado  CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    TerceiroClassificado CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    QuartoClassificado   CHAR(3) NULL REFERENCES Equipas (NomeCurto),
    MelhorMarcador       VARCHAR(255) NULL,
    Estado               ENUM('EmPreparacao','Iniciado','EntreFases','Finalizado') DEFAULT ('EmPreparacao'),
    PRIMARY KEY (Nome)
);
INSERT INTO Campeonatos (Nome,Estado) VALUES ("CampeonatoMundo2022","EmPreparacao");
