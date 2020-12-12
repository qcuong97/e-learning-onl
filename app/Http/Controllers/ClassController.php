<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Auth;
use Storage;
use Carbon\Carbon;
use App\User;
use App\Classroom;
use App\AttendClass;
use App\RequestJoin;
use App\InviteJoin;
use App\Documents;
use App\Comment;

class ClassController extends Controller
{
	const CONFIRM = 0;
	const WAIT = 0;
	const YES = 1;
	const NO = 2;


    public function list()
    {
    	$classrooms = Classroom::all();
    	return view('class', ['classrooms' => $classrooms]);
    }

    public function create()
    {
    	return view('add_class');
    }

    public function save(Request $req)
    {
    	//nếu tồn tại class_id tức là sửa class
    	if(isset($req->classID)) { //check tồn tại classID từ phía client
    		$class = Classroom::find($req->classID);
    		if(isset($class)) {
    			//gán các giá trị mới
    			$class->class_name = $req->className;
	    		$class->room = $req->classRoom;
	    		$class->subject = $req->subject;
	    		// trong trường hợp edit mà muốn sửa lại file hình ảnh thì mới thực hiện thay đổi ảnh
	    		if(isset($req->classFile)) {
	    			$class->class_image = $this->saveImg($req);
	    		}
	    		// lưu dữ liệu mới
	    		$class->save();
	    		return $this->list();
    		} else {
    			return $this->list();
    		}
    	} else {
    		//nếu không tồn tại class_id tức là tạo mới class
    		$class['class_code'] = $this->getCode(); //tạo code class
    		// Auth::user()->id để xác định người tạo lớp
    		$class['creator_id'] = Auth::user()->id;
    		$class['class_name'] = $req->className;
    		$class['room'] = $req->classRoom;
    		$class['subject'] = $req->subject;
    		$class['class_image'] = $this->saveImg($req);
    		$result = Classroom::create($class);
    		return $this->list();
    	}
    }

    // hàm upload ảnh lên server
    public function saveImg($req)
    {
		$disk = 'public';
		$extension = $req->file('classFile')->extension();
		$path=$req->classFile->storeAs('images','class-'.time().'.'.$extension, $disk);
		return $path;
	}

	//hàm kiểm tra trùng class_code
	public function getCode()
	{
		while(true) {
			$code = $this->codeRandom();
			$class = Classroom::where('class_code', $code)->get();
			if(!isset($class) || count($class) < 1) {
				return $code;
			}
		};
	}

	//hàm tạo code random cho class_code
	public function codeRandom()
	{
		$pin = mt_rand(1000, 9999);
		// shuffle the result
		$string = 'ID'.str_shuffle($pin);
		return $string;
	}

	public function delete(Request $req)
	{
		$class = Classroom::find($req->classID);
		if($class->creator_id == $req->creatorID || Auth::user()->role == 1) {
			// đây là người tạo ra lớp hoặc là admin
			$class->delete();
			return response()->json([
				'status' => true,
				'message' => __('dict.class.delete_success')
			]);
		} else {
			// đây không phải là người tạo lớp
			return response()->json([
				'status' => false,
				'message' => __('dict.class.delete_fail')
			]);
		}
	}

	// function search class
	public function search(Request $req)
	{
		$classrooms;
		$data = $req->searchData;
		if ($req->selectType == "room") {
			$classrooms = Classroom::where('room', 'LIKE', "%{$data}%")->get();
		}
		elseif ($req->selectType == "name") {
			$classrooms = Classroom::where('class_name', 'LIKE', "%{$data}%")->get();
		}
		elseif ($req->selectType == "subject") {
			$classrooms = Classroom::where('subject', 'LIKE', "%{$data}%")->get();
		}
		return view('class', ['classrooms' => $classrooms]);
	}

	// return view my-class for student
	public function myClass()
	{
		if(Auth::user()->role == 3) {
			$classrooms = AttendClass::join('classrooms', 'classrooms.id', '=', 'attend_classes.class_id')->where('attend_classes.student_id', '=', Auth::user()->id)->get();
			$inviteJoin = InviteJoin::select(
						'invite_joins.id',
						'invite_joins.teacher_id',
						'invite_joins.class_id',
						'users.name',
						'classrooms.class_name',
						'classrooms.subject',
						'classrooms.room',
						)
						->where('invite_joins.student_id', '=', Auth::user()->id)
						->where('invite_joins.state', 0)
						->join('users', 'users.id', '=', 'invite_joins.teacher_id')
						->join('classrooms', 'classrooms.id', '=', 'class_id')
						->get();
			$invitations = $inviteJoin->count();
			return view('my_class', [
				'classrooms' => $classrooms,
				'invitations' => $invitations,
				'inviteJoin' => $inviteJoin
			]);
		} else {
			$classrooms = Classroom::where('creator_id', Auth::user()->id)->get();
			return view('my_class', ['classrooms' => $classrooms]);
		}
	}

