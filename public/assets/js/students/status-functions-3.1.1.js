function showModalBeforeSubmission(value){
	if(value != -1){
		$('#status').val(value);
		$('#action').val(value);
	}

	if(value == 0){
		$('.modal-colored-header').addClass('bg-danger');
		$('#modal_text').text('Are you sure you want to terminate this student?');
	}else if(value == 2){
		$('.modal-colored-header').removeClass('bg-danger bg-primary');
		$('.modal-colored-header').addClass('bg-success');
		$('#modal_text').text('Are you sure you want to graduate this student?');
	}else if(value == 3){
		$('.modal-colored-header').addClass('bg-danger');
		$('#modal_text').text('Are you sure you want to keep this student on hold?');
	}else if(value == 4){
		$('.modal-colored-header').addClass('bg-danger');
		$('#modal_text').text('Are you sure you want to delete this student?');
	}else {
		$('.modal-colored-header').removeClass('bg-danger bg-success');
		$('.modal-colored-header').addClass('bg-primary');
		$('#modal_text').text('Are you sure you want to update this student?');
	}
}

function submitForm(){
	$('#update_student').submit();
}

function submitFormWithExecutive()
{
	let user_id = $('#user_id').val();

	if (user_id === "") {
		$('#user_id_error').show();
	} else {
		$('#user_id_error').hide();
		$('#update_student').submit();
	}
}

//    ============ its for attachment show ==========
function attachmentShow(id) {
	var fd = new FormData();
	fd.append("id", id);
	
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		   },
		url: "/attachment-show",
		type: "POST",
		data: fd,
		enctype: "multipart/form-data",
		processData: false,
		contentType: false,
		success: function (r) {
			$('#attachmentModal').modal('show');
			$(".populateDate").html(r);
		},
	});
}

function studentAttachmentDelete(id){
	var delete_url = $("#delt-" + id).attr('data-delete-route');
	var check = confirm('Are you sure');

	if (check == true) {
		$.ajax({
			type: 'DELETE',
			url: delete_url,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			   },
			dataType: 'json',
			success: function (response) {
				location.reload();
				if (response.success == true) {
					toastr.success(response.message, response.title);
				}  else {
					toastr.error(response.message, response.title);
				}
				location.reload();
			},
			error: function () {
			}
		});
	}
}

// image preview js
function attachmentValidation(value, sectionval) {
	var path = value.value;
	var extenstion = path.split(".").pop();
	if (
	  extenstion == "jpg" ||
	  extenstion == "bmp" ||
	  extenstion == "jpeg" ||
	  extenstion == "png" ||
	  extenstion == "gif" ||
	  extenstion == "webp"
	) {
	//   document.getElementById("image-preview-" + sectionval).src =
	// 	window.URL.createObjectURL(value.files[0]);
	  var filename = path
		.replace(/^.*[\\\/]/, "")
		.split(".")
		.slice(0, -1)
		.join(".");
	} else {
		Swal.fire({
			title: "Attachment",
			text: "File not supported. Kindly Upload the Image of below given extension",
			icon: "info"
		});
	}
  }

//    ============ its for roadMapDataSave ==========
function roadMapDataSave(start_date, completion_date, student_id, track_id, level_id) {
	var fd = new FormData();
	fd.append("start_date", start_date);
	fd.append("completion_date", completion_date);
	fd.append("student_id", student_id);
	fd.append("track_id", track_id);
	fd.append("level_id", level_id);
	
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		   },
		url: "/student-track-level-save",
		type: "POST",
		data: fd,
		enctype: "multipart/form-data",
		processData: false,
		contentType: false,
		success: function (r) {
			console.log(r);
			// location.reload();
            toastr.success(r);
		},
	});
}