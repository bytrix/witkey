$(function () {
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="dropdown"]').dropdown();
	$('.disabled-dropdown-item').add('.divider').click(function(event) {
		return false;
	})
})