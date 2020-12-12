@extends('layouts.admin')
@section('css')
	<link rel="stylesheet" href="{{asset('../css/class.css')}}">
@endsection
@section('content')
	<div class="row">
	  <div class="col-xs-12">
	    <div class="box">
	      <div class="box-header text-center">
	        <h3 class="box-title font-weight-bold p-1 font-30">{{__('dict.class.request_list')}}</h3>
	      </div>
	      <div class="p-1">
	      	  (*)You can see your request in here.Confirm the request or waiting for the confirmation from teacher(student).
	      </div>
	      <div class="box-body">
	       {{-- <a href="{{asset('')}}user/create" class="btn btn-sm btn-success">Add</a> --}}
	       <div class="table-responsive">
	        <table class="table table-hover table-responsive">
	          <tbody>
	           @if (isset($requests) && count($requests) > 0)
	           		<span class="font-weight-bold">Request to join class</span>
		           @foreach ($requests as $item)
		           <tr>
			           <td>From Student : {{$item->student_name}}</td>
			           <td>Join to class: {{$item->class_name}}</td>
			           <td>Subject : {{$item->subject}}</td>
			           @if ($item->state == 0)
			           <td>State : <span class="text-info">{{__('dict.state.0')}}</span></td>
			           @elseif($item->state == 1)
			           <td>State : <span class="text-success">{{__('dict.state.1')}}</span></td>
			           @elseif($item->state == 2)
			           <td>State : <span class="text-danger">{{__('dict.state.2')}}</span></td>
			           @endif
		           </tr>
		           @endforeach
	           @endif
	          </tbody>
	        </table>
	        <table class="table table-hover table-responsive">
	          <tbody>
	           @if (isset($invites) && count($invites) > 0)
	           		<span class="font-weight-bold">Invite to join class</span>
		           @foreach ($invites as $item)
		           <tr>
			           <td>From Teacher : <span class="font-weight-bold">{{$item->teacher_name}}</span></td>
			           	<td>To Student : <span class="font-weight-bold">{{$item->student_name}}</span></td>
			           <td>Join to class: {{$item->class_name}}</td>
			           <td>Subject : {{$item->subject}}</td>
			           @if ($item->state == 0)
			           <td>State : <span class="text-info">{{__('dict.state.0')}}</span></td>
			           @elseif($item->state == 1)
			           <td>State : <span class="text-success">{{__('dict.state.1')}}</span></td>
			           @elseif($item->state == 2)
			           <td>State : <span class="text-danger">{{__('dict.state.2')}}</span></td>
			           @endif
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
	{{-- <script src="{{asset('')}}js/user.js"></script> --}}
@endsection