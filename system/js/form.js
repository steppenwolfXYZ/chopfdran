function setError(object, name, message) {
	object.next().addClass('errormark');
	object.next().children("p").append('<span class="errormessage"><br /><br />'+message+'</span>');
	object.addClass('error');
}

function resetError(object, name) {
	object.next().removeClass('errormark');
	object.next().children("p").children('span').remove();
	object.removeClass('error');
}

$(function() {
	$('form').on('submit', function(event) {
		event.preventDefault();
		data = ($('form').serialize());
		
		$.get("ajax.php?"+data, function(data, status) {
			console.log(data);
			message = JSON.parse(data);
			$.each(message, function(item, message) {
				resetError($("[name='"+item+"']"), item)
				if (message != 'ok') setError($("[name='"+item+"']"), item, message);
			});
			if (message['ok']) window.location.href = $('form').attr('action');
		});
	});
});