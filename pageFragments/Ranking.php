<table>
	<thead>
		<tr>
			<th>Concorrente</th>
			<th>Pontos</th>
		</tr>
	</thead>
<tbody>
	<?php foreach(sql(["Utilizador","Pontos"],"ApostasJogosComPontosCalculados") as $row) : extract($row); ?>
		<tr>
			<td><?=$Utilizador?></td>
			<td><?=$Pontos?></td>
		</tr>
	<?php endforeach;?>
</tbody>
</table>