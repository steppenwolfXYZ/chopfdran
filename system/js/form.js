function setError(object, name, message) {
	if (name == 'ownInstrument' || name == 'datetime') {
		object = $("#"+name);
	}
	object.next().addClass('errormark');
	object.next().children("p").append('<span class="errormessage"><br /><br />'+message+'</span>');
	object.addClass('error');
}

function resetError(object, name) {
	if (name == 'ownInstrument' || name == 'datetime') {
		object = $("#"+name);
	}
	object.next().removeClass('errormark');
	object.next().children("p").children('span').remove();
	object.removeClass('error');
}

$(function() {
	$('form').on('submit', function(event) {
		event.preventDefault();
		data = ($('form').serialize());
		
		$.get("/chopfdran/ajax.php?"+data, function(data, status) {
			console.log(data);
			message = JSON.parse(data);
			$.each(message, function(item, message) {
				resetError($("[name='"+item+"']"), item)
				if (message != 'ok') setError($("[name='"+item+"']"), item, message);
			});
			if (message['ok']) window.location.href = $('form').attr('action');
		});
	});
	
	var maxLength = 1000;
	$('textarea').keyup(function() {
		var length = $(this).val().length;
		var length = maxLength-length;
		$('#chars').text(length);
	});
	
	$('#datetimepicker').datetimepicker({
		locale: 'de',
		sideBySide: true
	});

});