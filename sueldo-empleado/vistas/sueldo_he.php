<table border="1">
	<tr>
		<td>Horas normales:</td>
		<td><?php echo HORAS_N; ?></td>
	</tr>
	<tr>
		<td>Ingreso por horas normales:</td>
		<td><?php echo $ingreso_hn; ?></td>
	</tr>
	<tr>
		<td>Horas extras:</td>
		<td><?php echo $ht - HORAS_N; ?></td>
	</tr>
	<tr>
		<td>Ingreso por horas extras:</td>
		<td><?php echo $ingreso_he; ?></td>
	</tr>
	<tr>
		<td><strong>TOTAL</strong></td>
		<td><?php echo $total; ?></td>
	</tr>
</table>