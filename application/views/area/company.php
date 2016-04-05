<?
	$id = $model->data['company']['id'];
	$name = $model->data['company']['name'];
	$div = $model->data['company']['dividends'];
	$shareCnt = $model->data['company']['share_cnt'];
	$sharePrice = $model->data['company']['share_price'];
	$UserShareCnt= $model->data['shareCnt'];
	$img = $model->data['company']['img'];
	$nd = $model->data['near_def']
?>
<div id="modal_comp" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="myModalLabel"><?=$name?><b class="text-error"> <?=$nd?></b></h3>
    </div>
	<div class="modal-body">
		<div class="span2">
			<a href="#" class="thumbnail">
				<img src=<?echo "/img/$img"; ?>  width="260" height="180" alt="">
			</a>
		</div>
		<div class="span3">      
			<p>Дивиденд: <?=$div?></p>
	        <p id='tot_share'>Доступное кол-во акций: <?=$shareCnt?></p>
	        <p id='share_cnt'>Стоимость акции: <?=$sharePrice?>$</p>
	     	<p><strong>Введите кол-во акций:</strong></p>
				<div class="input-append" id="data">
					<form action="" method="POST">
						<input type="hidden" value=<?echo "$id";?> name="comp_id">
	    	  			<input type="text" class="input-mini" value="0" name="share_cnt">
	  		    		<div class="btn-group">
			      			<button class="btn btn-primary" type="button" onclick="buyShare()">Купить</button>
			      			<button class="btn btn-primary" type="button" onclick="sellShare()">Продать</button>
			    		</div>
					</form>
				</div>
			
			<p><b id='user_share'>Акций в наличии: <?=$UserShareCnt?></b></p>
			<div id="alert_placeholder"></div>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal">Close</button>
	</div>
</div>

<script type="text/javascript">
	$("#modal_comp").on('hide', function () {
        window.location.reload();
    });

</script>