<?php
/**
 * Navigation Menu API: Walker_Nav_Menu_Edit class
 *
 * @package    WordPress
 * @subpackage Administration
 * @since      4.4.0
 */

/**
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since   3.0.0
 * @uses    Walker_Nav_Menu
 */
class Insight_Walker_Nav_Menu_Edit extends Walker_Nav_Menu {

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see   Walker_Nav_Menu::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see   Walker_Nav_Menu::end_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
	}

	/**
	 * Start the element output.
	 *
	 * @see   Walker_Nav_Menu::start_el()
	 * @since 3.0.0
	 *
	 * @global int   $_wp_nav_menu_max_depth
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 * @param int    $id     Not used.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $_wp_nav_menu_max_depth;
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		ob_start();
		$item_id      = esc_attr( $item->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);

		$original_title = '';
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			if ( is_wp_error( $original_title ) ) {
				$original_title = false;
			}
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			$original_title  = get_the_title( $original_object->ID );
		} elseif ( 'post_type_archive' == $item->type ) {
			$original_object = get_post_type_object( $item->object );
			if ( $original_object ) {
				$original_title = $original_object->labels->archives;
			}
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive' ),
		);

		$title = $item->title;

		if ( ! empty( $item->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( esc_html__( '%s (Invalid)', 'tm-moody' ), $item->title );
		} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( esc_html__( '%s (Pending)', 'tm-moody' ), $item->title );
		}

		$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

		$submenu_text = '';
		if ( 0 == $depth ) {
			$submenu_text = 'style="display: none;"';
		}

		?>
	<li id="menu-item-<?php echo esc_attr( $item_id ); ?>" class="<?php echo implode( ' ', $classes ); ?>">
		<div class="menu-item-bar">
			<div class="menu-item-handle">
				<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span
						class="is-submenu" <?php echo '' . $submenu_text; ?>><?php esc_html_e( 'sub item', 'tm-moody' ); ?></span></span>
				<span class="item-controls">
						<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
							echo wp_nonce_url( add_query_arg( array(
								'action'    => 'move-up-menu-item',
								'menu-item' => $item_id,
							), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ), 'move-menu_item' );
							?>" class="item-move-up"
							   aria-label="<?php esc_attr_e( 'Move up', 'tm-moody' ) ?>">&#8593;</a>
							|
							<a href="<?php
							echo wp_nonce_url( add_query_arg( array(
								'action'    => 'move-down-menu-item',
								'menu-item' => $item_id,
							), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ), 'move-menu_item' );
							?>" class="item-move-down" aria-label="<?php esc_attr_e( 'Move down', 'tm-moody' ) ?>">&#8595;</a>
						</span>
						<a class="item-edit" id="edit-<?php echo esc_attr( $item_id ); ?>" href="<?php
						echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
						?>"
						   aria-label="<?php esc_attr_e( 'Edit menu item', 'tm-moody' ); ?>"><?php esc_html_e( 'Edit', 'tm-moody' ); ?></a>
					</span>
			</div>
		</div>

		<div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo esc_attr( $item_id ); ?>">
			<?php if ( 'custom' == $item->type ) : ?>
				<p class="field-url description description-wide">
					<label for="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'URL', 'tm-moody' ); ?><br/>
						<input type="text" id="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>"
						       class="widefat code edit-menu-item-url"
						       name="menu-item-url[<?php echo esc_attr( $item_id ); ?>]"
						       value="<?php echo esc_attr( $item->url ); ?>"/>
					</label>
				</p>
			<?php endif; ?>
			<p class="description description-wide">
				<label for="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e( 'Navigation Label', 'tm-moody' ); ?><br/>
					<input type="text" id="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>"
					       class="widefat edit-menu-item-title"
					       name="menu-item-title[<?php echo esc_attr( $item_id ); ?>]"
					       value="<?php echo esc_attr( $item->title ); ?>"/>
				</label>
			</p>
			<p class="field-title-attribute field-attr-title description description-wide">
				<label for="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e( 'Title Attribute', 'tm-moody' ); ?><br/>
					<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>"
					       class="widefat edit-menu-item-attr-title"
					       name="menu-item-attr-title[<?php echo esc_attr( $item_id ); ?>]"
					       value="<?php echo esc_attr( $item->post_excerpt ); ?>"/>
				</label>
			</p>
			<p class="field-link-target description">
				<label for="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>">
					<input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>" value="_blank"
					       name="menu-item-target[<?php echo esc_attr( $item_id ); ?>]"<?php checked( $item->target, '_blank' ); ?> />
					<?php esc_html_e( 'Open link in a new tab', 'tm-moody' ); ?>
				</label>
			</p>
			<p class="field-css-classes description description-thin">
				<label for="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e( 'CSS Classes (optional)', 'tm-moody' ); ?><br/>
					<input type="text" id="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>"
					       class="widefat code edit-menu-item-classes"
					       name="menu-item-classes[<?php echo esc_attr( $item_id ); ?>]"
					       value="<?php echo esc_attr( implode( ' ', $item->classes ) ); ?>"/>
				</label>
			</p>
			<p class="field-xfn description description-thin">
				<label for="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e( 'Link Relationship (XFN)', 'tm-moody' ); ?><br/>
					<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>"
					       class="widefat code edit-menu-item-xfn"
					       name="menu-item-xfn[<?php echo esc_attr( $item_id ); ?>]"
					       value="<?php echo esc_attr( $item->xfn ); ?>"/>
				</label>
			</p>
			<p class="field-description description description-wide">
				<label for="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e( 'Description', 'tm-moody' ); ?><br/>
					<textarea id="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>"
					          class="widefat edit-menu-item-description" rows="3" cols="20"
					          name="menu-item-description[<?php echo esc_attr( $item_id ); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
					<span
						class="description"><?php esc_html_e( 'The description will be displayed in the menu if the current theme supports it.', 'tm-moody' ); ?></span>
				</label>
			</p>

			<?php // Begin extra custom fields here. ?>
			<p class="field-feature description">
				<label for="edit-menu-item-feature-<?php echo esc_attr( $item_id ); ?>">
					<input type="checkbox" id="edit-menu-item-feature-<?php echo esc_attr( $item_id ); ?>" value="1"
					       name="menu-item-feature[<?php echo esc_attr( $item_id ); ?>]" <?php checked( $item->feature, '1' ); ?> />
					<?php esc_html_e( 'Mark this item as feature item', 'tm-moody' ); ?>
				</label>
			</p>
			<p class="field-image-hover description description-wide">
				<label
					for="edit-menu-item-image-hover-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Image on hover', 'tm-moody' ); ?></label>
				<div class="kungfu-attach-wrap">
					<div class="kungfu-media-image">
						<?php if ( $item->image_hover ) : ?>
							<img src="<?php echo esc_url( $item->image_hover_url ); ?>"
							     alt="<?php esc_attr__( 'Image Hover', 'tm-moody' ) ?>">
						<?php endif; ?>
					</div>
			<p>
				<input type="hidden" class="kungfu-media"
				       name="menu-item-image_hover[<?php echo esc_attr( $item_id ); ?>]"
				       value="<?php echo esc_attr( $item->image_hover ); ?>"/>
			</p>
			<a class="kungfu-media-open kungfu-button success">
				<i class="fa fa-upload"></i><?php esc_html_e( 'Upload', 'tm-moody' ); ?>
			</a>
			<a class="kungfu-media-remove kungfu-button danger"
				<?php if ( ! $item->image_hover ) : ?>
					style="display:none"
				<?php endif; ?>
			>
				<i class="fa fa-trash-o"></i><?php esc_html_e( 'Remove', 'tm-moody' ); ?>
			</a>
		</div>
		</p>
		<?php // End extra custom fields here. ?>

		<p class="field-move hide-if-no-js description description-wide">
			<label>
				<span><?php esc_html_e( 'Move', 'tm-moody' ); ?></span>
				<a href="#" class="menus-move menus-move-up"
				   data-dir="up"><?php esc_html_e( 'Up one', 'tm-moody' ); ?></a>
				<a href="#" class="menus-move menus-move-down"
				   data-dir="down"><?php esc_html_e( 'Down one', 'tm-moody' ); ?></a>
				<a href="#" class="menus-move menus-move-left" data-dir="left"></a>
				<a href="#" class="menus-move menus-move-right" data-dir="right"></a>
				<a href="#" class="menus-move menus-move-top"
				   data-dir="top"><?php esc_html_e( 'To the top', 'tm-moody' ); ?></a>
			</label>
		</p>

		<div class="menu-item-actions description-wide submitbox">
			<?php if ( 'custom' != $item->type && $original_title !== false ) : ?>
				<p class="link-to-original">
					<?php printf( esc_html__( 'Original: %s', 'tm-moody' ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
				</p>
			<?php endif; ?>
			<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr( $item_id ); ?>" href="<?php
			echo wp_nonce_url( add_query_arg( array(
				'action'    => 'delete-menu-item',
				'menu-item' => $item_id,
			), admin_url( 'nav-menus.php' ) ), 'delete-menu_item_' . $item_id ); ?>"><?php esc_html_e( 'Remove', 'tm-moody' ); ?></a>
			<span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js"
			                                                   id="cancel-<?php echo esc_attr( $item_id ); ?>"
			                                                   href="<?php echo esc_url( add_query_arg( array(
				                                                   'edit-menu-item' => $item_id,
				                                                   'cancel'         => time(),
			                                                   ), admin_url( 'nav-menus.php' ) ) );
			                                                   ?>#menu-item-settings-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Cancel', 'tm-moody' ); ?></a>
		</div>

		<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr( $item_id ); ?>]"
		       value="<?php echo esc_attr( $item_id ); ?>"/>
		<input class="menu-item-data-object-id" type="hidden"
		       name="menu-item-object-id[<?php echo esc_attr( $item_id ); ?>]"
		       value="<?php echo esc_attr( $item->object_id ); ?>"/>
		<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr( $item_id ); ?>]"
		       value="<?php echo esc_attr( $item->object ); ?>"/>
		<input class="menu-item-data-parent-id" type="hidden"
		       name="menu-item-parent-id[<?php echo esc_attr( $item_id ); ?>]"
		       value="<?php echo esc_attr( $item->menu_item_parent ); ?>"/>
		<input class="menu-item-data-position" type="hidden"
		       name="menu-item-position[<?php echo esc_attr( $item_id ); ?>]"
		       value="<?php echo esc_attr( $item->menu_order ); ?>"/>
		<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr( $item_id ); ?>]"
		       value="<?php echo esc_attr( $item->type ); ?>"/>
		</div><!-- .menu-item-settings-->
		<ul class="menu-item-transport"></ul>
		<?php
		$output .= ob_get_clean();
	}

} // Walker_Nav_Menu_Edit.