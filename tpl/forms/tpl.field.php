<?php $key = ((empty($key) && $key !== '0') ? '{key}' : $key); ?>
<div class="tr">
	<div class="td">
		<input name="form[fields][<?php echo $key;?>][name]" value="<?php echo @$data['name'];?>">
	</div>
	<div class="td">
		<select  name="form[fields][<?php echo $key;?>][type]" >
			<?php foreach($types as $type) { ?>
				<option value="<?php echo $type;?>" 
					<?php if(@$data['type'] == $type) echo " selected='selected'";?>><?php echo T($type);?>
				</option> 
			<?php } ?>
		</select>
	</div>
	<div class="td">
		<select  name="form[fields][<?php echo $key;?>][widget]" >
			<?php foreach($widgets as $widget) { ?>
				<option value="<?php echo $widget;?>" 
					<?php if(@$data['widget'] == $widget) echo " selected='selected'";?>><?php echo T($widget);?>
				</option> 
			<?php } ?>
		</select>
	</div>
	<div class="td">
		<input type="checkbox" id="required_<?php echo $key;?>" name="form[fields][<?php echo $key;?>][required]" value="1"<?php if(@$data['required'] > 0) echo " checked";?>>
		<label for="required_<?php echo $key;?>"></label>
		<!--<select  name="form[fields][<?php echo $key;?>][validation]" >
			<?php foreach($validators as $validator) { ?>
				<option value="<?php echo $validator;?>" 
					<?php if(@$data['validator'] == $validator) echo " selected='selected'";?>><?php echo T($validator);?>
				</option> 
			<?php } ?>
		</select>-->
	</div>
	<div  class="td">
		<div class="btn" onclick="javascript:$(this).closest('.tr').remove();"><?php echo T('del');?></div>	
	</div>
</div>	