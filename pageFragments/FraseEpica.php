<?php foreach(select(["NomeLongo","FraseEpica"], "Utilizadores","LIMIT 1") as $row): extract($row); ?>
	<h3><?=$FraseEpica?></h3>
	<h5>- <?=$NomeLongo?></h5>
<?php endforeach; ?>
