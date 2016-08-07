

$(function() {
	$(".project_add").click(function() {
		projectid = $(this).attr("projectid");
		$.get('ajax.php?mode=project_add&projectid='+projectid, function(data, status) {
			console.log(data);
			location.reload();
		});
	});
});