<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Events\resetPassword;
use Illuminate\Support\Facades\Log;

class UserController extends ApiController
{
	/*_________________________Deleted__________________________*/

	public function index()
	{
		$User = User::all();
		return $this->showAll($User);
	}
	/*_________________________Deleted__________________________*/

	public function store(Request $request)
	{
		Log::emergency($request);
		$rule = [
			'name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:7|confirmed'
		];

		$this->validate($request, $rule);

		$dataUser = $request->all();
		$dataUser['name'] = $request->name;
		$dataUser['email'] = $request->email;
		$dataUser['password'] = bcrypt($request->password);
		$dataUser['verified'] = User::user_no_verificado;
		$dataUser['verification_token'] = User::GenerateToken();
		$dataUser['role'] = User::user_student;
		$dataUser['img'] = User::img_user;
		

		$newUser = User::create($dataUser);

		return response()->json(['data'=>$newUser], 201); 
	}
	/*_________________________Deleted__________________________*/

	public function show(User $User)
	{
		return $this->showOne($User);
	}

	/*_________________________Deleted__________________________*/

	public function update(Request $request, User $User)
	{
		$rule = [
			'email' => 'email|unique:users,email,'.$User->id,
			'password' => 'min:7|confirmed',
			'role' => 'in:'.User::user_admin.','.User::user_teacher.','.User::user_student
		];

		$this->validate($request, $rule);
		if($request->has('name')){
			$User->name = $request->name;
		}

		if($request->has('email') && $User->email != $request->email){
			$User->verified = User::user_no_verificado;
			$User->verification_token = User::GenerateToken();
			$User->email = $request->email;
		}
		if($request->has('password')){
			$User->password = bcrypt($request->password);
		}
		if($request->has('role')){
			if(!$User->isVerifiend()){
				return $this->errorResponse('Only verified users can be managed', 409);
			}
			$User->role = $request->role;
		}
		if(!$User->isDirty()){
			return $this->errorResponse('you must specify at least one different value to update', 422);
		}
		$User->save();
		return $this->showOne($User);
	}
	/*_________________________Deleted__________________________*/
	public function destroy(User $User)
	{
		$User->delete();
		return response()->json(['data' => $User], 200);
	}
	/*_________________________Deleted__________________________*/

	public function verify($token) {
		$User = User::where('verification_token', $token)->firstOrFail();
		$User->verified = User::user_verificado;
		$User->verification_token = null;
		$User->save();
		$url = env('URL_FRONTEND');
		return redirect("$url/#/login");
	}
	/*_________________________Deleted__________________________*/

	public function verifyEmail($email){
		$User = User::where('email', $email)->firstOrFail();
		$User->verification_token = User::GenerateToken();
// $User->verified = User::user_no_verificado;
		$User->save();
		event(new ResetPassword ($User));    
		return response()->json(['token' => $User], 200);

	}
	/*_________________________Deleted__________________________*/

	public function resetPassword(Request $request, $id){
		$User = User::where('verification_token', $id)->firstOrFail();
		$rule = [
			'password' => 'required|min:7|confirmed'
		];
		$this->validate($request, $rule);
		$User->verified = User::user_verificado;
		$User->verification_token = null;

		if($request->has('password')){
			$User->password = bcrypt($request->password);
		}

		if(!$User->isDirty()){
			return response()->json(['data'=>'you must specify at least one different value to update'], 422);
		}
		$User->save();

		return $this->showOne($User);
	}
}
