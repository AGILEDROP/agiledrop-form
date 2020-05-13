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
    <form action="#" method="post">
        <label for="<?php echo $field['id']; ?>"><?php echo $field['name']?></label>
        <?php if ( $field['type'] === 'textarea' ) :?>
            <textarea name="<?php echo $field['id'];?>" cols="24" rows="5" placeholder="<?php echo $field['placeholder']; ?>"></textarea>
         <?php else: ?>
            <input name="<?php echo $field['id'];?>" type="<?php echo $field['type'];?>" placeholder="<?php echo $field['placeholder'];?>">
         <?php endif; ?>
        <input type="hidden" name="field" value="<?php echo $field['id']; ?>">
        <input type="submit" name="delete" value="Delete" />
    </form>
    <?php endforeach; }?>
</div>

<?php
if ( isset( $_POST ) ) {
    if ( isset( $_POST['delete' ] ) ) {
        $field_id = $_POST['field'];
        $fields = get_option( 'agiledrop_form_fields_options' );
        foreach ( $fields as $key => $value ) {
            if ( $value['id'] === $field_id ) {
                unset($fields[$key]);
            }
        }
        $fields = array_values( $fields );
        $fields['delete'] = true;
        update_option( 'agiledrop_form_fields_options', $fields );
    }
}