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
				<li><a href='/area/shop'>Магазин</a></li>
				<li class="active"><a href='/area/storage'>Банк</a></li>
				<li><a href='/area/work'>Работа</a></li>
			</ul>
		</div>
	</div>
</div>
<!-- основной контент-->
<div class="container">
	<div class="row">
		<div class="span12">
		<div class="row-fluid">
			<div class="span3 offset1">
				<h1>Хранилище</h1><p>Здесь можно хранить деньги.</p>	
					<b>Выбирите действие:</b>
					<form action="" method="POST">
					    <label><input type="radio" name="mov" value="put" checked> Вложить</label>
					    <label><input type="radio" name="mov" value="pop"> Забрать</label>
						<div class="input-append">
							<input type="text" class="span6" value = "0" name="money">
							<button class="btn btn-primary" type="submit">Отправить</button>
						</div>
					</form>
					<?
						echo "<span class='label label-success'>".$this->done['msgs']."</span><br/>";
						echo "<span class='label label-warning'>".$this->errors['msgs']."</span><br/>";
					?>
			</div>
			<div class="span2 ">
					<table class="table">
						<thead>
							<tr>
								<th>Денег вложено</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?=$this->data['money']?></td>
							</tr>
						</tbody>

					</table>
			</div>
		</div>
	</div>
</div>
</div>
