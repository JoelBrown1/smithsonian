var channelFinder = function() {
	this.providers = null;
	this.pages = null;
	this.breadcrumb = null;
	this.page = null;
};

channelFinder.prototype.init = function(providers, pages) {
	this.providers = providers;
	this.pages = pages;
	this.breadcrumb = new Array();
	this.page = "main";

	this.init_options();
};

channelFinder.prototype.navigate_to = function(pageID) {
	this.breadcrumb.push(this.page);

	if ($("#"+this.page).css("display") == "block") {
		$("#"+this.page).fadeToggle(400, function() {
			$("#"+pageID).fadeToggle(400, function() {}); 
		});
	}

	this.page = pageID;
	this.refresh_options();
};

channelFinder.prototype.back = function() {
	var self = this;

	if ($("#"+this.page).css("display") == "block") {
		$("#"+this.page).fadeToggle(400, function() {
			$("#"+self.breadcrumb[self.breadcrumb.length - 1]).fadeToggle(400, function() {
				self.page = self.breadcrumb[self.breadcrumb.length - 1];
				self.breadcrumb.splice(self.breadcrumb.length -1, 1);
				self.refresh_options();
			}); 
		});
	}
};

channelFinder.prototype.init_options = function() {
	var self = this;
	var btn = null;

	btn = document.createElement("button");
	btn.className = "button";
	btn.innerHTML = "Create Region";
	btn.onclick = function(e) { self.navigate_to("create-region"); };
	$("#options").append(btn);

	btn = document.createElement("button");
	btn.className = "button";
	btn.innerHTML = "Create Package";
	btn.onclick = function(e) { self.navigate_to("create-package"); };
	$("#options").append(btn);

	btn = document.createElement("button");
	btn.className = "button";
	btn.innerHTML = "Create Provider";
	btn.onclick = function(e) { self.navigate_to("create-provider"); };
	$("#options").append(btn);
};

channelFinder.prototype.refresh_options = function() {
	$("#options").html("");

	var self = this;
	var btn = null;

	if (this.breadcrumb.length > 0) {
		btn = document.createElement("button");
		btn.className = "button";
		btn.innerHTML = "Back";
		btn.onclick = function(e) { self.back(); };
		$("#options").append(btn);
	}

	if (this.page != "create-region") {
		btn = document.createElement("button");
		btn.className = "button";
		btn.innerHTML = "Create Region";
		btn.onclick = function(e) { self.navigate_to("create-region"); };
		$("#options").append(btn);
	}

	if (this.page != "create-package") {
		btn = document.createElement("button");
		btn.className = "button";
		btn.innerHTML = "Create Package";
		btn.onclick = function(e) { self.navigate_to("create-package"); };
		$("#options").append(btn);
	}

	if (this.page != 'create-provider') {
		btn = document.createElement("button");
		btn.className = "button";
		btn.innerHTML = "Create Provider";
		btn.onclick = function(e) { self.navigate_to("create-provider"); };
		$("#options").append(btn);
	}
};

channelFinder.prototype.delete = function(action, id) {
	$.post(
	    ajaxurl, 
	    {
	        'action': action,
	        'data': id
	    }, 
	    function(response){
	    	if (response) {
	    		switch(action) {
	    			case "delete_package":
	    				var row = "#row-"+id;
	    				$(row).fadeToggle(400, function() { $(this).remove(); });
	    			break;
	    			case "delete_region":
	    				$("#region-"+id).fadeToggle(400, function() { $(this).remove(); });
	    			break;
	    		}
	    	} else {
	    		alert("Delete Failed");
	    	}
	    }
	);
};



channelFinder.prototype.move = function(dir, id) {
	var row = "#row-"+id;
	var parent = "#"+$(row).parent().parent().attr("id");

	var previous = null;
	var next = null;

	$(parent +" > tbody > tr").each(function(index) {
		if (index + 1 !== $(parent +" > tbody > tr").length) {
			next = $(parent +" > tbody > tr").eq(index + 1);
		} else {
			next = null;
		}

		if ("#"+$(this).attr("id") == row) {
			switch (dir) {
				case "up":
					if (previous != null) { $(this).insertBefore(previous); }
				break;
				case "down":
					if (next != null) { $(this).insertAfter(next); }
				break;
			}
		}

		previous = this;
	});

	$(parent +" > tbody > tr").each(function(index) {
		var id = $(this).attr("id").split("-")[1];

		$.post(
		    ajaxurl, 
		    {
		        'action': 'set_index',
		        'id': ""+id,
		        'index': ""+index
		    }, 
		    function(response){
		    	if (response) {
		    	} else {
		    		alert("Move Failed");
		    	}
		    }
		);
	});
};

