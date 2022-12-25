<?php require_once __DIR__."/sys/db.php"; ?>
<html>
<head>
	<title>ENVMA 2022 - admin</title>
	
	<link  href="css/codemirror.css" rel="stylesheet">
	<script src="js/codemirror.js"></script>
	<script src="js/sql.js"></script>
	
</head>
<body>
<?php if ($currentUserIsAdmin) : ?>
	<h1>ENVMA 2022 - admin</h1>
	

	<h2>Utiliazadores</h2>
	<table border="1">
		<thead>
			<tr>
				<th>Utilizador</th>
				<th>Nome Longo</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach(select(["Utilizador","NomeLongo"],"Utilizadores") as $row) : extract($row); ?>
				<tr>
					<td><?=$Utilizador?></td>
					<td><?=$NomeLongo?></td>
					<td><form action="" method="POST"><input type="hidden" name="_table" value="Utilizadores"><input type="hidden" name="_pk_Utilizador" value="<?=$Utilizador?>"><input type="submit" name="_operation" value="delete"></form></td>
				</tr>
			<?php endforeach;?>
			<tr>
				<td colspan="3">
					<?php /* in the future : printNewEntryFormForSqlTable("Utilizador"); */ ?>
					<form action="" method="POST">
						<input type="hidden" name="_table" value="Utilizador" />
						<input type="hidden" name="_operation" value="insert" />
						<br/>Utilizador : <input type="text" name="Utilizador" value="" />
						<br/>Nome Longo : <input type="text" name="NomeLongo" value="" />
						<br/><input type="submit" />
					</form>
				</td>
			</tr>
		</tbody>
	</table>

	<hr/>

	<h2>Equipas</h2>
	<table border="1">
		<thead>
			<tr>
				<th>Nome Curto</th>
				<th>Nome Longo</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row) : extract($row); ?>
				<tr>
					<td><?=$NomeCurto?></td>
					<td><?=$NomeLongo?></td>
					<td><form action="" method="POST"><input type="hidden" name="_table" value="Equipas"><input type="hidden" name="_pk_NomeCurto" value="<?=$NomeCurto?>"><input type="submit" name="_operation" value="delete"></form></td>
				</tr>
			<?php endforeach;?>
			<tr>
				<td colspan="5">
					<form action="" method="POST">
						<input type="hidden" name="_table" value="Equipas" />
						<input type="hidden" name="_operation" value="insert" />
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
	<table border="1">
		<thead>
			<tr>
				<th>Nome Curto</th>
				<th>Nome Longo</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach(select(["JogoId","EquipaCasa","EquipaFora","DataHoraUTC", "Fase"],"Jogos") as $row) : extract($row); ?>
				<tr>
					<td><?=$EquipaCasa?></td>
					<td><?=$EquipaFora?></td>
					<td><?=$DataHoraUTC?></td>
					<td><?=$Fase?></td>
					<td><form action="" method="POST"><input type="hidden" name="_table" value="Jogos"><input type="hidden" name="_pk_JogoId" value="<?=$JogoId?>"><input type="submit" name="_operation" value="delete"></form></td>
				</tr>
			<?php endforeach;?>
			<tr>
				<td colspan="5">
					<form action="" method="POST">
						<input type="hidden" name="_table" value="Jogos" />
						<input type="hidden" name="_operation" value="insert" />
						<br/>Equipa Casa : <select name="EquipaCasa"><?php foreach(select(["NomeCurto", "NomeLongo"],"Equipas") as $row) {extract($row); echo "<option value=\"$NomeCurto\">$NomeLongo</option>";} ?></select>
						<br/>Equipa Fora : <select name="EquipaFora"><?php foreach(select(["NomeCurto", "NomeLongo"],"Equipas") as $row) {extract($row); echo "<option value=\"$NomeCurto\">$NomeLongo</option>";} ?></select>
						<br/>Data Hora UTC : <input type="datetime-local" name="DataHoraUTC" value="" />
						<br/>Fase : <select name="Fase"><option>Grupos</option><option>Eliminatória</option></select>
						<br/><input type="submit" />
					</form>
				</td>
			</tr>
		</tbody>
	</table>

	<hr/>
	
	<h2>Apostas Jogos (algo)</h2>
	<form action="" method="POST">
		<input type="hidden" name="_table" value="APP_DEV_Views" />
		<input type="hidden" name="_pk_Name" value="ApostasJogosComPontosCalculados">
		
		<textarea id="ApostasJogosComPontosCalculados_SqlCode" name="Code"><?=select(["Code"],"APP_DEV_Views","WHERE Name = 'ApostasJogosComPontosCalculados'")[0]["Code"]?></textarea>
		<input type="submit" value="Submeter">
	</form>
	<hr/>

	<h2>Apostas Pódio (algo)</h2>
	<hr/>

	 <script>var ApostasJogosComPontosCalculados_textArea = CodeMirror.fromTextArea("ApostasJogosComPontosCalculados_SqlCode",{lineNumbers:true,mode:"sql"});</script>
<?php endif; ?>
</body>
</html>
