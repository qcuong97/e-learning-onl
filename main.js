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

$(document).on('click', '#btn-student-list', function() {
	url = document.URL + '/student-list';
	// dùng ajax để xóa lấy danh sách học viên
	$.ajax({
		url: url,
		type: 'get',
		// data: {
		// 	classID: classID,
		// 	creatorID : creatorID
		// },
	})
	.done(function(response) {
		let i = 1;
		console.log(response);
		// đổ dữ liệu ra bảng trong model danh sách học viên
		$(response).each(function() {
			let tr = '<tr><td>'+i+'</td><td>'+this.name+'</td><td><button class="out-class btn btn-danger" student-id="'+this.student_id+'" class-id="'+this.class_id+'">out class</button></td></tr>';
			i++;
			$('#student-list-body').append(tr);
		})
	})
})

// xóa học viên ra khỏi lớp học
$(document).on('click', '.out-class', function() {
	var obj = $(this);
	let studentID = $(this).attr('student-id')
	let classID = $(this).attr('class-id')
	// console.log(studentID + ':' + classID);
	url = document.URL + '/delete-student';
	$.ajax({
		url: url,
		type: 'POST',
		data: {
			classID: classID,
			studentID : studentID
		},
	})
	.done(function(response) {
		// gửi thành công lên server
		if(response.status) { //nếu server xóa học viên khỏi lớp thành công
			// xóa học viên trên giao diện modal
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

// sự kiện thêm học viên vào lớp học
$('#btn-add-student').on('click', function() {
	var email = $('input#student-email').val();
	var teacherID = $(this).attr('teacher-id');
	url = document.URL + '/add-student';
	$.ajax({
		url: url,
		type: 'POST',
		data: {
			email: email,
			teacherID : teacherID
		},
	})
	.done(function(response) {
		// gửi thành công lên server
		if(response.status) { //nếu server mời học viênthành công
			$('#add-student-modal').modal('toggle');
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

// sự kiện đồng ý cho học viên join vào lớp
$('.accept-request').on('click', function() {
	var obj = $(this);
	var requestID = $(this).attr('request-id')
	url = document.URL + '/accept-request';
	$.ajax({
		url: url,
		type: 'GET',
		data: {
			requestID: requestID
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


$('.edit-document').on('click', function() {
	$('#upload-document-modal input[name="description"]').val($(this).attr('description'))
	$('#upload-document-modal input[name="document_id"]').val($(this).attr('document-id'))
	$('#upload-document-modal input[name="classFile"]').prop('required', false)
	let temp = $('#upload-document-modal form').attr('action')
	let action = temp + 'edit-document'
	$('#upload-document-modal form').attr('action', action)
})
$('#add-document').on('click', function() {
	// add new document
	$('#upload-document-modal input[name="description"]').val()
	let temp = $('#upload-document-modal form').attr('action')
	let action = temp + 'upload'
	$('#upload-document-modal form').attr('action', action)
})
$('.delete-document').on('click', function() {
	var obj = $(this)
	Swal.fire({
	  title: 'Do you want to delete the document?',
	  showCancelButton: true,
	  confirmButtonText: `Delete`,
	}).then((result) => {
	  /* Read more about isConfirmed, isDenied below */
	  if (result.isConfirmed) {
	  	var documentID = $(this).attr('document-id');
		url = document.URL + '/delete-document';
	  	$.ajax({
			url: url,
			type: 'GET',
			data: {
				documentID: documentID
			},
		})
		.done(function(response) {
			// gửi thành công lên server
			if(response.status) { //nếu server mời học viênthành công
				// xóa document trên giao diện
				let deleteObj = $(obj).parent().parent();
				deleteObj.remove();
				//thông báo thành công
				Swal.fire('Deleted!', '', 'success')
			}
		})
	  }
	})
});

//add comment
$('.comment-form #comment-content').on('keypress', function (e) {
	// when press ENTER
	if(e.keyCode  == 13){
		let commentor = $('.comment-form .commentor').attr('commentor')
		let content = $('.comment-form #comment-content').val()
		let username = $('.comment-form .commentor').html()
		let url = document.URL + '/add-comment';
		console.log(content + username)
        $.ajax({
			url: url,
			type: 'POST',
			data: {
				commentor: commentor,
				content : content
			},
		})
		.done(function(response) {
			// gửi thành công lên server
			if(response.status) { //nếu server mời học viênthành công
				// xóa document trên giao diện
				let html = '<div class="comment-item row">'+
			            '<div class="col-lg-2 avatar-comment">'+
			                '<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7c/User_font_awesome.svg/512px-User_font_awesome.svg.png" alt="">'+
			                '<div class="commentor font-weight-bold">'+
			                	username+
			            	'</div></div>' +
			            '<div class="col-lg-10 content-comment">' +
			                '<textarea type="text" name="" id="" >' + content + '</textarea>'+
			                '<div class="action"><span>now </span>'+
			                    '<span class="text-danger delete-comment" comment-id="'+ response.id +'">Delete</span></div></div></div>'
			    $('hr#hr').after(html)
			    $('.comment-form #comment-content').val("")
				//thông báo thành công
				toastr.success(response.message);
			}
		})
    }
});

$(document).on('click', '.delete-comment', function() {
	var obj = $(this)
	Swal.fire({
	  title: 'Do you want to delete this comment?',
	  showCancelButton: true,
	  confirmButtonText: `Delete`,
	}).then((result) => {
	  /* Read more about isConfirmed, isDenied below */
	  if (result.isConfirmed) {
	  	var commentID = $(this).attr('comment-id');
		url = document.URL + '/delete-comment';
	  	$.ajax({
			url: url,
			type: 'GET',
			data: {
				commentID: commentID
			},
		})
		.done(function(response) {
			// gửi thành công lên server
			if(response.status) { //nếu server mời học viênthành công
				// xóa document trên giao diện
				let deleteObj = $(obj).parent().parent().parent();
				deleteObj.remove();
				//thông báo thành công
				Swal.fire('Deleted!', '', 'success')
			}
		})
	  }
	})
})

// fix lỗi đường dẫn khi submit trên modal
var route = window.location.href
$('#upload-document-modal').on('hidden.bs.modal', function (e) {
  	window.location.replace(route);
})