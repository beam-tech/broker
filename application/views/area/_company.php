<?
	$name = $this->data['company']['name'];
	$div = $this->data['company']['dividends'];
	$shareCnt = $this->data['company']['share_cnt'];
	$sharePrice = $this->data['company']['share_price'];
	$UserShareCnt= $this->data['shareCnt'];
	$img = $this->data['company']['img'];
?>
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

<div class="container" id="content">
	<div class="row">
	  <div class="span12">
	    <div class="row">
	      <div class="span8">
	        <h4><strong><h3><?=$name?></h3></strong></h4>
	      </div>
	    </div>
	    <div class="row">
	      <div class="span2">
	        <a href="#" class="thumbnail">
	            <img src=<?echo "/img/$img"; ?>  width="260" height="180" alt="">
	        </a>
	      </div>
		<div class="span6">      
	        <p>Дивиденд: <?=$div?></p>
	        <p>Доступное кол-во акций: <?=$shareCnt?></p>
	        <p>Стоимость акции: <?=$sharePrice?></p>
	     	<p><strong>Введите кол-во акций:</strong></p>
			<div class="input-append" id="msg">
				<form action="" method="POST">
					<input type="hidden" value="1" name="comp_id">
	      			<input type="text" class="input-mini" value="0" name="share_cnt">
	  	    		<div class="btn-group">
		      			<button class="btn btn-primary" type="submit" name="mov" value="buy">Купить</button>
		      			<button class="btn btn-primary" type="submit" name="mov" value="sell">Продать</button>
		    		</div>
				</form>
			</div>
			<p>Акций в наличие: <?=$UserShareCnt?></p>
			<?
			echo "<span class='label label-warning'>".$this->errors['msgs']."</span><br/>";
			echo "<span class='label label-success'>".$this->done['msgs']."</span><br/>";
		?>
		</div>
	    </div>
	  </div>
	</div>
</div>

