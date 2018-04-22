<!DOCTYPE HTML>
<html>
	<head>
		<?php echo tpl('header', array('class' => $class)); ?>
	</head>
	<body<?php if(superAdmin()) echo ' class="admin"';?>>
	<?php if(superAdmin()) echo tpl('adminpanel'); ?>
	<div class="page-wrapper">
		<div class="header">
			<div class="menu wrap">
				
				<div class="logo">
					<img src="<?php echo PUB_URL ?>img/logo.png" height="50">
				</div>
				<div class="dropdownmenu">
					<ul class="topmenu">
						<?php echo menu(); ?>
					</ul>
				</div>	
				<div class="langs">
					<?php echo langs(); ?>
				</div>
			</div>
		</div>

		
		<div class="content">
			<div class="wrap wrap-<?php echo $class->className .  ' ' . $class->tpl;?>">
				<?php echo $content;?>		
			</div>		
		</div>
		
		<div class="page-buffer"></div>
	</div>	
			
			
	<div class="footer">
		<div class="wrap">
			<?php echo tpl('footer'); ?>
		</div>	
	</div>

	<div class="modal-overlay"></div>	
	<section id="modal" class="modal">
		<div class="fa fa-times icon icon-big modal-close"></div>
		<div class="modal-body">	
		</div>
	</section>
		
		
	</body>
</html>
