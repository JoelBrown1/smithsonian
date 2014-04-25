<?php
/*
 * Plugin Name: Channel Finder
 * Description: Creates & manages the Channel Finder page.
 * Version: 1.0
 * Author: Blue Ant Media
 * License: GPL2
 */

include("channelFinder.class.php");
$cf = new channelFinder();

add_action('admin_menu', 'channel_menu');

add_action('wp_ajax_get_package', 'get_package');
add_action('wp_ajax_get_region', 'get_region');

add_action('wp_ajax_create_region', 'create_region');
add_action('wp_ajax_create_package', 'create_package');
add_action('wp_ajax_create_provider', 'create_provider');

add_action('wp_ajax_delete_region', 'delete_region');
add_action('wp_ajax_delete_package', 'delete_package');
add_action('wp_ajax_delete_provider', 'delete_provider');

add_action('wp_ajax_edit_region', 'edit_region');
add_action('wp_ajax_edit_package', 'edit_package');
add_action('wp_ajax_edit_provider', 'edit_provider');

add_action('wp_ajax_set_index', 'set_index');

register_activation_hook( __FILE__, 'channel_install');

function channel_install () {
   global $wpdb;
   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	$table_name = $wpdb->prefix . "regions"; 
	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		name text NOT NULL,
		visible int(11) DEFAULT 1,
		UNIQUE KEY id (id)
	);";
	dbDelta($sql);

	$wpdb->replace($table_name, array("id" => 1, "name" => "Alberta"));
	$wpdb->replace($table_name, array("id" => 2, "name" => "British Columbia"));
	$wpdb->replace($table_name, array("id" => 3, "name" => "Manitoba"));
	$wpdb->replace($table_name, array("id" => 4, "name" => "New Brunswick"));
	$wpdb->replace($table_name, array("id" => 5, "name" => "Newfoundland"));
	$wpdb->replace($table_name, array("id" => 6, "name" => "Northwest Territories"));
	$wpdb->replace($table_name, array("id" => 7, "name" => "Nova Scotia"));
	$wpdb->replace($table_name, array("id" => 8, "name" => "Ontario"));
	$wpdb->replace($table_name, array("id" => 9, "name" => "Prince Edward Island"));
	$wpdb->replace($table_name, array("id" => 10, "name" => "Quebec"));
	$wpdb->replace($table_name, array("id" => 11, "name" => "Saskatchewan"));
	$wpdb->replace($table_name, array("id" => 12, "name" => "Yukon"));

	$table_name = $wpdb->prefix . "providers"; 
	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		name text NOT NULL,
		logo_url text NOT NULL,
		UNIQUE KEY id (id)
	);";
	dbDelta($sql);

	$table_name = $wpdb->prefix . "packages"; 
	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		cable_package text NOT NULL,
		contact text NOT NULL,
		website text NOT NULL,
		channels text NOT NULL,
		region_id mediumint(9) NOT NULL,
		provider_id mediumint(9) NOT NULL,
		index int(11) DEFAULT 0,
		UNIQUE KEY id (id)
	);";
	dbDelta($sql);
}


// ADMIN PAGE
function channel_menu() {
	$admin = add_menu_page("Channel Finder", "Channel Finder", "manage_options", "channel-finder", "channel_page", null, null);
	add_action('admin_print_scripts-' . $admin, 'add_scripts');
	add_action('admin_print_styles-' . $admin, 'add_styles');
}

function channel_page() {
	include("admin-page.php");
}

function add_scripts() {
	wp_register_script('jquery', 'jquery-core');
	wp_register_script('jquery-ui', '//code.jquery.com/ui/1.10.3/jquery-ui.js', array('jquery'));
	wp_register_script('channel-finder', plugins_url('/channel-finder.js', __FILE__ ), array('jquery', 'jquery-ui'));

	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui');
	wp_enqueue_script('channel-finder');
}

function add_styles() {
	wp_register_style('channel-finder-css', plugins_url('/channel-finder/channel-finder.css'));
	wp_enqueue_style('channel-finder-css');
}

// DB CALLS
function get_package() {
	global $wpdb;

	$table = $wpdb->prefix . "packages"; 
	$return = $wpdb->get_results("SELECT `$table`.`id`, `$table`.`cable_package`, `$table`.`contact`, `$table`.`website`, `$table`.`channels`, `$table`.`region_id`, `$table`.`provider_id` FROM ". $table." WHERE `$table`.`id` = ".$_REQUEST["id"]);

	die(json_encode($return));
}

