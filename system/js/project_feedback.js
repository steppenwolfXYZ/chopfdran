$(function() {

	$(".feedback_slider").slider({
		ticks: [-2,-1,0,1,2],
		formatter: function(value) {
			switch (value) {
				case -2:
					return "Nie wieder";
				case -1:
					return "Eher nicht";
				case 0:
					return "Neutral";
				case 1:
					return "Gerne wieder";
				case 2:
					return "War der Wahnsinn";
			}
		},
		ticks_snap_bounds: 1,
		tooltip: 'always'
	});
	
	$('form').on('submit', function(event) {
		event.preventDefault();
		data = ($('form').serialize());
		
		$.get("/chopfdran/ajax.php?"+data, function(data, status) {
			console.log(data);
			window.location.href = $('form').attr('action');
		});
	});

});