	public function requestJoin(Request $req)
	{
		//kiểm tra lớp có tồn tại dựa vào mã class code người dùng đã nhập
		$classID = Classroom::where('class_code', $req->code)->value('id');
		if($classID == null) {
			return response()->json([
				'status' => false,
				'message' => __('dict.class.class_null')
			]);
		} else {
			$record['class_id'] = $classID;
			$record['student_id'] = Auth::user()->id;
			// 0 - chờ xác nhận từ phía giáo viên
			$record['state'] = $this::WAIT;
			RequestJoin::create($record);
			return response()->json([
				'status' => true,
				'message' => __('dict.class.requested')
			]);
		}
	}

	public function classByID($id)
	{
		$class = Classroom::find($id);
		$class->teacher_name = User::where('id', $class->creator_id)->value('name');
		$sum = RequestJoin::where('class_id', $id)->where('state', 0)->count();
		$documents = Documents::where('class_id', $id)->orderBy('updated_at', 'DESC')->get();
		$comments = Comment::select(
				'users.id as user_id',
				'users.name',
				'users.role',
				'comments.id',
				'comments.commentor',
				'comments.content',
				'comments.created_at',
				'comments.updated_at',
			)
			->join('users', 'users.id', '=', 'comments.commentor')
			->where('comments.class_id', $id)
			->orderBy('comments.created_at', 'ASC')
			->get();
		if($sum > 0) {
			$data = RequestJoin::select('request_joins.student_id', 'request_joins.id', 'users.name')
				->join('users', 'users.id', '=', 'request_joins.student_id')
				->where('class_id', $id)->where('state', 0)->get();
			return view('class_detail', [
				'class' => $class,
				'sum' => $sum,
				'data' => $data,
				'documents' => $documents,
				'comments' => $comments,
			]);
		}
		return view('class_detail', [
			'class' => $class,
			'documents' => $documents,
			'comments' => $comments,
		]);
	}

	public function getStudentList($classID)
	{
		$result = User::join('attend_classes', 'users.id', '=', 'attend_classes.student_id')
			->where('attend_classes.class_id', $classID)->get();
		return response()->json($result);
	}

	// hàm xóa học viên ra khỏi lớp học
	public function outClass($classID, Request $req)
	{
		$result = AttendClass::where('class_id', $classID)->where('student_id', $req->studentID)->delete();
		if($result > 0) {
			//delete success
			return response()->json([
				'status' => true,
				'message' => __('dict.class.out_success')
			]);
		} else {
			return response()->json([
				'status' => false,
				'message' => __('dict.class.out_fail')
			]);
		}
	}

	//hàm thêm học viên vào lớp học
	public function inviteClass($classID, Request $req)
	{
		$studentID = User::where('email', $req->email)->where('role', 3)->value('id');
		if (isset($studentID)) {
			$invite['class_id'] = $classID; 
			$invite['teacher_id'] = $req->teacherID; 
			$invite['student_id'] = $studentID;
			$invite['state'] = $this::CONFIRM;
			InviteJoin::create($invite);
			return response()->json([
				'status' => true,
				'message' => __('dict.class.invite_success')
			]);
		} else {
			return response()->json([
				'status' => false,
				'message' => __('dict.class.invite_fail')
			]);
		}
		
	}

	// giáo viên xác nhận cho phép tham gia lớp học
	public function acceptRequest($classID, Request $req)
	{
		// lấy đối tượng đang chờ từ bảng request_joins
		$request = RequestJoin::find($req->requestID);
		// lấy các thuốc tính để insert vào bảng attend_class
		$new['class_id'] = $request->class_id;
		$new['student_id'] = $request->student_id;
		$new['teacher_id'] = Auth::user()->id;
		AttendClass::create($new);

		$request->state = $this::YES;
		$request->save();
		return response()->json([
			'status' => true,
			'message' => __('dict.class.accept_success')
		]);
	}

	// học viên xác nhận tham gia lớp học từ lời mời của giáo viên
	public function acceptInvite(Request $req)
	{
		$invite = InviteJoin::find($req->inviteID);
		$new['class_id'] = $invite->class_id;
		$new['student_id'] = Auth::user()->id;
		$new['teacher_id'] = $invite->teacher_id;
		AttendClass::create($new);

		$invite->state = $this::YES;
		$invite->save();
		return response()->json([
			'status' => true,
			'message' => __('dict.class.accept_invite_success')
		]);
	}

