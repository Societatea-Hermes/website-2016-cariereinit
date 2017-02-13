function login() {
	$.ajax({
		url: '/api/login',
		type: 'POST',
		data: {
			username: $('#username').val(),
			password: $('#password').val()
		},
		success: function(response) {
			if(response.success == 1) {
				location.reload();
			} else {
				alert(response.message);
			}
		}
	});
}
