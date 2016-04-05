<div class='container'>
	<div id='content' class='row-fluid'>
		<div class='span3 sidebar'>
			<ul class="nav  nav-list nav-stacked" >
				<li class="active" ><a href='#'>Профиль</a></li>
				<li><a href='#'>Общение</a></li>
				<li><a href='#'>ТОП 10</a></li>
				<li><a href='#'>Игроки</a></li>
				<li><a href='#'>Обратная связь</a></li>
				<li><a href='#'>Компании</a></li>
				<li><a href='#'>Магазин</a></li>
				<li><a href='#'>Банк</a></li>
				<li><a href='#'>Работа</a></li>
			</ul>
		</div>
		<div class='span8 main'>
			 <div class="row">
            <div class="span2">
              <a href="" class="thumbnail"><img src="/img/no_avatar.png"><br /></a>
            </div>
            <div class="span6">
            <p><strong>Профиль игрока</strong></p>
              <p>
                  <i class="icon-user"></i> Имя: <?=$login?><br>
                  <i class="icon-heart"></i> HP: <?=$health."%"?><br>
                  <i class="icon-leaf"></i> Капитал: <?=$cash?><br>
                  <i class="icon-star"></i> Статус: <?=$status?><br>
                  <i class="icon-time"></i> Дата регистрации: <?=$dt?><br>
                </p>
              <table class="table table-condensed">
                 <!-- <table class="table table-striped table-bordered table-hover"> -->
                  <thead>
                    <tr>
                      <th>Компания</th>
                      <th>Количество акций</th>
                    </tr>
                  </thead>
                    <tbody>
                   
                    </tbody>
                </table>
             </div>
          </div>
		</div>
    </div>
</div>
