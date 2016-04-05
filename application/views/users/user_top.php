<div class='container'>
  <div id='content' class='row-fluid'>
    <div class='span12 sidebar'>
      <ul class="nav  nav-pills" >
        <li><a href='/user'>Профиль</a></li>
        <li><a href='/user/chat'>Общение</a></li>
        <li class="active"><a href='/user/top'>ТОП 10</a></li>
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

<!-- основной контент -->
<div class="container" id="content">
	<div class="row">
		<div class="span8 offset2">
				<table class="table" id="top">
				<thead>
					<tr>
						<th>#</th>
						<th>Капитал</th>
						<th>Имя игрока</th>
					</tr>
				</thead>
				<tbody>
					<?
						$pos = 0;
						foreach($this->data['top'] as $item){
							$pos++;
							$cash = $item['cash'];
							$login = $item['login'];
							echo <<<LABEL
							<tr>
								<td>$pos</td>
								<td>$cash</td>
								<td><a href="/user/show/name/$login">$login</a></td>
							</tr>
LABEL;
						}
					?>
				</tbody>
			</table>
				</div>
          </div>
    </div>
<!-- основной контент -->
