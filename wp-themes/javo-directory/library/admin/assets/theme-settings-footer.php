<div class="javo_ts_tab javo-opts-group-tab hidden" tar="footer">
	<h2> <?php _e("Footer Settings", "javo_fr"); ?> </h2>
	<table class="form-table">
	<tr><th>
		<?php _e('Custom Script', 'javo_fr');?>
		<span class="description">
			<?php _e(' If you have additional script, please add here.', 'javo_fr');?>
		</span>
	</th><td>
		<h4><?php _e('Code:', 'javo_fr');?></h4>
		<?php echo esc_html('<script type="text/javascript">');?>
		<fieldset>
			<textarea name="javo_ts[custom_js]" class="large-text code" rows="15"><?php echo stripslashes($javo_tso->get('custom_js', ''));?></textarea>
		</fieldset>
		<?php echo esc_html('</script>');?>
		<div><?php _e('(Note : Please make sure that your scripts are NOT conflict with our own script or ajax core)', 'javo_fr');?></div>
	</td></tr><tr><th>
		<?php _e('Copyright Information', 'javo_fr');?>
		<span class="description">
			<?php _e('Type your copyright information. It will be displayed on footer.', 'javo_fr');?>
		</span>
	</th><td>
		<h4><?php _e('Display Text or HTML', 'javo_fr');?></h4>
		<fieldset>
			<textarea name="javo_ts[copyright]" class="large-text code" rows="15"><?php echo stripslashes($javo_tso->get('copyright', ''));?></textarea>
		</fieldset>
	</td></tr><tr><th>
		<?php _e('Google API', 'javo_fr');?>
		<span class="description">
			<?php _e('Paste your Google Analytic tracking codes here.', 'javo_fr');?>
		</span>
	</th><td>
		<h4><?php _e('Google Analystics Code', 'javo_fr');?></h4>
		<fieldset>
			<textarea name="javo_ts[analytics]" class="large-text code" rows="15"><?php echo stripslashes($javo_tso->get('analytics', ''));?></textarea>
		</fieldset>
	</td></tr>
	</table>
</div>