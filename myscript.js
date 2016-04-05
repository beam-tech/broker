	/**
	 * Совершает авторизацию.
	 */
	function doAuth(){
		/* собираем данные */
		var mov = $('#auth input[name=mov]').val();
		var login = $('#auth input[name=login]').val();
		var password = $('#auth input[name=password]').val();
		/* если поля не пустые */
		if(login != "" || password != ""){			
			$.ajax({
				type:"POST",
				url: 'index/index',    // указываем URL и
				data:{mov:mov, login:login, password:password},
				dataType : "html",            // тип загружаемых данных
				success: function (data) {
					data = JSON.parse(data);
					/*если не может авторизоваться*/
					if(data.res == false){
						$('#alert_placeholder').append('<div class="alert alert-error" id="error_alert"><a class="close" data-dismiss="alert">×</a><span>'+data.msg+'</span></div>');
					}else{
						$('#alert_placeholder').append('<div class="alert alert-success" id="error_alert"><a class="close" data-dismiss="alert">×</a><span>'+ data.msg+'</span></div>');
						/* обновляем страницу*/
						setTimeout(function(){location.reload();},1000);
					}
					$("#error_alert").fadeTo(2000, 500).slideUp(500, function(){
						$("#error_alert").alert('close');
					});
				}
			});
		}else{
			$('#alert_placeholder').html('<div class="alert alert-error" id="error_alert"><a class="close" data-dismiss="alert">×</a><span>'+'Поля пусты!'+'</span></div>');
		}
		$("#error_alert").fadeTo(2000, 500).slideUp(500, function(){
			$("#error_alert").alert('close');
		});
	}

	/**
	 * Совершает регистрацию.
	 */
	function doReg(){
		/* собираем данные */
		var mov = $('#reg input[name=mov]').val();
		var login = $('#reg input[name=login]').val();
		var password = $('#reg input[name=password]').val();
		var email = $('#reg input[name=email]').val();
		/* если поля не пустые */
		if(login != "" || password != "" || email != ""){
						
			$.ajax({
				type:"POST",
				url: 'index/index',            		   // указываем URL и
				data:{mov:mov, login:login, password:password, email:email},
				dataType : "html",                     // тип загружаемых данных
				success: function (data) {
					data = JSON.parse(data);
					/*если не может зарегистроваться*/
					if(data.res == false){
						$('#reg_alert_placeholder').append('<div class="alert alert-error" id="error_alert"><a class="close" data-dismiss="alert">×</a><span>'+ data.msg+'</span></div>');
					}else{
						$('#reg_alert_placeholder').append('<div class="alert alert-success" id="error_alert"><a class="close" data-dismiss="alert">×</a><span>'+ data.msg+'</span></div>');
					}
					/*красивый вывод и закрытие*/
					$("#error_alert").fadeTo(2000, 500).slideUp(500, function(){
						$("#error_alert").alert('close');
					});
				}
			});
		}else{
			$('#reg_alert_placeholder').html('<div class="alert alert-error" id="error_alert"><a class="close" data-dismiss="alert">×</a><span>'+'Поля пусты!'+'</span></div>');
		}
		$("#error_alert").fadeTo(2000, 500).slideUp(500, function(){
			$("#error_alert").alert('close');
		});
	}
	/**
	 * Совершает отправку email.
	 */
	function sendEmail(){
		/* собираем данные */
		var email = $(".input-append input[name=email]").val();
		var mov = $('.input-append input[name=mov]').val();
		/* если поле не пустое */
		if(email != ""){	
			$.ajax({
				type:"POST",
				url: '/index/retrieve',            		   // указываем URL и
				data:{mov:mov, email:email},
				dataType : "html",                     // тип загружаемых данных
				success: function (data) {
					data = JSON.parse(data);
					if(data.res == false){
						$('#alert_placeholder').append('<div class="alert alert-error" id="error_alert"><a class="close" data-dismiss="alert">×</a><span>'+data.msg+'</span></div>');
					}else{
						$('#alert_placeholder').append('<div class="alert alert-success" id="error_alert"><a class="close" data-dismiss="alert">×</a><span>'+ data.msg+'</span></div>');
					}
					$("#error_alert").fadeTo(2000, 500).slideUp(500, function(){ $("#error_alert").alert('close'); });
					//console.log(data.msg);
				}
			});
		}else{
			$('#alert_placeholder').html('<div class="alert alert-error" id="error_alert"><a class="close" data-dismiss="alert">×</a><span>'+'Поля пусты!'+'</span></div>');
		}
		$("#error_alert").fadeTo(2000, 500).slideUp(500, function(){ $("#error_alert").alert('close'); });
	}

	/**
	 * Совершает покупку акций.
	 */
	function buyShare () {
		var companyId = $('#data input[name=comp_id]').val();
		var shareCnt = $('#data input[name=share_cnt]').val();
		//console.log('buy');
		//console.log(companyId);
		//console.log(shareCnt);
		if(shareCnt!='' && shareCnt>0 ){
			$.ajax({
				type:"POST",
				url: '/area/share',            		   // указываем URL и
				data:{comp_id:companyId, share_cnt:shareCnt, mov:'buy'},
				dataType : "html",                     // тип загружаемых данных
				success: function (data) {
					//console.log(data);
					data = JSON.parse(data);
					//console.log(data);
					if(data.shareCnt != false){
						$('#alert_placeholder').html("<span id='error_alert' class='label label-success'>"+data.msg+"</span>");
						str1 = 'Стоимость акции: '+ data.shareCnt + '$';
						str2 = 'Доступное кол-во акций: ' + data.totShare;
						str3 = 'Акций в наличии: ' + data.userShare;
						$('#share_cnt').text(str1);
						$('#tot_share').text(str2);
						$('#user_share').text(str3);
					}else{
						$('#alert_placeholder').html("<span id='error_alert' class='label label-warning'>"+data.msg+"</span>");
					}
				}
			});
		}else{
			$('#alert_placeholder').html("<span id='error_alert' class='label label-warning'>Необходимо число > 0</span>");
		}
		/*красивый вывод и закрытие*/
		$("#error_alert").fadeTo(1000, 500).slideUp(500, function(){
			$("#error_alert").remove();
		});
	}
	/**
	 * Совершает продажу акций.
	 */
	function sellShare () {
		var companyId = $('#data input[name=comp_id]').val();
		var shareCnt = $('#data input[name=share_cnt]').val();

		//console.log('buy');
		//console.log(companyId);
		//console.log(shareCnt);
		if(shareCnt!='' && shareCnt>0 ){
			$.ajax({
				type:"POST",
				url: '/area/share',            		   // указываем URL и
				data:{comp_id:companyId, share_cnt:shareCnt, mov:'sell'},
				dataType : "html",                     // тип загружаемых данных
				success: function (data) {
					data = JSON.parse(data);
					//console.log(data);
					if(data.shareCnt != false){
						$('#alert_placeholder').html("<span id='error_alert' class='label label-success'>"+data.msg+"</span>");
						str1 = 'Стоимость акции: '+ data.shareCnt + '$';
						str2 = 'Доступное кол-во акций: ' + data.totShare;
						str3 = 'Акций в наличии: ' + data.userShare;
						$('#share_cnt').text(str1);
						$('#tot_share').text(str2);
						$('#user_share').text(str3);
					}else{
						$('#alert_placeholder').html("<span id='error_alert' class='label label-warning'>"+data.msg+"</span>");
					}
				}
			});
		}else{
			$('#alert_placeholder').html("<span id='error_alert' class='label label-warning'>Необходимо число > 0</span>");
		}
		/*красивый вывод и закрытие*/
		$("#error_alert").fadeTo(1000, 500).slideUp(500, function(){
			$("#error_alert").remove();
		});
	}
