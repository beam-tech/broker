<div class="container">
    <div class="row">
		<div class="span4 offset4">
			<div id="retrieve">
				<div class="row">
						<h2>Восстановить пароль</h2>
						<p>Введите email пользователя:</p>
							<div class="input-append" id="data">
								<form method="post" action="">
									<input type="hidden" name="mov" value="retrieve">
									<input class="span3" name="email" size="64" type="text">
									<button type="button" class="btn btn-inverse" onclick="sendEmail()" >Прислать пароль</button>
									</form>
							</div>
						<a href="/" class="btn btn-small">на главную</a>
						<div id="alert_placeholder"></div>
				</div>
			</div>
		</div>
	</div>
</div>