	public function uploadDocument($classID, Request $req)
	{
		$record['class_id'] = $classID;
		$record['description'] = $req->description;
		$file = $req->file('classFile');
		// kiểm tra tài liệu đã có sẵn trên server hay chưa ( để dùng lại )
		if(!Storage::exists($file->getClientOriginalName())) {
			//chưa có - upload file lên server
			$record['source'] = $this->storeDocument($file, $file->getClientOriginalName());
		} else {
			$record['source'] = 'documents/'.$file->getClientOriginalName();
		}
		$record['created_at'] = Carbon::now();
		$record['updated_at'] = Carbon::now();
		//create record
		Documents::create($record);
		// gọi lại giao diện lớp học
		return redirect()->route('myclass', $classID);
		// call function to store document storeDocument($req->classFile, $fileName)
	}
	// hàm lưu trữ file upload
    public function storeDocument($file, $fileName)
    {
		$disk = 'public';
		$path=$file->storeAs('documents', $fileName, $disk);
		return $path;
	}

	public function editDocument($classID, Request $req)
	{
		// kiểm tra người dùng có edit kèm file không
		if(isset($req->classFile)) { //nếu có kèm theo file
			$file = $req->file('classFile');
			$document = Documents::find($req->document_id);
			$document->description = $req->description;
			// update time
			$document->updated_at = Carbon::now();
			// re-up file
			if(!Storage::exists($file->getClientOriginalName())) {
				$document->source = $this->storeDocument($file, $file->getClientOriginalName());
			} else {
				$document->source = 'documents/'.$file->getClientOriginalName();
			}
			$document->save();
		} else {
			$document = Documents::find($req->document_id);
			$document->description = $req->description;
			// update time
			$document->updated_at = Carbon::now();
			$document->save();
		}
		return redirect()->route('myclass', $classID);
	}

	public function deleteDocument($classID, Request $req)
	{
		$result = Documents::find($req->documentID)->delete();
		if($result > 0) {
			// delete success
			return response()->json(['status' => true]);
		}
	}

	//add comment
	public function addComment($classID, Request $req)
	{
		$record['class_id'] = $classID;
		$record['commentor'] = $req->commentor;
		$record['content'] = $req->content;
		$record['created_at'] = Carbon::now();
		$comment = Comment::create($record);
		return response()->json([
			'status' => true,
			'message' => 'Add comment successfully',
			'id' => $comment->id
		]);
	}

	//delete comment
	public function deleteComment($classID, Request $req)
	{
		$result = Comment::find($req->commentID)->delete();
		if($result > 0) {
			// delete success
			return response()->json(['status' => true]);
		}
	}

	public function downloadFile($path, $file)
	{
		return response()->download(storage_path("app/public/".$path."/".$file));
	}

	public function getRequest()
	{
		$role = Auth::user()->role;
		$userID = Auth::user()->id;
		if($role == 1) {
			$invites = InviteJoin::select(
						'classrooms.class_name',
						'classrooms.subject',
						'invite_joins.state',
						'invite_joins.student_id',
						'invite_joins.teacher_id',
					)
					->join('classrooms', 'classrooms.id', '=', 'invite_joins.class_id')
					->get();
			$requests = RequestJoin::select(
						'classrooms.class_name',
						'classrooms.subject',
						'request_joins.student_id',
						'request_joins.state',
					)
					->join('classrooms', 'classrooms.id', '=', 'request_joins.class_id')
					->get();
			foreach ($invites as $item) {
				$item = $this->insertName($item);
			}
			foreach ($requests as $item) {
				$item = $this->insertName($item);
			}
		} else if ($role == 2) {
			$invites = InviteJoin::select(
						'classrooms.class_name',
						'classrooms.subject',
						'invite_joins.state',
						'invite_joins.student_id',
						'invite_joins.teacher_id',
					)
					->join('classrooms', 'classrooms.id', '=', 'invite_joins.class_id')
					->where('invite_joins.teacher_id', $userID)
					->get();
			foreach ($invites as $item) {
				$item = $this->insertName($item);
			}
			$requests = null;
		} else if ($role == 3) {
			$invites = null;
			$requests = RequestJoin::select(
						'classrooms.class_name',
						'classrooms.subject',
						'request_joins.student_id',
						'request_joins.state',
					)
					->join('classrooms', 'classrooms.id', '=', 'request_joins.class_id')
					->where('request_joins.student_id', $userID)
					->get();
			foreach ($requests as $item) {
				$item = $this->insertName($item);
			}
		}
		return view('my_request', [
			'requests' => $requests,
			'invites' => $invites
		]);
	}

	public function insertName($obj)
	{
		if (isset($obj->teacher_id)) {
			$obj->teacher_name = User::where('id', $obj->teacher_id)->value('name');
		}
		if (isset($obj->student_id)) {
			$obj->student_name = User::where('id', $obj->student_id)->value('name');
		}
	}
}
