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
				<li><a href='/area/storage'>Банк</a></li>
				<li><a href='/area/work'>Работа</a></li>
			</ul>
		</div>
	</div>
</div>
<!-- основной контент-->
<div class='container'>
    <div class="row">
	<div class="span9 offset1">
	<h1>Рюкзак</h1>
	<p>
		В рюкзаке находятся предметы, которые Вы приобрели в ходе игры. В таблице ниже указано имя предмета и его кол-во.
		Использование против других игроков(Красная кнопка); На себя(Зеленая кнопка). 
	</p>
		<div class="row-fluid">

		<form method="post" action="<?= $_SERVER['REQUEST_URI']?>">
			<div class="span3 offset1">
					<table class="table">
						<thead>
							<tr>
								<th>Предмет</th>
							</tr>
						</thead>
						<tbody>
						<?
							foreach($this->data['items'] as $item){
								$id = $item['item_id'];
								$name = $item['name'];
								$Cnt = $item['item_cnt'];
								echo <<<LABEL
							<tr>
								<td>
									<label class="checkbox">
										<input type="checkbox" name="item_id[]" value="$id"> $name <i class="icon-remove"></i> $Cnt
									</label>
								</td>
							</tr>
LABEL;
							}
						?>
						</tbody>
					</table>
			</div>

				<div class="span8">
					<div class="span3">
						<div class="input-append">
							<button class="btn btn-danger" type="submit">Использовать</button>
							<input name="login" type="text" placeholder="имя игрока" class="input-small" />
						</div>
					</div>
				</div>
				<div class="span8">
						<input class="btn btn-success"  name="login" type="submit" value="<?=$this->data['main']['login']?>">
				</div>
				<div class="span2">
					<?
						echo "<span class='label label-warning'>".$this->errors['msgs']."</span><br/>";
						foreach ($this->done['msgs'] as $key => $value) {
							echo "<span class='label label-success'>".$value."</span><br/>";
						}
					?>
				</div>
			
		</form>

		</div>	
	</div>
</div>	

