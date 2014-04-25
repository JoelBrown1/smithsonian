<?php
class channelFinder {
	// OTHER
	function javify($item) {
		$x = 0;
		$len = count($item);
		$return = "";

		foreach($item as $i) {
			if ($x == $len - 1) {
				$return .= '"'. $i->name .'"'; 
			} else {
				$return .= '"'. $i->name .'",'; 
			}

			$x++;
		}

		$return = "[". $return ."]";
		echo $return;
	}

	function getRegions() {
		global $wpdb;

		$table = $wpdb->prefix . "regions"; 
		$return = $wpdb->get_results("SELECT * FROM ". $table ." WHERE $table.visible='1'");

		return $return;
	}

	function getPackagesByRegion($region) {
		global $wpdb;

		$packages = $wpdb->prefix . "packages"; 
		$regions = $wpdb->prefix . "regions"; 
		$providers = $wpdb->prefix . "providers"; 

		$return = $wpdb->get_results(
			"SELECT `$packages`.`id`, `$packages`.`cable_package`, `$packages`.`contact`, `$packages`.`website`, `$packages`.`channels`, `$regions`.`name` AS `region_name`, `$providers`.`name` AS `provider_name`, `$providers`.`logo_url` ".
			"FROM $packages, $regions, $providers ".
			"WHERE `$packages`.`region_id` = `$regions`.`id` AND `$packages`.`provider_id` = `$providers`.`id` AND `$regions`.`name` = '$region' ".
			"ORDER BY `$packages`.`index` ASC");

		return $return;
	}

	function getProviders() {
		global $wpdb;

		$table = $wpdb->prefix . "providers"; 
		$return = $wpdb->get_results("SELECT * FROM ". $table);

		return $return;
	}
}
?>