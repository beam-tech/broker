<h1>/<?=$this->name?>/</h1>
<p><?=$this->name?></p>
<a href="/admin/">На главную страницу<a><br>
<a href="/admin/messages">Сообщения<a><br>
<a href="/admin/addEvent">Добавить события<a><br>
<a href="/admin/deleteEvent">Удалить события<a><br>
<a href="/admin/exit">Выйти<a><br>
	<?
	foreach ($this->errors as $key => $value) {
			echo $value."<br>";
		}
	?>
	<form action="" method="post">
	<table border="1" width="100%">
	<tr>
		<th>Название</th>
		<th>Вид</th>
		<th>Эффект</th>
		<th>Деньги</th>
		<th>Жизни</th>
		<th>Акции</th>
		<th>Содержание</th>
		<th>Выделить</th>
	</tr>
<?
	if(empty($this->errors)){
		foreach($this->data as $item){
			$id = $item['id'];
			$name = $item['name'];
			$kind = $item['kind'];
			$effect = $item['effect'];
			$cash = $item['cash'];
			$health = $item['health'];
			$action = $item['action'];
			$msg = $item['msg'];
			echo <<<LABEL
			<tr>
				<td>$name</td>
				<td>$kind</td>
				<td>$effect</td>
				<td>$cash</td>
				<td>$health</td>
				<td>$action</td>
				<td>$msg</td>
				<td><input type="checkbox" name="event_id[]" value="$id"></td>
			</tr>
LABEL;
		}
	}
	?>
	<tr align="center"><td colspan="8"><input type="submit" value="Удалить"></td></tr>
	</table>
	</form>
	<?
		foreach ($this->done as $key => $value) {
			echo $value."<br>";
		}
	?>