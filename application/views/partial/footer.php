</div>
</div>
<?php
$app_version = $this->config->item('version') ? $this->config->item('version') : '1.0.0';
$website_url = $this->config->item('website');
?>
<div id="footer">
<?php echo $this->lang->line('common_you_are_using_phppos').' '.htmlspecialchars($app_version).'.'; ?>
<?php if (!empty($website_url)) { ?>
<?php echo ' '.$this->lang->line('common_please_visit_my'); ?> <a href="<?php echo htmlspecialchars($website_url); ?>" target="_blank"><?php echo $this->lang->line('common_website'); ?></a> <?php echo $this->lang->line('common_learn_about_project'); ?>.
<?php } ?>
</div>
</body>
</html>
