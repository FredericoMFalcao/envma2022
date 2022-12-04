<table border="1">
	<thead>
		<tr>
			<th>Badge</th>
			<th>Concorrente</th>
		</tr>
	</thead>
<tbody>
	<?php foreach(select(["b.NomeLongo Utilizador","MaiorSeqDeCincos"],"EstatisticasUtilizadores a", "INNER JOIN Utilizadores b ON a.Utilizador = b.Utilizador ORDER BY MaiorSeqDeCincos DESC LIMIT 1") as $row) : extract($row); ?>
		<tr>
			<td>Bullseye (maior Sequência de 5's)</td>
			<td><?=$Utilizador?></td>
		</tr>
	<?php endforeach;?>
	<?php foreach(select(["b.NomeLongo Utilizador","MaiorSeqDeTendenciaCorreta"],"EstatisticasUtilizadores a", "INNER JOIN Utilizadores b ON a.Utilizador = b.Utilizador ORDER BY MaiorSeqDeTendenciaCorreta DESC LIMIT 1") as $row) : extract($row); ?>
		<tr>
			<td>Oracle (maior sequência de tendência correta)</td>
			<td><?=$Utilizador?></td>
		</tr>
	<?php endforeach;?>
	<?php foreach(select(["b.NomeLongo Utilizador","a.MaiorContribuinteDeResultados"],"EstatisticasUtilizadores a", "INNER JOIN Utilizadores b ON a.Utilizador = b.Utilizador ORDER BY a.MaiorContribuinteDeResultados DESC LIMIT 1") as $row) : extract($row); ?>
		<tr>
			<td>Contributor (maior contribuinte de resultados)</td>
			<td><?=$Utilizador?></td>
		</tr>
	<?php endforeach;?>
	<?php foreach(select(["b.NomeLongo Utilizador","a.IndiceApostaIsolada"],"BadgesIndiceApostaIsolada a", "INNER JOIN Utilizadores b ON a.Utilizador = b.Utilizador ORDER BY a.IndiceApostaIsolada DESC LIMIT 1") as $row) : extract($row); ?>
		<tr>
			<td>Lone Wolf (maior indice de apostas isoladas)</td>
			<td><?=$Utilizador?></td>
		</tr>
	<?php endforeach;?>
	<?php foreach(select(["b.NomeLongo Utilizador","a.IndiceApostaIsolada"],"BadgesIndiceApostaIsolada a", "INNER JOIN Utilizadores b ON a.Utilizador = b.Utilizador ORDER BY a.IndiceApostaIsolada ASC LIMIT 1") as $row) : extract($row); ?>
		<tr>
			<td>Average Joe (menor indice de apostas isoladas)</td>
			<td><?=$Utilizador?></td>
		</tr>
	<?php endforeach;?>

</tbody>
</table>
