<table border="1">
	<thead>
		<tr>
			<th>Concorrente</th>
			<th>Pontos</th>
		</tr>
	</thead>
<tbody>
	<?php foreach(select(["UtilizadorNomeCurto","Utilizador","Pontos"],"Ranking") as $row) : extract($row); ?>
		<tr>
			<td><a href="/porUtilizador.php?UtilizadorSigla=<?=$UtilizadorNomeCurto?>"><?=$Utilizador?></a></td>
			<td><?=$Pontos?></td>
		</tr>
	<?php endforeach;?>
</tbody>
</table>