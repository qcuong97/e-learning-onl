@extends('layouts.admin')
@section('css')
	<link rel="stylesheet" href="{{asset('../css/class.css')}}">
@endsection
@section('content')
	<div class="row">
	  <div class="col-xs-12">
	    <div class="box">
	      <div class="box-header text-center">
	        <h3 class="box-title font-weight-bold p-1 font-30">
	        	{{__('dict.class.my_class')}}
	        	@if(Auth::user()->role == 3)
	        	<a data-toggle="modal" href='#invite-modal' class="btn btn-success">
	       			<i class="fa fa-bell" aria-hidden="true"></i> Class invitations
	       			@if(isset($invitations))
	       			<span class="badge badge-secondary">{{$invitations}}</span>
	       			@else
	       			<span class="badge badge-secondary">0</span>
	       			@endif
	       		</a>
	       		@endif
	        </h3>
	      </div>
	      <div class="box-body">
	      	@if(Auth::user()->role == 3)
	       	<div class="row join-class">
       			<a class="btn btn-sm btn-success" id="btn-join">{{__('dict.class.join_class')}}</a>
       			<input type="text" class="form-control hidden" id="input-class-code" placeholder="enter the class code ...">
       			<button class="btn btn-sm btn-success hidden" id="join-class">{{__('dict.class.join')}} <i class="fa fa-sign-in" aria-hidden="true"></i></button>
	       	</div>
	       	@endif
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
	      		<div class="view-class">
	      			<a href="{{asset('')}}my-class/{{$class->id}}" class="btn btn-info">View <i class="fa fa-eye" aria-hidden="true"></i></a>
	      		</div>
	      	</div>
	      	@endforeach
	           @endif
	      </div>
	    </div>
	  </div>
	</div>
	</div>

	{{-- modal tạo mới, sửa class --}}
	<div class="modal fade" id="class-modal">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title">{{__('dict.class.add_class')}}</h4>
	      </div>
	      <form method="POST" action="{{asset('')}}class/save" enctype="multipart/form-data">
	      <div class="modal-body">
	        @csrf
	        	<input type="hidden" class="form-control" value="" name="classID" required="required">
	        	<label>Class Name</label>
	        	<input type="text" class="form-control" id="" name="className" required="required">
	        	<label>Room</label>
	        	<input type="text" class="form-control" id="" name="classRoom" required="required">
	        	<label>Subject</label>
	        	<input type="text" class="form-control" id="" name="subject" required="required">
	        	<label>Class Image</label>
	        	<input type="file" class="form-control-file" id="" name="classFile" required="required">
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary btn-save" id="">{{__('dict.action.save')}}</button>
	      </div>
	    </div>
	    </form>
	  </div>
	</div>

	{{-- modal xác nhận yêu cầu tham gia từ giáo viên --}}
	<div class="modal fade" id="invite-modal">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title">Request List</h4>
	      </div>
	      <div class="modal-body">
	        <div class="table-responsive">
		        <table class="table table-hover table-responsive">
		          <thead>
		            <tr>
		              <th>Index</th>
		              <th>Teacher Name</th>
		              <th>Class name</th>
		              <th>Subject</th>
		              <th>Room</th>
		              <th>Action</th>
		            </tr>
		          </thead>
		          <tbody id="student-list-body">
		          	@if(isset($inviteJoin))
		          		<?php $index = 1 ?>
		          		@foreach($inviteJoin as $value)
		          		<tr>
		          			<td>{{$index}}</td>
		          			<td>{{$value->name}}</td>
		          			<td>{{$value->class_name}}</td>
		          			<td>{{$value->subject}}</td>
		          			<td>{{$value->room}}</td>
		          			<td>
		          				<button invite-id="{{$value->id}}" class="btn btn-success accept-invite" 
		          					class-id="{{$value->class_id}}" teacher-id="{{$value->teacher_id}}">
		          					Accept
		          				</button>
		          			</td>
		          		</tr>
		          		<?php $index++ ?>
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
@endsection

@section('foot')
	<script src="{{asset('')}}js/class.js"></script>
@endsection