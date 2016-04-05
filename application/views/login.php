<div class="container">
    <div class="row">
		<div class="span4 offset4">
		<div id="login">
		<ul class="nav nav-pills">
		    <li class="active"><a data-toggle="tab" href="#auth">Авторизация</a></li>
		    <li><a data-toggle="tab" href="#reg">Регистрация</a></li>
		</ul>
		<div class="tab-content">
		    <div class="tab-pane fade in active" id="auth">
				<form method="POST" action="" accept-charset="UTF-8">
					<input type="hidden" name="mov" value="auth">
					<input type="text"  class="span4" name="login" placeholder="Логин">
					<input type="password"  class="span4" name="password" placeholder="Пароль">
					<button type="button" onclick="doAuth()"  class="btn btn-large btn-block btn-primary">Войти</button>
				</form>
				<a href="index/retrieve" class="btn btn-small">Восстановить пароль</a>
				<div id="alert_placeholder"></div>
		    </div>
		    <div class="tab-pane fade " id="reg">
		    	<form method="POST" action="" accept-charset="utf-8">
					<input type="hidden" name="mov" value="reg">
					<label>Введите логин</label>
						<input type="text" class="span4" name="login">
					<label>Введите email</label>
						<input type="text" class="span4" name="email">
					<label>Введите пароль</label>
						<input type="password" class="span4" name="password">
					<button type="button" onclick="doReg()" class="btn btn-large btn-block btn-success">Создать аккаунт</button>
				</form>
				<div id="reg_alert_placeholder"></div>
		    </div>
		</div>
		</div>
		</div>
	</div>
</div>

<script>

$(document).ready(function() {
    // show active tab on reload
    if (location.hash !== '') $('a[href="' + location.hash + '"]').tab('show');

    // remember the hash in the URL without jumping
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
       if(history.pushState) {
            history.pushState(null, null, '#'+$(e.target).attr('href').substr(1));
       } else {
            location.hash = '#'+$(e.target).attr('href').substr(1);
       }
    });
});
</script>