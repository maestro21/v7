<?php
$messages = $data['messages'];
$forms = $data['forms']; 
?>

<?php foreach($messages as $message) { 
	$msgdata = unserialize($message['data']);
	$msgdata = moveToBottom($msgdata, 'message');
	$formid = $message['form_id'];
	$fields = $forms[$formid];	
	
	 ?>
	<div class="message"> 
		<b><?php echo T('sent on') . ' ' . fDateTime($message['sent']);?></b><br>
		<?php 
		foreach($msgdata as $k=> $v) { 
		$t = getFieldType($k, $fields);
		?>
		<?=$k;?>: <b><?php echo fType($v, $t);?></b><br>
		<?php } ?>
	</div> 
<?php } ?>