$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

//biến user-id
var userID;
$('.btn-change').on('click', function() {
	//gán biến id cho giá trị cần thay đổi role
	userID = $(this).attr('data-id');
})

$('#save-user').on('click', function() {
	let role = $('#state').val();
	$.ajax({ //call ajax để gửi data lên server
		url: '/user/role',
		type : 'POST',
		data: {
			role: role,
			user: userID
		},
	})
	.done(function(response) {
		// gửi thành công lên server
		if(response.status) { //nếu server trả về kết quả thành công
			$('#modal-id').modal('toggle');
			//thông báo thành công
			toastr.success(response.message);
			window.location.href = "/user";
		} else { //nếu server trả về kết quả thất bại
			//thông báo thất bại
			toastr.error(response.message);
		}
	})
	.fail(function() { // gửi không thành công lên server
		//thông báo thất bại
		toastr.error(response.message);
	})
})