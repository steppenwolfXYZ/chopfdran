var instrumentationHtml;
var instObj;
var count = 1;

$(function() {
	instObj = $("#additionalInstrumentation");
	instrumentationHtml = instObj.html();
	instObj.html('');
	instObj.show();
	$(".instrumentSelect").change(generateSelfBoxes);
	
	$("#add_instrument").click(function() {
		count ++;
		instObj.append(instrumentationHtml);
		$("[for='instrumentationDummy']").attr('for', 'instrument['+count+']');
		$("[name='instrumentationDummy']").attr('name', 'instrument['+count+']');
		$(".dummy").slideDown();
		$(".dummy").removeClass("dummy");
		$(".instrumentSelect").unbind("change");
		$(".instrumentSelect").change(generateSelfBoxes);
	});
});

function generateSelfBoxes() {
	var instrumentList = '';
	for (i=1; i<=count; i++) {
		instrumentId = $("[name='instrument["+i+"]']").val();
		instrumentList += instrumentId + ',';
	}
	instrumentList = instrumentList.substring(0, instrumentList.length - 1);
	$.get("/chopfdran/ajax.php?mode=get_self_boxes&instruments="+instrumentList, function(data, status) {
		console.log(data);
		$("#ownInstrument").html(data);
	});
}