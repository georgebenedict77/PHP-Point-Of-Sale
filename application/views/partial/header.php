<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<base href="<?php echo base_url();?>" />
	<?php
	$company_name = $this->config->item('company') ? $this->config->item('company') : 'BenPay';
	$app_version = $this->config->item('version') ? $this->config->item('version') : '1.0.0';
	?>
	<title><?php echo htmlspecialchars($company_name).' POS'; ?></title>
	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/phppos.css" />
	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/phppos_print.css"  media="print"/>
	<script src="<?php echo base_url();?>js/jquery-1.2.6.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.color.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.metadata.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.form.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.tablesorter.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.ajax_queue.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.bgiframe.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.autocomplete.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.validate.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/thickbox.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/common.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/manage_tables.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<style type="text/css">
html {
    overflow: auto;
}
</style>
<script type="text/javascript">
(function()
{
	var themeStorageKey = 'benpay_theme';
	var savedTheme = 'light';
	try
	{
		var storedTheme = window.localStorage.getItem(themeStorageKey);
		if (storedTheme == 'dark' || storedTheme == 'light')
		{
			savedTheme = storedTheme;
		}
	}
	catch (e)
	{
		savedTheme = 'light';
	}
	document.documentElement.className = (document.documentElement.className + ' theme-' + savedTheme).replace(/\s+/g, ' ').replace(/^\s+|\s+$/g, '');
})();
</script>

</head>
<body class="theme-light">
<div id="menubar">
	<div id="menubar_container">
		<div id="menubar_company_info">
		<span id="company_title"><?php echo htmlspecialchars($company_name); ?></span><br />
		<span style='font-size:8pt;'><?php echo $this->lang->line('common_version_label').' '.htmlspecialchars($app_version); ?></span>
	</div>

		<div id="menubar_navigation">
			<div class="menu_item">
				<a href="<?php echo site_url('home');?>">
				<img src="<?php echo base_url().'images/menubar/home.png';?>" border="0" alt="Menubar Image" /></a><br />
				<a href="<?php echo site_url("home");?>"><?php echo $this->lang->line("module_home") ?></a>
			</div>

			<?php
			foreach($allowed_modules->result() as $module)
			{
			?>
			<div class="menu_item">
				<a href="<?php echo site_url("$module->module_id");?>">
				<img src="<?php echo base_url().'images/menubar/'.$module->module_id.'.png';?>" border="0" alt="Menubar Image" /></a><br />
				<a href="<?php echo site_url("$module->module_id");?>"><?php echo $this->lang->line("module_".$module->module_id) ?></a>
			</div>
			<?php
			}
			?>
		</div>

		<div id="menubar_footer">
		<?php echo $this->lang->line('common_welcome')." $user_info->first_name $user_info->last_name! | "; ?>
		<?php echo anchor("home/logout",$this->lang->line("common_logout")); ?>
		</div>

		<div id="menubar_date">
		<?php echo date('F d, Y') ?><br />
		<a href="#" id="theme_toggle_link" data-dark-label="<?php echo htmlspecialchars($this->lang->line('common_toggle_dark_mode')); ?>" data-light-label="<?php echo htmlspecialchars($this->lang->line('common_toggle_light_mode')); ?>"></a>
		</div>

	</div>
</div>
<script type="text/javascript">
$(document).ready(function()
{
	var themeStorageKey = 'benpay_theme';
	var currentTheme = 'light';

	function applyTheme(mode)
	{
		var bodyClass = $('body').attr('class') || '';
		bodyClass = bodyClass.replace(/\btheme-light\b/g, '').replace(/\btheme-dark\b/g, '').replace(/\s+/g, ' ').replace(/^\s+|\s+$/g, '');
		$('body').attr('class', (bodyClass ? bodyClass + ' ' : '') + 'theme-' + mode);
		$('html').removeClass('theme-light').removeClass('theme-dark').addClass('theme-' + mode);
		$('#theme_toggle_link').text(mode == 'dark' ? $('#theme_toggle_link').attr('data-light-label') : $('#theme_toggle_link').attr('data-dark-label'));
	}

	try
	{
		var storedTheme = window.localStorage.getItem(themeStorageKey);
		if (storedTheme == 'dark' || storedTheme == 'light')
		{
			currentTheme = storedTheme;
		}
	}
	catch (e)
	{
		currentTheme = 'light';
	}

	applyTheme(currentTheme);

	$('#theme_toggle_link').click(function(e)
	{
		e.preventDefault();
		currentTheme = currentTheme == 'dark' ? 'light' : 'dark';
		try
		{
			window.localStorage.setItem(themeStorageKey, currentTheme);
		}
		catch (err)
		{
		}
		applyTheme(currentTheme);
	});
});
</script>
<div id="content_area_wrapper">
<div id="content_area">
