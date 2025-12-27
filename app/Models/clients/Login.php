<?php

namespace App\Models\clients;

use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB as FacadesDB;
use Ramsey\Collection\Collection;

class Login extends Model
{
    use HasFactory;

    protected $table = 'tbl_users';
    //đăng ký tài khoản
    public function registerAccount($data){
        return FacadesDB::table($this->table)->insert($data);
    }
    //kiểm tra tài khoản đã tồn tại chưa return true/false
    public function checkUserExists($username,$email){
        $check= FacadesDB::table($this->table)
            ->where('username', $username)
            ->orWhere('email', $email)
            ->exists();
            return $check;
    }

    public function getUserByToken($token){
        return FacadesDB::table($this->table)
            ->where('activation_token', $token)
            ->first();
    }
    public function activateUserAccount($token){
        return FacadesDB::table($this->table)
            ->where('activation_token', $token)
            ->update(['activation_token' => null, 'isActive' => 'y']);
    }

    public function login($account)
    {
        $getUser = FacadesDB::table($this->table)
            ->where('username', $account['username'])
            ->where('password', $account['password'])
            ->first();
        return $getUser;
    }
}
