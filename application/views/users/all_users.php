<?
	$users = $this->data['users'];
?>
<!-- основной контент -->
<div class='container'>
	<div id='content' class='row-fluid'>
		<div class='span12 sidebar'>
			<ul class="nav  nav-pills" >
				<li><a href='/user'>Профиль</a></li>
				<li><a href='/user/chat'>Общение</a></li>
				<li><a href='/user/top'>ТОП 10</a></li>
				<li class="active"><a href='/user/all'>Игроки</a></li>
				<li><a href='/user/feedback'>Обратная связь</a></li>
				<li><a href='/area/companies'>Компании</a></li>
				<li><a href='/area/shop'>Магазин</a></li>
				<li><a href='/area/storage'>Банк</a></li>
				<li><a href='/area/work'>Работа</a></li>
			</ul>
		</div>
	</div>
</div>

<div class='container'>
    <div class="row">
        <div class="span12">
    		<ul class="thumbnails">
			<?
				foreach ($users as $user) {
					$login = $user['login'];
					$cash = $user['cash'];
					echo <<<HTML
				<li class="span4 clearfix">
					<div class="thumbnail clearfix">
						<a href="/user/show/name/$login"><img src="/img/no_avatar.png" id ="avatar" class="pull-left span2 clearfix"  style='margin-right:7px' ></a>
						<div class="caption" class="pull-left">
							<h4>      
								<b>$login</b>
							</h4>
							<small><b>Капитал: </b>$cash</small>  
						</div>
					</div>
				</li>
HTML;
				}
?>
			
			</ul>
		</div>
	</div>
</div>


<!-- основной контент -->