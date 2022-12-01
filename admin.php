<?php require_once __DIR__."/sys/db.php"; ?>
<html>
<head>
	<title>ENVMA 2022 - admin</title>
</head>
<body>
<?php if ($currentUserIsAdmin) : ?>
	<h1>ENVMA 2022 - admin</h1>
	
	<h2>Equipas</h2>
	<table>
		<thead>
			<tr>
				<th>Nome Curto</th>
				<th>Nome Longo</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row) : extract($row); ?>
				<tr>
					<td><?=$NomeCurto?></td>
					<td><?=$NomeLongo?></td>
				</tr>
			<?php endforeach;?>
			<tr>
				<td colspan="2">
					<form action="" method="POST">
						<input type="hidden" name="_table" value="Equipas" />
						<br/>Nome Curto : <input type="text" name="NomeCurto" value="" />
						<br/>Nome Longo : <input type="text" name="NomeLongo" value="" />
						<br/><input type="submit" />
					</form>
				</td>
			</tr>
		</tbody>
	</table>

	<hr/>



	<h2>Jogos</h2>
	<table>
		<thead>
			<tr>
				<th>Nome Curto</th>
				<th>Nome Longo</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach(select(["EquipaCasa","EquipaFora","DataHoraUTC", "Fase"],"Jogos") as $row) : extract($row); ?>
				<tr>
					<td><?=$EquipaCasa?></td>
					<td><?=$EquipaFora?></td>
					<td><?=$DataHoraUTC?></td>
					<td><?=$Fase?></td>
				</tr>
			<?php endforeach;?>
			<tr>
				<td colspan="2">
					<form action="" method="POST">
						<input type="hidden" name="_table" value="Jogos" />
						<br/>Equipa Casa : <select name="EquipaCasa"><?php foreach(select(["NomeCurto", "NomeLongo"],"Equipas") as $row) {extract($row); echo "<option value=\"$NomeCurto\">$NomeLongo</option>";} ?></select>
						<br/>Equipa Fora : <select name="EquipaFora"><?php foreach(select(["NomeCurto", "NomeLongo"],"Equipas") as $row) {extract($row); echo "<option value=\"$NomeCurto\">$NomeLongo</option>";} ?></select>
						<br/>Data Hora UTC : <input type="date" name="DataHoraUTC" value="" />
						<br/>Fase : <select name="Fase"><option>Grupos</option><option>Eliminatória</option></select>
						<br/><input type="submit" />
					</form>
				</td>
			</tr>
		</tbody>
	</table>

	<hr/>
	
<?php endif; ?>
</body>
</html>