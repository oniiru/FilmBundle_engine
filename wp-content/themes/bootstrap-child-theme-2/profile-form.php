<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/

$user_role = reset( $profileuser->roles );
if ( is_multisite() && empty( $user_role ) ) {
	$user_role = 'subscriber';
}

$user_can_edit = false;
foreach ( array( 'posts', 'pages' ) as $post_cap )
	$user_can_edit |= current_user_can( "edit_$post_cap" );
?>

<div class="login profile" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php $template->the_action_template_message( 'profile' ); ?>
	<?php $template->the_errors(); ?>
	<form id="your-profile" action="" method="post">
		<?php wp_nonce_field( 'update-user_' . $current_user->ID ) ?>
		<p>
			<input type="hidden" name="from" value="profile" />
			<input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>" />
		</p>

		<?php if ( !$theme_my_login->options->get_option( array( 'themed_profiles', $user_role, 'restrict_admin' ) ) && !has_action( 'personal_options' ) ): ?>

		<h3><?php _e( 'Personal Options', 'theme-my-login' ); ?></h3>

		<table class="form-table">
		<?php if ( rich_edit_exists() && $user_can_edit ) : // don't bother showing the option if the editor has been removed ?>
		<tr>
			<th scope="row"><?php _e( 'Visual Editor', 'theme-my-login' )?></th>
			<td><label for="rich_editing"><input name="rich_editing" type="checkbox" id="rich_editing" value="false" <?php checked( 'false', $profileuser->rich_editing ); ?> /> <?php _e( 'Disable the visual editor when writing', 'theme-my-login' ); ?></label></td>
		</tr>
		<?php endif; ?>
		<?php if ( count( $_wp_admin_css_colors ) > 1 && has_action( 'admin_color_scheme_picker' ) ) : ?>
		<tr>
			<th scope="row"><?php _e( 'Admin Color Scheme', 'theme-my-login' )?></th>
			<td><?php do_action( 'admin_color_scheme_picker' ); ?></td>
		</tr>
		<?php
		endif; // $_wp_admin_css_colors
		if ( $user_can_edit ) : ?>
		<tr>
			<th scope="row"><?php _e( 'Keyboard Shortcuts', 'theme-my-login' ); ?></th>
			<td><label for="comment_shortcuts"><input type="checkbox" name="comment_shortcuts" id="comment_shortcuts" value="true" <?php if ( !empty( $profileuser->comment_shortcuts ) ) checked( 'true', $profileuser->comment_shortcuts ); ?> /> <?php _e( 'Enable keyboard shortcuts for comment moderation.', 'theme-my-login' ); ?></label> <?php _e( '<a href="http://codex.wordpress.org/Keyboard_Shortcuts" target="_blank">More information</a>', 'theme-my-login' ); ?></td>
		</tr>
		<?php endif; ?>
		<?php if ( function_exists( '_get_admin_bar_pref' ) ) : ?>
		<tr class="show-admin-bar">
			<?php if ( version_compare( $wp_version, '3.3', '>=' ) ) : ?>
			<th scope="row"><?php _e( 'Toolbar', 'theme-my-login' )?></th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><span><?php _e( 'Toolbar', 'theme-my-login' ) ?></span></legend>
					<label for="admin_bar_front">
						<input name="admin_bar_front" type="checkbox" id="admin_bar_front" value="1"<?php checked( _get_admin_bar_pref( 'front', $profileuser->ID ) ); ?> />
						<?php _e( 'Show Toolbar when viewing site', 'theme-my-login' ); ?>
					</label>
					<br />
				</fieldset>
			</td>
			<?php else : ?>
			<th scope="row"><?php _e( 'Show Admin Bar', 'theme-my-login' )?></th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><span><?php _e( 'Show Admin Bar', 'theme-my-login' ); ?></span></legend>
					<label for="admin_bar_front">
						<input name="admin_bar_front" type="checkbox" id="admin_bar_front" value="1" <?php checked( _get_admin_bar_pref( 'front', $profileuser->ID ) ); ?> />
						<?php /* translators: Show admin bar when viewing site */ _e( 'when viewing site', 'theme-my-login' ); ?>
					</label>
					<br />
					<label for="admin_bar_admin">
						<input name="admin_bar_admin" type="checkbox" id="admin_bar_admin" value="1" <?php checked( _get_admin_bar_pref( 'admin', $profileuser->ID ) ); ?> />
						<?php /* translators: Show admin bar in dashboard */ _e( 'in dashboard', 'theme-my-login' ); ?>
					</label>
				</fieldset>
			</td>
			<?php endif; ?>
		</tr>
		<?php endif; // function exists ?>
		<?php do_action( 'personal_options', $profileuser ); ?>
		</table>
		<?php endif; // restrict admin ?>

		<?php do_action( 'profile_personal_options', $profileuser ); ?>

		<table class="form-table">
		<tr>
			<th><label for="user_login"><?php _e( 'Username', 'theme-my-login' ); ?></label></th>
			<td><input type="text" name="user_login" id="user_login" value="<?php echo esc_attr( $profileuser->user_login ); ?>" disabled="disabled" class="regular-text" /></td>
		</tr>

		<tr>
			<th><label for="first_name"><?php _e( 'First name', 'theme-my-login' ) ?></label></th>
			<td><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $profileuser->first_name ) ?>" class="regular-text" /></td>
		</tr>

		<tr>
			<th><label for="last_name"><?php _e( 'Last name', 'theme-my-login' ) ?></label></th>
			<td><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $profileuser->last_name ) ?>" class="regular-text" /></td>
		</tr>

		</table>


		<table class="form-table">
		<tr>
			<th><label for="email"><?php _e( 'E-mail', 'theme-my-login' ); ?> <span class="description"><?php _e( '(required)', 'theme-my-login' ); ?></span></label></th>
			<td><input type="text" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ) ?>" class="regular-text" /></td>
		</tr>

		</table>

		<?php
		$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );
		if ( $show_password_fields ) :
		?>
		<tr id="password">
			<th><label for="pass1" class="passwordlabel"><?php _e( 'New Password', 'theme-my-login' ); ?></label> 
			</th>
			<td><input type="password" name="pass1" class="password1" id="pass1" size="16" value="" placeholder="Password" autocomplete="off" /><br />
				<input type="password" class="password1" name="pass2" id="pass2" size="16" placeholder="Confirm Password" value="" autocomplete="off" />
				<div id="pass-strength-result"><?php _e( 'Strength indicator', 'theme-my-login' ); ?></div>
			</td>
		</tr>
		<?php endif; ?>
		</table>

		<?php
			do_action( 'show_user_profile', $profileuser );
		?>

		<?php if ( count( $profileuser->caps ) > count( $profileuser->roles ) && apply_filters( 'additional_capabilities_display', true, $profileuser ) ) { ?>
		<br class="clear" />
			<table width="99%" style="border: none;" cellspacing="2" cellpadding="3" class="editform">
				<tr>
					<th scope="row"><?php _e( 'Additional Capabilities', 'theme-my-login' ) ?></th>
					<td><?php
					$output = '';
					global $wp_roles;
					foreach ( $profileuser->caps as $cap => $value ) {
						if ( !$wp_roles->is_role( $cap ) ) {
							if ( $output != '' )
								$output .= ', ';
							$output .= $value ? $cap : "Denied: {$cap}";
						}
					}
					echo $output;
					?></td>
				</tr>
			</table>
		<?php } ?>

		<p class="submit">
			<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
			<input type="submit" class="floatright btn btn-info" value="<?php esc_attr_e( 'Update Profile', 'theme-my-login' ); ?>" name="submit" />
		</p>
	</form>
</div>
