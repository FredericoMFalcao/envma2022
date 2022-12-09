<table border="1">
	<thead>
		<tr>
			<th>Concorrente</th>
			<th>Pontos</th>
		</tr>
	</thead>
<tbody>
	<?php foreach(select(["Utilizador","Pontos"],"Ranking") as $row) : extract($row); ?>
		<tr>
			<td><?=$Utilizador?></td>
			<td><?=$Pontos?></td>
		</tr>
	<?php endforeach;?>
</tbody>
</table>