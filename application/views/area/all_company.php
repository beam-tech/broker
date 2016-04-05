<div class='container'>
	<div id='content' class='row-fluid'>
		<div class='span12 sidebar'>
			<ul class="nav  nav-pills" >
				<li><a href='/user'>Профиль</a></li>
				<li><a href='/user/chat'>Общение</a></li>
				<li><a href='/user/top'>ТОП 10</a></li>
				<li><a href='/user/all'>Игроки</a></li>
				<li><a href='/user/feedback'>Обратная связь</a></li>
				<li class="active"><a href='/area/companies'>Компании</a></li>
				<li><a href='/area/shop'>Магазин</a></li>
				<li><a href='/area/storage'>Банк</a></li>
				<li><a href='/area/work'>Работа</a></li>
			</ul>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
	<div class="span12">
		<ul class="thumbnails">
              <?
              //var_dump($this->data['company']);
              	foreach($this->data['company'] as $item){
				$id = $item['id'];
				$name = $item['name'];
				$status = $item['status'];
				$div = $item['dividends'];
				$totalShareCnt = $item['total_share_cnt'];
				$shareCnt = $item['share_cnt'];
				$sharePrice = $item['share_price'];
				$img = $item['img'];
			echo <<<LABEL
			<li class="span4">
              <div class="thumbnail">
				<img src="/img/$img" alt="$name">
                <div class="caption" id="comp">
					<h3>$name</h3>
					<p>Статус: $status</p>
					<p>Дивиденды: $div</p>
					<p>Общее кол-во акций: $totalShareCnt</p>
					<p>Кол-во акций доступных для покупки: $shareCnt</p>
					<p>Стоимость акции: $sharePrice$</p>
				
				    <p align="center"><button type="button" onclick="showCompany($id)" class="btn btn-block btn-primary">Открыть</button></p>
                </div>
                </div>
            </li>
LABEL;
		}
              ?>
        </ul>
	</div>
	</div>
</div>
<div id="comp_place">
	
</div>

<script type="text/javascript">
	
    
	function showCompany (compId) {
		/* собираем данные */
		//console.log(compId);
		/* если поля не пустые */
		if(isInt(compId)){		
			$.ajax({
				type:"POST",
				url: '/area/companies',            		   // указываем URL и
				data:{comp_id:compId},
				dataType : "html",                     // тип загружаемых данных
				success: function (data) {
					//data = JSON.parse(data);
					//console.log(data);
					$('#comp_place').html(data);
					$('#modal_comp').modal('show');
				}
			});
		}else{
			$('#reg_alert_placeholder').html('<div class="alert alert-error" id="error_alert"><a class="close" data-dismiss="alert">×</a><span>'+'Поля пусты!'+'</span></div>');
		}
		$("#error_alert").fadeTo(2000, 500).slideUp(500, function(){
			$("#error_alert").alert('close');
		});
	}

	function isInt(n){
        return Number(n)===n && n%1===0;
	}
</script>