<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\clients\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    private $user;
    public function __construct()
    {
        $this->user = new User();
    }
    protected function getUserId(){
        if(!session()->has('userId')){
            $username = session()->get('username');
            if($username){
                $userId= $this->user->getUserId($username);
                session()->put('userId',$userId);//luu userId vao session
            }
        }
        return session()->get('userId');
    }
    public function index()
    {
        $title = "Thông tin cá nhân";
        $userId = $this->getUserId();
        $user =$this->user->getUser($userId);
        // dd($userId);
        return view('clients.user-profile',compact('title','user'));
    }
    public function update(Request $request)
    {
        $fullName = $request->fullName;
        $address = $request->address;
        $email = $request->email;
        $phone = $request->phone;

        $dataUpdate = [
            'fullName' => $fullName,
            'address' => $address,
            'email' => $email,
            'phoneNumber' => $phone
        ];
        $update =$this->user->updateUser($this->getUserId(), $dataUpdate);
        if(!$update){
            return response()->json([
                'fail' => false
            ]);
        }
        return response()->json([
            'success' => true
        ]);
    }
}
