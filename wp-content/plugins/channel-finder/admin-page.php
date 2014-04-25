<?php 
	global $wpdb;
	global $cf;
	$wpdb->show_errors();

	$regions = $cf->getRegions();
	$providers = $cf->getProviders();
?>

<div class="wrap">
	<div id="options">
	</div>
	<hr>

	<div id="main" class="admin-page" style="display:block;">
		<h2>Channel Finder</h2>
		<hr>
		<?php
			foreach ($regions as $r) {
				$package = $cf->getPackagesByRegion($r->name); 
		?>
		<div id="region-<?php echo $r->id; ?>">
			<div class="title">
				<h3><?php echo $r->name; ?></h3>
				<div class="options-inline">
					<span class="modify-region small"><a onclick="cf.populate_region(<?php echo $r->id; ?>);" href="javascript:void(0);">Modify</a></span> | <span class="delete-region small red"><a onclick="cf.delete('delete_region', <?php echo $r->id; ?>);" href="javascript:void(0);">Delete</a></span>
				</div>
			</div>

			<table id="table-<?php echo $r->id; ?>" class="wp-list-table widefat" cellspacing="0">
				<thead>
					<tr>
						<th>Provider</th>
						<th>Cable Package</th>
						<th>Channels</th>
					</tr>
				</thead>

				<?php foreach($package as $p) { ?>
					<tr class="package-row" id="row-<?php echo $p->id; ?>">
						<td style="min-width:250px;min-height:50px;"><?php echo $p->provider_name; ?><div class="options-container">
								<div class="options">
									<span data-src="<?php echo $p->id; ?>" class="modify small"><a onclick="cf.populate_package(<?php echo $p->id; ?>);" href="javascript:void(0);">Modify</a></span> | 
									<span data-src="<?php echo $p->id; ?>" class="up small"><a onclick="cf.move('up', <?php echo $p->id; ?>);" href="javascript:void(0);">Move Up</a></span> | 
									<span data-src="<?php echo $p->id; ?>" class="down small"><a onclick="cf.move('down', <?php echo $p->id; ?>);" href="javascript:void(0);">Move Down</a></span> | 
									<span data-src="<?php echo $p->id; ?>" class="delete-package small red"><a onclick="cf.delete('delete_package', <?php echo $p->id; ?>);" href="javascript:void(0);">Delete</a></span>
								</div></div></td>
						<td><?php echo $p->cable_package; ?></td>
						<td><?php $channels = json_decode($p->channels); foreach($channels as $c) { echo $c ."</br>"; } ?></td>
					</tr>
				<?php } ?>
			</table>
		</div>
		<?php } ?>
	</div>

	<div id="create-region" class="admin-page" style="display:none;">
		<h2>Create Region</h2>
		<hr>
		<div>
			<label>Region Name:</label></br>
			<input type="text" id="create-region-region_name" name="create-region-region_name"></input>
		</div>
		<div style="margin-top:20px;">
			<button class="button" onclick="cf.create('create_region');">Create Region</button>
		</div>
	</div>

	<div id="create-package" class="admin-page" style="display:none;">
		<h2>Create Package</h2>
		<hr>
		<div>
			<label>Package Name:</label></br>
			<input type="text" id="create-package-cable_package" name="create-package-cable_package"></input>
		</div>
		<div>
			<label>Contact:</label></br>
			<input type="text" id="create-package-contact" name="create-package-contact"></input>
		</div>
		<div>
			<label>Website:</label></br>
			<input type="text" id="create-package-website" name="create-package-website"></input>
		</div>
		<div>
			<label>Channels:</label></br>
			<input type="text" id="create-package-channels" name="create-package-channels"></input>
		</br><span>Insert channels seperated by a comma. Example: "199HD,102SD,112HD"</span>
		</div>
		<div>
			<label>Provider:</label></br>
			<select id="create-package-provider" name="create-package-provider">
				<?php foreach ($providers as $p) { ?>
				<option value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
				<?php } ?>
			</select> 
		</div>

		<div id="create-package-regions">
			<?php foreach($regions as $r) { ?>
				<input style="margin-top:10px;" type="checkbox" id="create-package-<?php echo $r->id; ?>" name="create-package-<?php echo $r->id; ?>" value="<?php echo $r->id; ?>">
				<label for="create-package-<?php echo $r->id; ?>"><?php echo $r->name; ?></label>
			</br>
			<?php } ?>
		</div>

		<div style="margin-top:20px;">
			<button class="button" onclick="cf.create('create_package');">Create Package</button>
		</div>
	</div>

	<div id="create-provider" class="admin-page" style="display:none;">
		<h2>Create Provider</h2>
		<hr>
		<div>
			<label>Provider Name:</label></br>
			<input type="text" id="create-provider-provider_name" name="create-provider-provider_name"></input>
		</div>
		<div>
			<label>Provider Logo URL:</label></br>
			<input type="text" id="create-provider-provider_logo" name="create-provider-provider_logo"></input>
		</div>
		<div style="margin-top:20px;">
			<button class="button" onclick="cf.create('create_provider');">Create Provider</button>
		</div>
	</div>

	<div id="modify-package" class="admin-page" style="display:none;">
		<h2>Modify Package</h2>
		<hr>
		<input type="hidden" id="modify-package-region_id" value=""></input>
		<input type="hidden" id="modify-package-provider_id" value=""></input>
		<input type="hidden" id="modify-package-id" value=""></input>
		<div>
			<label>Package Name:</label></br>
			<input type="text" id="modify-package-cable_package" name="modify-package-cable_package"></input>
		</div>
		<div>
			<label>Contact:</label></br>
			<input type="text" id="modify-package-contact" name="modify-package-contact"></input>
		</div>
		<div>
			<label>Website:</label></br>
			<input type="text" id="modify-package-website" name="modify-package-website"></input>
		</div>
		<div>
			<label>Channels:</label></br>
			<input type="text" id="modify-package-channels" name="modify-package-channels"></input>
		</div>
		<div>
			<label>Provider:</label></br>
			<select id="modify-package-provider" name="modify-package-provider">
				<?php foreach ($providers as $p) { ?>
				<option value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
				<?php } ?>
			</select> 
		</div>
		<div style="margin-top:20px;">
			<button class="button" onclick="cf.modify('edit_package');">Modify</button>
		</div>
	</div>

	<div id="modify-region" class="admin-page" style="display:none;">
		<h2>Modify Region</h2>
		<hr>
		<input type="hidden" id="modify-region-region_id" value=""></input>
		<div>
			<label>Region Name:</label></br>
			<input type="text" id="modify-region-region_name" name="modify-region-region_name"></input>
		</div>
		<div style="margin-top:20px;">
			<button class="button" onclick="cf.modify('edit_region');">Modify Region</button>
		</div>
	</div>
</div>

<script>
	$ = jQuery.noConflict(true);
	var cf = new channelFinder();
	var pages = ["main", "create-region", "create-package"];
	var providers = <?php $cf->javify($providers); ?>;
	cf.init(providers, pages);
</script>