@extends('layouts.admin')
@section('css')
	<link rel="stylesheet" href="{{asset('../css/class_detail.css')}}">
@endsection
@section('content')
	<div class="row">
	  <div class="col-xs-12">
	    <div class="box">
	      <div class="row">
	      	<div class="col-lg-6">
	      		<div class="box-header">
			        <h3 class="box-title">Class name : {{$class->class_name}}</h3>
			        <h3 class="box-title">Class code : {{$class->class_code}}</h3>
			        <h3 class="box-title">Subject : {{$class->subject}}</h3>
			        <h3 class="box-title">Room : {{$class->room}}</h3>
			      </div>
	      	</div>
	      	<div class="col-lg-6 group-btn">
	      		@if(Auth::user()->role == 2 || Auth::user()->role == 1)
	      		{{-- <button class="btn btn-box-header">tét</button> --}}
	      		<a data-toggle="modal" href='#request-modal' class="btn btn-box-header btn-success" id="btn-student-list">
	      			Request Join <span class="badge badge-secondary">{{isset($sum) ? $sum : 0}}</span>
	      		</a>
	      		<a data-toggle="modal" href='#add-student-modal' class="btn btn-box-header btn-success">
	      			Add Student  &nbsp;<i class="fa fa-plus" aria-hidden="true"></i>
	      		</a>
	      		<a data-toggle="modal" href='#class-modal' class="btn btn-box-header btn-success" id="btn-student-list">
	      			Student List  &nbsp;<i class="fa fa-users" aria-hidden="true"></i>
	      		</a>
	      		@endif
	      	</div>
	      </div>
	      <div class="box-body">
	      	<div class="teacher-name">Teacher : <span class="name">{{$class->teacher_name}}</span></div>
	      	<hr>
	      	<div class="document-title">Document <i class="fa fa-file-text" aria-hidden="true"></i></div>
	      	<div class="document-list">
	      		@if(isset($documents) && count($documents) > 0)
	      		@foreach($documents as $item)
	      		<div class="document-item">
	      			<h5>description : {{$item->description}}</h5>
	      			<i class="fa fa-book" aria-hidden="true"></i><a href="{{asset('')}}download/{{$item->source}}" > {{$item->source}}</a>
	      			@if(Auth::user()->role == 1 || Auth::user()->role == 2)
	      			<div>
	      				<span>{{$item->updated_at}}</span>&nbsp;
	      				<a class="text-warning edit-document" data-toggle="modal" href='#upload-document-modal' 
	      					description="{{$item->description}}" document-id="{{$item->id}}">
	      					<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
	      				</a>
	      				&nbsp;<button class="text-danger delete-document" document-id="{{$item->id}}">
	      					<i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
	      			</div>
	      			@endif
	      		</div>
	      		@endforeach
	      		@endif
	      		@if(Auth::user()->id == 1 || Auth::user()->role == 2)
	      		<div class="document-item">
	      			<a data-toggle="modal" href='#upload-document-modal' class="btn btn-success" id="add-document">Add Document</a>
	      		</div>
	      		@endif
	      	</div>
	      	<hr>
	      	<div class="comment-section">
	      		<div class="document-title">Comment <i class="fa fa-comments" aria-hidden="true"></i></div>
	      		<div class="wrap-comment">
	      			<div class="comment-form row">
			            <div class="col-lg-2 avatar-comment">
			                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7c/User_font_awesome.svg/512px-User_font_awesome.svg.png" alt="">
			                <div class="commentor font-weight-bold" commentor="{{Auth::user()->id}}">
			                	@if(Auth::user()->role == 1 || Auth::user()->role == 2)
			                	<span class="admin">ADMIN</span>
			                	@endif
			                	{{Auth::user()->name}}
			                </div>
			            </div>
			            <div class="col-lg-10 content-comment">
			                <textarea type="text" name="" id="comment-content" placeholder="input your comment..."></textarea>
			            </div>
			        </div>
	      			<hr id="hr">
	      			@if(isset($comments))
	      			@foreach($comments as $item)
			        <div class="comment-item row">
			            <div class="col-lg-2 avatar-comment">
			                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7c/User_font_awesome.svg/512px-User_font_awesome.svg.png" alt="">
			                <div class="commentor font-weight-bold" commentor="{{$item->commentor}}">
			                	@if($item->role == 1 || $item->role == 2)
			                	<span class="admin">ADMIN</span>
			                	@endif
			                	{{$item->name}}
			            	</div>
			            </div>
			            <div class="col-lg-10 content-comment">
			                <textarea type="text" name="" id="" >{{$item->content}}</textarea>
			                <div class="action">
			                    <span>{{$item->created_at}}</span>
			                    @if(Auth::user()->role == 1 || Auth::user()->role == 2)
			                    <span class="text-danger delete-comment" comment-id="{{$item->id}}">Delete</span>
			                    @endif
			                </div>
			            </div>
			        </div>
			        @endforeach
			        @endif
			    </div>
	      	</div>
	       {{-- <div class="table-responsive">
	        <table class="table table-hover table-responsive">
	          <thead>
	            <tr>
	              <th>#</th>
	              <th>Class Name</th>
	              <th>Class Code</th>
	              <th>Subject</th>
	              <th>Room</th>
	              <th>Class Image</th>
	              <th>Action</th>
	            </tr>
	          </thead>
	          <tbody>
	           @if (isset($classrooms) && count($classrooms) > 0)
		           @foreach ($classrooms as $class)
		           <tr>
		           <td>{{$class->id}}</td>
		           <td>{{$class->class_name}}</td>
		           <td>{{$class->class_code}}</td>
		           <td>{{$class->subject}}</td>
		           <td>{{$class->room}}</td>
		           <td><img class="class-image" style="width: 50px; height: 50px;" src="{{ asset(\Storage::url($class->class_image)) }}"></td>
		           <td>
		           		@if(Auth::user()->role == 1 || Auth::user()->role == 2)
		            	<a data-toggle="modal" href='#class-modal' class="btn btn-warning btn-edit-class"
		            		class-id="{{$class->id}}" class-name="{{$class->class_name}}" subject="{{$class->subject}}" room="{{$class->room}}">Edit</a>
		             	<button class="btn btn-danger btn-delete-class" class-id="{{$class->id}}" creator-id="{{Auth::user()->id}}">Delete</button>
		             	@endif
		           </td>
		           </tr>
		          
		           @endforeach
	           @endif

	          </tbody>
	        </table>
	      </div> --}}

	      {{-- test new ui --}}
	      <div class="wrap">
	      	@if (isset($classrooms) && count($classrooms) > 0)
		           @foreach ($classrooms as $class)
	      	<div class="col-lg-2 col-md-4 class-item">
	      		<div class="body-class-img" style="background-image: url('{{ asset(\Storage::url($class->class_image)) }}');"></div>
	      		<div class="header-class">
	      			<h6>Class Name : {{$class->class_name}}</h6>
	      			<h6>Code : {{$class->class_code}}</h6>
	      			<h6>Room : {{$class->room}}</h6>
	      		</div>
	      		<h6 class="body-subject">Subject : {{$class->subject}}</h6>
	      		@if(Auth::user()->role == 1 || Auth::user()->role == 2)
	      		<div class="class-action">
	      			<a data-toggle="modal" href='#class-modal' class="btn btn-warning btn-edit-class"
	            		class-id="{{$class->id}}" class-name="{{$class->class_name}}" subject="{{$class->subject}}" room="{{$class->room}}">Edit</a>
	             	<button class="btn btn-danger btn-delete-class" class-id="{{$class->id}}" creator-id="{{Auth::user()->id}}">Delete</button>
	      		</div>
	      		@endif
	      	</div>
	      	@endforeach
	           @endif
	      </div>
	    </div>
	  </div>
	</div>
	</div>

	{{-- modal xem danh sách học viên --}}
	<div class="modal fade" id="class-modal">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title">Student List</h4>
	      </div>
	      <div class="modal-body">
	        <div class="table-responsive">
		        <table class="table table-hover table-responsive">
		          <thead>
		            <tr>
		              <th>Index</th>
		              <th>Student Name</th>
		              <th>Action</th>
		            </tr>
		          </thead>
		          <tbody id="student-list-body"></tbody>
		        </table>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary btn-save" id="" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	{{-- modal xác nhận yêu cầu tham gia từ học viên --}}
	<div class="modal fade" id="request-modal">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title">Invitation List</h4>
	      </div>
	      <div class="modal-body">
	        <div class="table-responsive">
		        <table class="table table-hover table-responsive">
		          <thead>
		            <tr>
		              <th>Index</th>
		              <th>Student Name</th>
		              <th>Action</th>
		            </tr>
		          </thead>
		          <tbody id="student-list-body">
		          	@if(isset($data))
		          		@foreach($data as $value)
		          		<tr>
		          			<td>{{$value->student_id}}</td>
		          			<td>{{$value->name}}</td>
		          			<td><button request-id="{{$value->id}}" class="btn btn-success accept-request">Accept</button></td>
		          		</tr>
		          		@endforeach
		          	@endif
		          </tbody>
		        </table>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary btn-save" id="" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	{{-- modal thêm học viên --}}
	<div class="modal fade" id="add-student-modal">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title">Add student to classroom</h4>
	      </div>
	      <div class="modal-body">
	        <div>Enter the student's mail to add to classroom</div>
	        <input type="text" class="form-control" id="student-email">
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary btn-danger" id="" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary btn-success" id="btn-add-student" teacher-id="{{Auth::user()->id}}">Add</button>
	      </div>
	    </div>
	  </div>
	</div>

	{{-- modal upload tài liệu --}}
	<div class="modal fade" id="upload-document-modal">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title">Upload Document</h4>
	      </div>
	      <form method="POST" action="{{asset('')}}my-class/{{$class->id}}/" enctype="multipart/form-data">
	      	{{-- add new document : action + upload --}}
	      	{{-- edit document : action + edit-document --}}
	      <div class="modal-body">
	        @csrf
	        	<input type="hidden" name="document_id" value="">
	        	<label>Description</label>
	        	<input type="text" class="form-control" id="" name="description" required="required">
	        	<label>Document File</label>
	        	<input type="file" class="form-control-file" id="" name="classFile" required>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary btn-save" id="">{{__('dict.action.save')}}</button>
	      </div>
	    </div>
	    </form>
	  </div>
	</div>
@endsection

@section('foot')
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script src="{{asset('')}}js/class_detail.js"></script>
@endsection