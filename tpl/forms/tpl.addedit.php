<?php $oForms = M('forms');  ?>
<h1><?php echo $title;?></h1>
<?php $_fields = @unserialize(@$data['fields']); unset($fields['fields']);?>
<?php $formid = $class . '_form_item_' . $id;?>
<form method="POST" id="form" class="content" action="<?php echo BASE_URL . $class;?>/save?ajax=1" novalidate="novalidate">
<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
	<table cellpadding=0 cellspacing=0>
		<?php 
			echo drawForm($fields, $data, $options); 
		?>			
	</table>
	<h2>Fields</h2>
	<div class="table fields">
		<div class="tr thead">
			<div class="td">
				<?php echo T('name'); ?>			
			</div>
			<div class="td">
				<?php echo T('type'); ?>			
			</div>		
			<div class="td">
				<?php echo T('widget'); ?>			
			</div>				
			<div class="td">
				<?php echo T('required'); ?>			
			</div>						
			<div class="td">
				<?php echo T('delete'); ?>			
			</div>
		</div>
		<?php if(!empty($_fields)) { $i = 0;
			foreach($_fields as $field) {
				echo $oForms->addField($i, $field); $i++;
			}
		}; ?>
	</div>
	<div class="btn addField" ><?php echo T('add field');?></div>
	<div class="btn submit"><?php echo T('save');?></div>
	<?php if($id > 0) { ?>
	<div class="btn view"><?php echo T('view');?></div>
	<?php } ?>
	<div class="messages"></div>
</form>
<div class="field hidden">
<?php echo $oForms->addField();?>
</div>


<script src="<?php echo BASE_URL;?>external/savectrls.js" type="text/javascript"></script>
<script>
	//function saveFn(){ saveForm(); }		
	//$('.submit').click(function() { saveFn() });
	var key = <?php echo (int)@$i;?>;
	$('.addField').click(function(e) { 
		str = $('.field').html().replace(/{key}/g, key); key++;
		console.log(str);
		$('.fields').append(str); 
	});
	$('.view').click(function(e) { window.open('<?php echo BASE_URL . 'forms/view/' . $id; ?> ', '_blank'); });
	
</script>	