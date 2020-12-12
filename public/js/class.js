$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

// khi click vào button edit class
$('.btn-edit-class').on('click', function() {
	// lấy các thuộc tính của lớp được gán trong thuộc tính của button edit
	let classID = $(this).attr('class-id')
	let className = $(this).attr('class-name')
	let subject = $(this).attr('subject')
	let room = $(this).attr('room')
	// gán data của class vào modal chỉnh sửa class
	$('#class-modal input[name="classID"]').val(classID)
	$('#class-modal input[name="className"]').val(className)
	$('#class-modal input[name="classRoom"]').val(room)
	$('#class-modal input[name="subject"]').val(subject)
	$('#class-modal input[name="classFile"]').attr('required', false)
})

// khi click vào button delete
$('.btn-delete-class').on('click', function() {
	//lấy id người tạo class để check người tạo trên server
	let classID = $(this).attr('class-id')
	let creatorID = $(this).attr('creator-id')
	// dùng ajax để xóa class
	$.ajax({
		url: '/class/delete',
		type: 'POST',
		data: {
			classID: classID,
			creatorID : creatorID
		},
	})
	.done(function(response) {
		// gửi thành công lên server
		if(response.status) { //nếu server trả về kết quả thành công
			$('#modal-id').modal('toggle');
			//thông báo thành công
			toastr.success(response.message);
			window.location.href = "/class";
		} else { //nếu server trả về kết quả thất bại
			//thông báo thất bại
			toastr.error(response.message);
		}
	})
	.fail(function() {
		//thông báo thất bại
		toastr.error(response.message);
	})
})

$('#btn-join').on('click', function() {
	$('#input-class-code').removeClass('hidden')
	$('#join-class').removeClass('hidden')
})

//join classroom
$('#join-class').on('click', function() {
	let code = $('#input-class-code').val();
	if (code == '') {
		let error = '<span class="text-danger">Class code is not empty, Please!</span>'
		$('.join-class').append(error);
	} else {
		let obj = $('.join-class').find('span.text-danger')
		obj.remove()
		//call ajax để tham gia lớp học
		$.ajax({
			url: '/my-class/request',
			type: 'POST',
			data: {
				code: code,
			},
		})
		.done(function(response) {
			// gửi thành công lên server
			if(response.status) { //nếu server trả về kết quả thành công
				$('#modal-id').modal('toggle');
				//thông báo thành công
				toastr.success(response.message);
			} else { //nếu server trả về kết quả thất bại
				//thông báo thất bại
				toastr.error(response.message);
			}
		})
		.fail(function() {
			//thông báo thất bại
			toastr.error(response.message);
		})
	}
})

$('.accept-invite').on('click', function() {
	// đồng ý join vào lớp
	var obj = $(this);
	var inviteID = $(this).attr('invite-id')
	var classID = $(this).attr('class-id')
	var teacherID = $(this).attr('teacher-id')
	// url = document.URL + '/accept-invite';
	url = 'my-class/accept-invite';
	$.ajax({
		url: url,
		type: 'POST',
		data: {
			inviteID: inviteID,
			classID: classID,
			teacherID: teacherID
		},
	})
	.done(function(response) {
		// gửi thành công lên server
		if(response.status) { //nếu server mời học viênthành công
			// xóa request cua học viên trên giao diện modal
			let deleteObj = $(obj).parent().parent();
			deleteObj.remove();
			//thông báo thành công
			toastr.success(response.message);
		} else { //nếu server trả về kết quả thất bại
			//thông báo thất bại
			toastr.error(response.message);
		}
	})
	.fail(function() {
		//thông báo thất bại
		toastr.error(response.message);
	})
})