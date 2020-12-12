<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class UserController extends Controller
{
    public function list()
    {
    	//lấy danh sách user từ database
    	$list = User::all();
    	//trả danh sách user về view user.blade.php để hiển thị
    	return view('user', ['users' => $list]);
    }

    public function role(Request $req)
    {
    	//tìm user có id = $req->user
    	$user = User::find($req->user);
    	if(isset($user)) { //nếu tồn tại user có id = $req->user
    		//chỉnh sửa role của user = $req->role
    		$user->role = $req->role;
    		if($user->save()) { //nếu update role thành công
    			//trả về thông báo thành công cho ajax
    			return response()->json([
    				'status' => true,
    				'message' => __('dict.role.role_success')
    			]);
    		} else {
    			// trả về thông báo thất bại cho ajax
    			return response()->json([
    				'status' => false,
    				'message' => __('dict.role.role_fail')
    			]);
    		}
    	} else { // không tìm đc user - trả về thông báo thất bại cho ajax
			return response()->json([
				'status' => false,
				'message' => __('dict.role.role_fail')
			]);
		}
    }
}