channelFinder.prototype.populate_package = function(id) {
	var self = this;

	$.post(
		    ajaxurl, 
		    {
		        'action': 'get_package',
		        'id': id,
		    }, 
		    function(response){
		    	var data = JSON.parse(response);

		    	var channels = JSON.parse(data[0]["channels"]);
		    	var channels_string = "";

		    	for (var i = 0; i < channels.length; i++) {
		    		if (i < channels.length - 1) {
		    			channels_string += channels[i]+",";
		    		} else {
		    			channels_string += channels[i];
		    		}
		    	}

		    	$("#modify-package-region_id").attr("value", data[0]["region_id"]);
		    	$("#modify-package-provider_id").attr("value", data[0]["provider_id"]);
		    	$("#modify-package-id").attr("value", data[0]["id"]);
		    	$("#modify-package-cable_package").attr("value", data[0]["cable_package"]);
		    	$("#modify-package-channels").attr("value", channels_string);
		    	$("#modify-package-contact").attr("value", data[0]["contact"]);
		    	$("#modify-package-website").attr("value", data[0]["website"]);
		    	$("#modify-package-provider").attr("value", data[0]["provider_id"]);

		    	self.navigate_to("modify-package");
		    }
		);
};

channelFinder.prototype.populate_region = function(id) {
	var self = this;

	$.post(
		    ajaxurl, 
		    {
		        'action': 'get_region',
		        'id': id,
		    }, 
		    function(response){
		    	var data = JSON.parse(response);

		    	$("#modify-region-region_id").attr("value", data[0]["id"]);
		    	$("#modify-region-region_name").attr("value", data[0]["name"]);
		    	self.navigate_to("modify-region");
		    }
		);
};

channelFinder.prototype.create = function(type) {
	var post_data = {};
	var validation = true;

	switch(type) {
		case "create_region":
			var region_name = $("#create-region-region_name").attr("value");

			post_data = {
				'action': type,
				'region_name': region_name
			}

			if (region_name == "") { validation = false; }
		break;
		case "create_package":
			var package_name = $("#create-package-cable_package").attr("value");
			var contact = $("#create-package-contact").attr("value");
			var website = $("#create-package-website").attr("value");
			var channels = $("#create-package-channels").attr("value");
			var provider = $("#create-package-provider").attr("value");
			var regions = Array();

			$('#create-package-regions > input[type=checkbox]').each(function () {
				if ($(this).is(":checked")) {
					regions.push($(this).attr("value"));
				}
			});

			regions = JSON.stringify(regions);

			post_data = {
				'action': type,
				'package_name': package_name,
				'contact': contact,
				'website': website,
				'channels': channels,
				'provider': provider,
				'regions': regions
			}
		break;
		case "create_provider":
			var provider_name = $("#create-provider-provider_name").attr("value");
			var provider_logo = $("#create-provider-provider_logo").attr("value");

			post_data = {
				'action': type,
				'provider_name': provider_name,
				'provider_logo': provider_logo
			}
		break;
	}

	if (validation) {
		$.post(
			ajaxurl, 
			post_data, 
			function(response){
				location.reload(true);
			}
		);
	} else {

	}
};

channelFinder.prototype.modify = function(type) {
	var post_data = {};
	var validation = true;

	switch(type) {
		case "edit_package":
			var id = $("#modify-package-id").attr("value");
			var package_name = $("#modify-package-cable_package").attr("value");
			var contact = $("#modify-package-contact").attr("value");
			var website = $("#modify-package-website").attr("value");
			var channels = JSON.stringify($("#modify-package-channels").attr("value").split(","));
			var region_id = $("#modify-package-region_id").attr("value");
			var provider = $("#modify-package-provider").attr("value");

			post_data = {
				'action': type,
				'id': id,
				'package_name': package_name,
				'contact': contact,
				'website': website,
				'channels': channels,
				'region_id': region_id,
				'provider': provider
			}
		break;
		case "edit_region":
			var id = $("#modify-region-region_id").attr("value");
			var region_name = $("#modify-region-region_name").attr("value");

			post_data = {
				'action': type,
				'id': id,
				'region_name': region_name
			}
		break;
	}

	if (validation) {
		$.post(
			ajaxurl, 
			post_data, 
			function(response){
				location.reload(true);
			}
		);
	} else {

	}
};