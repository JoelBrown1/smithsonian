			ddaccordion.init({
			headerclass: "province", //Shared CSS class name of headers group
			contentclass: "mobile-package-details", //Shared CSS class name of contents group
			collapseprev: true, //Collapse previous content (so only one open at any time)? true/false
			defaultexpanded: [], //index of content(s) open by default [index1, index2, etc]. [] denotes no content.
			onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
			animatedefault: false, //Should contents open by default be animated into view?
			persiststate: false, //persist state of opened contents within browser session?
			toggleclass: ["closed", "open"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
			togglehtml: ["prefix", "<img src='../wp-content/themes/smithsonianchannel/images/arrow-down.png' align='right' /> ", "<img src='../wp-content/themes/smithsonianchannel/images/arrow-up.png' align='right' /> "],
			animatespeed: "fast", //speed of animation: "fast", "normal", or "slow"
			scrolltoheader: true
			})