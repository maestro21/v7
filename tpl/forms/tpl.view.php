<?php $formid = $class . '_form_item_' . $id;?>
<form method="POST" id="form" action="<?php echo BASE_URL . $class;?>/post?ajax=1" novalidate="novalidate">
	<input type="hidden" name="id" id="id" value="<?php echo $data['id'];?>">
	<div<?php if($data['split']) echo " class='half'";?>>
	<table cellpadding=0 cellspacing=0>
	<?php 
		echo drawForm($data['fields'], array(), array(), $data['split']); 
	?>
		<tr>
			<td colspan="2" align="center">
				<div class="btn submit"><?php echo T('submit');?></div>
				<div class="messages"></div>	
				<div class="left">	
				<?php if($data['split']) echo mtpl('contactperson'); ?>
				</div>
			</td>
		</tr>
	</table>
	</div>	
</form>

<script src="<?php echo BASE_URL;?>external/savectrls.js" type="text/javascript"></script>
<script>

	function saveFn(){ 
		saveForm(); 		
	}		
	//$('#saveBtn').click(function() { saveFn() });

</script>	