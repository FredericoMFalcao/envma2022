<?php foreach(select(["u.NomeLongo NomeLongo","u.FraseEpica FraseEpica"], 
               "Ranking r","INNER JOIN Utilizadores u ON r.UtilizadorNomeCurto = u.Utilizador ORDER BY r.Pontos DESC, u.NomeLongo DESC LIMIT 1 OFFSET 1") as $row): extract($row); ?>
	<h3><?=$FraseEpica?></h3>
	<h5>- <?=$NomeLongo?></h5>
<?php endforeach; ?>
