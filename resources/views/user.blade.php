@extends('layouts.admin')
@section('css')
	<link rel="stylesheet" href="{{asset('../css/class.css')}}">
@endsection
@section('content')
	<div class="row">
	  <div class="col-xs-12">
	    <div class="box">
	      <div class="box-header text-center">
	        <h3 class="box-title font-weight-bold p-1 font-30">{{__('dict.navbar.user_manager')}}</h3>
	      </div>
	      <div class="box-body">
	       {{-- <a href="{{asset('')}}user/create" class="btn btn-sm btn-success">Add</a> --}}
	       <div class="table-responsive">
	        <table class="table table-hover table-responsive">
	          <thead>
	            <tr>
	              <th>#</th>
	              <th>Name</th>
	              <th>Email</th>
	              <th>Role</th>
	              <th>Action</th>
	            </tr>
	          </thead>
	          <tbody>
	           @if (isset($users) && count($users) > 0)
		           @foreach ($users as $user)
		           <tr>
		           <td>{{$user->id}}</td>
		           <td>{{$user->name}}</td>
		           <td>{{$user->email}}</td>
		           @if ($user->role == 1)
		           <td>{{__('dict.role.1')}}</td>
		           @elseif($user->role == 2)
		           <td>{{__('dict.role.2')}}</td>
		           @elseif($user->role == 3)
		           <td>{{__('dict.role.3')}}</td>
		           @endif
		           <td>
		            <a class="btn btn-success btn-change" data-toggle="modal" href='#modal-id' data-id="{{$user->id}}">Change Role</a>
		             {{-- <a href="{{asset('')}}admin/user/edit/{{$user->id}}" class="btn btn-warning">Edit</a> --}}
		             {{-- <button class="btn btn-danger btn-delete" data-id={{$user->id}}>Delete</button> --}}
		           </td>
		           </tr>
		          
		           @endforeach
	           @endif

	          </tbody>
	        </table>
	      </div>
	    </div>
	  </div>
	</div>
	</div>

	{{-- modal thay đổi quyền user --}}
	<div class="modal fade" id="modal-id">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title">{{__('dict.role.change')}}</h4>
	      </div>
	      <div class="modal-body">
	       <form method="POST">
	        @csrf
	          <select name="" id="state" class="form-control" required="required">
	          <option value="1" class="yes">{{__('dict.role.1')}}</option>
	          <option value="2" class="no">{{__('dict.role.2')}}</option>
	          <option value="3" class="no">{{__('dict.role.3')}}</option>
	        </select>
	       </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary btn-save" id="save-user">{{__('dict.action.save')}}</button>
	      </div>
	    </div>
	  </div>
	</div>
@endsection

@section('foot')
	<script src="{{asset('')}}js/user.js"></script>
@endsection