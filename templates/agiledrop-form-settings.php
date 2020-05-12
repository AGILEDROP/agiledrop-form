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

    <h1>Add Form Field</h1>
    <form action="options.php" method="post">
		<?php
		settings_fields( 'agiledrop_form_fields' );
		do_settings_sections( 'agiledrop_form_fields' );
		submit_button( 'Add Field' );
		?>
    </form>

    <h1>Form preview</h1>
    <?php
        $fields = get_option( 'agiledrop_form_fields_options' );
        if ( ! $fields ) {
            echo "<p>No fields, please create some</p>";
        }else {
            foreach ( $fields as $field ) :
    ?>
    <form action="#">
        <label for="<?php echo $field['title']; ?>"><?php echo $field['title']?></label>
        <input type="<?php echo $field['type'];?>">
    </form>
    <?php endforeach; }?>
</div>