@extends('layouts.admin')
@section('css')
	<link rel="stylesheet" href="{{asset('../css/class.css')}}">
@endsection
@section('content')
	<div class="row">
	  <div class="col-xs-12">
	    <div class="box">
	      <div class="box-header text-center">
	        <h3 class="box-title font-weight-bold p-1 font-30">{{__('dict.class.class_manager')}}</h3>
	      </div>
	      <form method="GET" action="{{route('class.search')}}" id="form-search">
	      	@csrf
	      	<div class="search-title">Search Classroom</div>
	      	<div class="search-class row">
		      	<div class="col-lg-2 col-md-12">
		      		<select class="form-control" name="selectType">
			      		<option value="name">Search by class name</option>
			      		<option value="room">Search by room</option>
			      		<option value="subject">Search by subject</option>
		      		</select>
		      	</div>
		      	<div class="col-lg-2 col-md-12">
		      		<input type="text" name="searchData" class="form-control" placeholder="enter the value to find class">
		      	</div>
		      	<div class="col-lg-2 col-md-12">
		      		<input type="submit" class="btn btn-info" value="Search">
		      	</div>
		      </div>
	      </form>
	      <div class="box-body">
	      	{{-- nút tạo mới lớp học chỉ được hiển thị khi người dùng là admin hoặc teacher --}}
	       	@if(Auth::user()->role == 1 || Auth::user()->role == 2)
	       		<a data-toggle="modal" href='#class-modal' class="btn btn-sm btn-success">{{__('dict.class.add_class')}}</a>
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
@endsection

@section('foot')
	<script src="{{asset('')}}js/class.js"></script>
@endsection