function get_region() {
	global $wpdb;

	$table = $wpdb->prefix . "regions"; 
	$return = $wpdb->get_results("SELECT `$table`.`id`, `$table`.`name` FROM ". $table." WHERE `$table`.`id` = ".$_REQUEST["id"]);

	die(json_encode($return));
}

function get_provider_by_name($name) {
	global $wpdb;
	$providers = $wpdb->prefix . "providers";
	$return = $wpdb->get_results("SELECT *  FROM ". $providers ." WHERE `$providers`.`name` = '".$name."'");

	return($return);
}

function create_region() {
	global $wpdb;

	if (isset($_REQUEST)) {
		$table = $wpdb->prefix . "regions";
		$wpdb->insert($table, 
			array(
					"name" => $_REQUEST["region_name"],
					"visible" => 1
				)
		);
	}
}

function create_package() {
	global $wpdb;

	if (isset($_REQUEST)) {
		$table = $wpdb->prefix . "packages";
		$regions = json_decode(stripslashes($_REQUEST["regions"]));
		$channels = explode(",", $_REQUEST["channels"]);
		$channels = json_encode($channels);

		foreach($regions as $r) {
			$wpdb->insert($table, 
				array(
						'cable_package' => $_REQUEST["package_name"],
						'contact' => $_REQUEST["contact"],
						'website' => $_REQUEST["website"],
						'channels' => $channels,
						'provider_id' => $_REQUEST["provider"],
						'region_id' => $r
					)
			);
		}
	}
}

function create_provider() {
	global $wpdb;

	if (isset($_REQUEST)) {
		$table = $wpdb->prefix . "providers";
		$wpdb->insert($table, 
			array(
					"name" => $_REQUEST["provider_name"],
					"logo_url" => $_REQUEST["provider_logo"]
				)
		);
	}
}

function delete_region() {
	global $wpdb;

	if (isset($_REQUEST)) {
		$table = $wpdb->prefix . "regions";

		$wpdb->update(
			$table, 
			array(
				"visible" => 0
			), 
			array(
				'id' => intval($_REQUEST["data"])
			)
		);

		die(true);
	} else {
		die(false);
	}
}

function delete_package() {
	global $wpdb;

	if (isset($_REQUEST)) {
		$table = $wpdb->prefix . "packages";
		$wpdb->delete($table, array("id" => $_REQUEST["data"]));
		die(true);
	} else {
		die(false);
	}
}

function edit_package() {
	global $wpdb;

	if (isset($_REQUEST)) {
		$table = $wpdb->prefix . "packages";

		if (isset($_REQUEST["id"])) {
			$wpdb->update(
				$table, 
				array(
					'cable_package' => $_REQUEST["package_name"],
					'contact' => $_REQUEST["contact"],
					'website' => $_REQUEST["website"],
					'channels' => stripslashes($_REQUEST["channels"]),
					'region_id' => intval($_REQUEST["region_id"]),
					'provider_id' => intval($_REQUEST["provider"])
				), 
				array(
					'id' => intval($_REQUEST["id"])
				)
			);

			die($_REQUEST["package_name"].", ".$provider[0]->id);
		}

		die(true);
	} else {
		die(false);
	}
}

function edit_region() {
	global $wpdb;

	if (isset($_REQUEST)) {
		$table = $wpdb->prefix . "regions";

		if (isset($_REQUEST["id"])) {
			$wpdb->update(
				$table, 
				array(
					"name" => $_REQUEST["region_name"]
				), 
				array(
					'id' => intval($_REQUEST["id"])
				)
			);
		}

		die(true);
	} else {
		die(false);
	}
}

function set_index() {
	global $wpdb;

	if (isset($_REQUEST)) {
		$table = $wpdb->prefix . "packages";

		if (isset($_REQUEST["id"])) {
			if (isset($_REQUEST["index"])) {
				$wpdb->update(
					$table, 
					array(
						'index' => intval($_REQUEST["index"])
					), 
					array(
						'id' => intval($_REQUEST["id"])
					)
				);
			}
		}

		die(true);
	} else {
		die(false);
	}
}