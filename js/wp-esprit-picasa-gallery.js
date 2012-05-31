jQuery.noConflict();

function picasaAddPhoto(photoUrl, thumbUrl, photoTitle, photoDescription,
		postId) {
	var h = '<a href="' + photoUrl + '" rel="lightbox[' + postId + ']" title="'
			+ photoDescription + '">' + '<img src="' + thumbUrl + '" alt="'
			+ photoTitle + '" /></a>';

	var win = window.opener ? window.opener : window.dialogArguments;
	if (!win)
		win = top;
	tinyMCE = win.tinyMCE;
	if (typeof tinyMCE != 'undefined' && tinyMCE.getInstanceById('content')) {
		tinyMCE.selectedInstance.getWin().focus();
		tinyMCE.execCommand('mceInsertContent', false, h);
	} else
		win.edInsertContent(win.edCanvas, h);
	return false;
}

function picasaAddThumbnail(photoUrl, thumbUrl, photoTitle, photoDescription, postId)
{
}

// Put all your code in your document ready area
jQuery(document).ready(function($) {

	$("div.PicasaPhotos img").click(function() {
		$(this).fadeTo("slow", 0.33);
		//$("div#wpPicasaThumbnailForm img",win).attr("src", "http://picasaweb.google.com/ady.nasracky.cz/20090809_BethellsBeachFairyFalls#5367901829020338418");
		//$(top.document).find("#wpPicasaThumbnailForm img").attr("src", "http://lh5.ggpht.com/_N2K54pmV6ck/SnVEjw1EJ4I/AAAAAAAATQo/VPGlQyJ5rKo/s400/IMG_6037.JPG");
		$(this).fadeTo("slow", 1);
	});

	$("div.PicasaPhotos img.Thumbnail").click(function() {
		var picasaImageObject = picasaImagesArray[$(this).attr("name")];
		$(top.document).find("#wpPicasaPerex img#wpPicasaPerexImage").attr("src", picasaImageObject['linkPerex']);
		$(top.document).find("#wpPicasaPerex input#wpEspritPicasaPerexUrl").attr("value", picasaImageObject['linkPerex']);
		$(top.document).find("#wpPicasaPerex input#wpEspritPicasaPerexTitle").attr("value", $(this).attr("name"));
		$(top.document).find("#wpPicasaPerex textarea#wpEspritPicasaPerexDescription").attr("value", picasaImageObject['description']);
	});

});
