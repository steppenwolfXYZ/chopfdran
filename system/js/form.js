$(function() {
	$('form').on('submit', function(event) {
		event.preventDefault();
		data = ($('form').serialize());
		
		$("#js").load("../ajax.php?"+data);
	});
});