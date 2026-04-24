<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/login.css" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php
$company_name = $this->config->item('company') ? $this->config->item('company') : 'BenPay';
$app_version = $this->config->item('version') ? $this->config->item('version') : '1.0.0';
$show_register = isset($show_register) ? $show_register : FALSE;
$registration_error = isset($registration_error) ? $registration_error : '';
?>
<title><?php echo htmlspecialchars($company_name); ?> <?php echo $this->lang->line('login_login'); ?></title>
<script src="<?php echo base_url();?>js/jquery-1.2.6.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script type="text/javascript">
$(document).ready(function()
{
	var themeStorageKey = 'benpay_theme';

	function applyTheme(mode)
	{
		var bodyClass = $('body').attr('class') || '';
		bodyClass = bodyClass.replace(/\btheme-light\b/g, '').replace(/\btheme-dark\b/g, '').replace(/\s+/g, ' ').replace(/^\s+|\s+$/g, '');
		$('body').attr('class', (bodyClass ? bodyClass + ' ' : '') + 'theme-' + mode);
		$('html').removeClass('theme-light').removeClass('theme-dark').addClass('theme-' + mode);
		$('#theme_toggle_link').text(mode == 'dark' ? $('#theme_toggle_link').attr('data-light-label') : $('#theme_toggle_link').attr('data-dark-label'));
	}

	function getSavedTheme()
	{
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
		return savedTheme;
	}

	var currentTheme = getSavedTheme();
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

	$("#container input:first").focus();
});
</script>
</head>
<body class="theme-light">
<div id="auth_wrapper">
<div id="auth_header">
	<h1><?php echo htmlspecialchars($company_name).' '.htmlspecialchars($app_version); ?></h1>
	<a href="#" id="theme_toggle_link" data-dark-label="<?php echo htmlspecialchars($this->lang->line('common_toggle_dark_mode')); ?>" data-light-label="<?php echo htmlspecialchars($this->lang->line('common_toggle_light_mode')); ?>"></a>
</div>
<div id="container">
<?php if (!empty($registration_error)) { ?>
<div class="error"><?php echo $registration_error; ?></div>
<?php } ?>
<?php echo validation_errors(); ?>
	<div id="top">
	<?php echo $show_register ? $this->lang->line('login_create_account') : $this->lang->line('login_login'); ?>
	</div>
	<div id="auth_tabs">
		<a class="auth_tab <?php echo !$show_register ? 'active' : ''; ?>" href="<?php echo site_url('login'); ?>"><?php echo $this->lang->line('login_login'); ?></a>
		<a class="auth_tab <?php echo $show_register ? 'active' : ''; ?>" href="<?php echo site_url('login/register'); ?>"><?php echo $this->lang->line('login_create_account'); ?></a>
	</div>
	<div id="login_form">
		<?php if (!$show_register) { ?>
		<?php echo form_open('login'); ?>
		<div id="welcome_message">
		<?php echo $this->lang->line('login_welcome_message'); ?>
		</div>
		
		<div class="form_field_label"><?php echo $this->lang->line('login_username'); ?>: </div>
		<div class="form_field">
		<?php echo form_input(array(
		'name'=>'username', 
		'value'=>set_value('username'),
		'size'=>'20')); ?>
		</div>

		<div class="form_field_label"><?php echo $this->lang->line('login_password'); ?>: </div>
		<div class="form_field">
		<?php echo form_password(array(
		'name'=>'password', 
		'value'=>set_value('password'),
		'size'=>'20')); ?>
		
		</div>
		
		<div id="submit_button">
		<?php echo form_submit('loginButton',$this->lang->line('login_go')); ?>
		</div>
		<?php echo form_close(); ?>
		<?php } else { ?>
		<?php echo form_open('login/create_account'); ?>
		<div id="welcome_message">
		<?php echo $this->lang->line('login_create_account_message'); ?>
		</div>

		<div class="form_field_label"><?php echo $this->lang->line('common_first_name'); ?>: </div>
		<div class="form_field">
		<?php echo form_input(array(
		'name'=>'first_name', 
		'value'=>set_value('first_name'),
		'size'=>'20')); ?>
		</div>

		<div class="form_field_label"><?php echo $this->lang->line('common_last_name'); ?>: </div>
		<div class="form_field">
		<?php echo form_input(array(
		'name'=>'last_name', 
		'value'=>set_value('last_name'),
		'size'=>'20')); ?>
		</div>

		<div class="form_field_label"><?php echo $this->lang->line('common_email'); ?>: </div>
		<div class="form_field">
		<?php echo form_input(array(
		'name'=>'register_email', 
		'value'=>set_value('register_email'),
		'size'=>'20')); ?>
		</div>

		<div class="form_field_label"><?php echo $this->lang->line('common_phone_number'); ?>: </div>
		<div class="form_field">
		<?php echo form_input(array(
		'name'=>'phone_number', 
		'value'=>set_value('phone_number'),
		'size'=>'20')); ?>
		</div>

		<div class="form_field_label"><?php echo $this->lang->line('login_username'); ?>: </div>
		<div class="form_field">
		<?php echo form_input(array(
		'name'=>'register_username', 
		'value'=>set_value('register_username'),
		'size'=>'20')); ?>
		</div>

		<div class="form_field_label"><?php echo $this->lang->line('login_password'); ?>: </div>
		<div class="form_field">
		<?php echo form_password(array(
		'name'=>'register_password',
		'value'=>set_value('register_password'),
		'size'=>'20')); ?>
		</div>

		<div class="form_field_label"><?php echo $this->lang->line('login_confirm_password'); ?>: </div>
		<div class="form_field">
		<?php echo form_password(array(
		'name'=>'register_password_confirm',
		'value'=>set_value('register_password_confirm'),
		'size'=>'20')); ?>
		</div>

		<div id="submit_button">
		<?php echo form_submit('registerButton',$this->lang->line('login_register')); ?>
		</div>
		<?php echo form_close(); ?>
		<?php } ?>
	</div>
</div>
</div>
</body>
</html>
