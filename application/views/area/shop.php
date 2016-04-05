<div class='container'>
	<div id='content' class='row-fluid'>
		<div class='span12 sidebar'>
			<ul class="nav  nav-pills" >
				<li><a href='/user'>Профиль</a></li>
				<li><a href='/user/chat'>Общение</a></li>
				<li><a href='/user/top'>ТОП 10</a></li>
				<li><a href='/user/all'>Игроки</a></li>
				<li><a href='/user/feedback'>Обратная связь</a></li>
				<li><a href='/area/companies'>Компании</a></li>
				<li class="active"><a href='/area/shop'>Магазин</a></li>
				<li><a href='/area/storage'>Банк</a></li>
				<li><a href='/area/work'>Работа</a></li>
			</ul>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="span12">
			<h1>Магазин</h1>
			<p>
				В магазине можно приобрести различные предметы. После покупки предмет появится у Вас в <strong>рюкзаке</strong>.
			</p>
			<p class="text-info">
				Для покупки предмета сначало выбирите его, а затем нажмите на кнопку <strong>Приобрести</strong>
			</p>
	<form action="" method="post">
		<table class="table  table-bordered ">
		<thead>
			<tr>
				<th>#</th>
				<th>Название</th>
				<th>Что делает</th>
				<th>Стоимость</th>
			</tr>
		</thead>
<?
		foreach($this->data['items'] as $item){
			$id = $item['id'];
			$name = $item['name'];
			$effect = $item['effect'];
			$cash = $item['cash'];
			$health = $item['health'];
			$price = $item['price'];
			switch ($effect) {
				case 'positive':
					$info = "Восстанавливает ".$health."% жизней.";
					break;
				case 'negative':
					$info = "Забирает ".$health."% жизней и ".$cash."$.";
					break;
				default:
					$info = "Ничего";
					break;
			}
			echo <<<LABEL
		<tbody>
			<tr>
				<td><input type="checkbox" name="item_id[]" value="$id"></td>
				<td>$name</td>
				<td>$info</td>
				<td>$price$</td>
			</tr>
		</tbody>
LABEL;
		}
	?>

		</table>
		<input class="btn btn-success" type="submit" value="Приобрести">
	</form>
	<?
		echo "<span class='label label-success'>".$this->done['msgs']."</span><br/>";
		echo "<span class='label label-warning'>".$this->errors['msgs']."</span><br/>";
	?>
		</div>
	</div>
</div>