<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\clients\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    private $login;
    public function __construct()
    {
        $this->login = new Login();
    }
    public function index()
    {
        $title = 'Đăng nhập';
        return view('clients.login', compact(['title']));
    }


    public function register( Request $request )
    {
        $username_regis = $request->username_regis;
        $email = $request->email;
        $password_regis = $request->password_regis;

        $checkAccountExists = $this->login->checkUserExists($username_regis, $email);
        if ($checkAccountExists){
            return response()->json(['success' => false, 'message' => 'Tài khoản hoặc email đã tồn tại!']);
        }

        $activation_token = Str::random(60);
        $dataInsert = [
            'username'  => $username_regis,
            'email'     => $email,
            'password'  => md5($password_regis),
            'activation_token' => $activation_token
        ];
        $this->login->registerAccount($dataInsert);
        //gui mail kich hoat tai khoan o day
        $this->sendActivationEmail($email, $activation_token);
        return response()->json(['success' => true, 'message' => 'Đăng ký thành công!']);
    }
    public function sendActivationEmail($email, $token)
    {
        $activation_link = route('activate.account', ['token' => $token]);
        Mail::send('clients.mail.mail_activate', ['link' => $activation_link], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Kích hoạt tài khoản của bạn');
        });
    }
    public function activateAccount($token)
    {
        $user = DB::table('tbl_users')
            ->where('activation_token', $token)
            ->first();
        if ($user) {
            $this->login->activateUserAccount($token);

            return redirect('login')->with('message', 'Tài khoản của bạn đã được kích hoạt thành công!');
        } else {
            return redirect('login')->with('error', 'Mã kích hoạt không hợp lệ!');
        }
    }

    public function login(Request $request){
        $username = $request->username;
        $password = $request->password;

        $data_login = [
            'username' => $username,
            'password' => md5($password)
        ];
        $user = $this->login->login($data_login);
        if($user!=null){
            $request->session()->put('username',$username);
            return response()->json(['success' => true, 'message' => 'Đăng nhập thành công!', 'redirect' => route('home')]);
        }
        else{
            return redirect()->route('login');

        }
    }

    //logout
    public function logout(Request $request){
        $request->session()->forget('username');
        return redirect()->route('home');
    }
}
