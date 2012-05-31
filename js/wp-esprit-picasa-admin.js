jQuery.noConflict();

jQuery(document).ready(function($){
  function processTestCall(status) {
    if (status=='OK') 
    {
      $("#TestResult").css("color","green");
      $("#TestResult").html("Seems OK! Don't forget to save the settings.");
    }
    else 
    {
      $("#TestResult").css("color","red");
      $("#TestResult").html("Error when connecting! Check the settings and try again.");
    } 

    $("p.submit img.AjaxLoader").hide();
    $("input").removeAttr("disabled");
  }

	$("#TestButton").click(function(e) {
		e.preventDefault();
		$("input").attr("disabled", "true");
		$("p.submit img.AjaxLoader").show();
		$("#TestResult").css("color","black");
		$("#TestResult").html(
			    "Trying to connect to given Picasa user albums..."
		);

    $.ajax({
      type: 'GET',
      url: pluginDirectoryPath + '/wp-esprit-picasa-test.php',
      data: {
        username: $("#PicasaUsername").val(),
        server: $("#PicasaServer").val(),
        type: "rpc"
      },
      success: function(xml) {
        processTestCall($("status",xml).text());
      },
      error: function() {
        processTestCall("ERROR");
      },
      dataType: "xml"
    });
	});
});
