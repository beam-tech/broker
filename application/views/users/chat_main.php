<div class='container'>
 	<div id='content' class='row-fluid'>
	<div class='span12 sidebar'>
		<ul class="nav  nav-pills" >
			<li><a href='/user'>Профиль</a></li>
			<li class="active"><a href='/user/chat'>Общение</a></li>
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

<div class='container' id="content">
	<div class="row" >
		<div class="span8 offset2">
			<p><strong>Страница для общения</strong></p>
				<div class="input-append" id="msg">
					<form method="post" action="">
						<input type="text" class="span6" name="msg">
						<button type="button" class="btn btn-inverse" onclick="sendMsg()">Отправить</button>
					</form>
				</div>
				<div id="msgs"></div>

		</div>
	</div>
</div>
<script type="text/javascript">
	setInterval('getMsg()',1000);
	function sendMsg(){
	    /* собираем данные */
		var msg = $('#msg input[name=msg]').val();
	    /* если поля не пустые */
		if(msg != ""){			
			$.ajax({
				type:"POST",
				url: '/user/chat',   // указываем URL и
				data:{msg:msg},
				success:function () {
					$('#msg input[name=msg]').val('');
				}
			});
		}
	}
	function getMsg(){	
		$.ajax({
			url:'/user/chat',
			method:'post',
			data:{show:'msgs'},
			success:function(data){
				$('#msgs').empty();
				//$('#history').empty();
				data = JSON.parse(data)
				$.each(data, function(k,v){
					$('#msgs').append('\
						<p>\
							<a href="/user/show/name/'+v.name+'">'+v.name+'</a> @ '+v.dt+'\
							<br />'+v.msg+'\
							<hr />\
						</p>');
                })
            }
        });
    }
$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
</script>