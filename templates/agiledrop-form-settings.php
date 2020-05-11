<?php settings_errors( 'agiledrop_form_messages' ); ?>
<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <p>Add form with shortcode [agiledrop_form]</p>
    <form action="options.php" method="post">
		<?php
		settings_fields( 'agiledrop_form' );
		do_settings_sections( 'agiledrop_form' );
		submit_button( 'Save Settings' );
		?>
    </form>
</div>