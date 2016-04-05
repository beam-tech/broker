<?
	$name = $model->data['company']['name'];
	$img = $model->data['company']['img'];
?>
<div id="modal_comp" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="myModalLabel"><?=$name?></h3>
    </div>
	<div class="modal-body">
		<div class="span2">
			<a href="#" class="thumbnail">
				<img src=<?echo "/img/$img"; ?>  width="260" height="180" alt="">
			</a>
		</div>
		<div class="span3">      
			<p><b class="text-error">БАНКРОТ</b></p>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal">Close</button>
	</div>
</div>
