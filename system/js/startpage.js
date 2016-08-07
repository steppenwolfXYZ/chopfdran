

$(function() {
	$(".project_add").click(function() {
		id = $(this).attr("projectid");
		$.get('ajax.php?mode=project_add&projectid='+id, function(data, status) {
			console.log(data);
			location.reload();
		});
	});
});