jQuery.noConflict();

jQuery(document).ready(function($) {

	$("div#wpPicasaPerex p.buttons a.reset").click(function() {
		$("#wpPicasaPerex img#wpPicasaPerexImage").attr("src", '');
		$("#wpPicasaPerex input#wpEspritPicasaPerexUrl").attr("value", '');
		$("#wpPicasaPerex input#wpEspritPicasaPerexTitle").attr("value", '');
		$("#wpPicasaPerex textarea#wpEspritPicasaPerexDescription").attr("value", '');
	});

});
