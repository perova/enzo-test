<?php
	show_admin_bar(false);

	function main_style(){
		wp_enqueue_style("main_style", get_stylesheet_uri());
	}
		add_action("wp_enqueue_scripts", "main_style");
?>