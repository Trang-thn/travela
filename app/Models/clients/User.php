<?php

namespace App\Models\clients;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
   use HasFactory; 
   protected $table = 'tbl_users'; // Hàm tạo booking mới 
   public function createBooking($data){ 
    

    return DB::table($this->table)->insert($data); 
}
}

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\DB;

// class User extends Model
// {
//     use HasFactory;
//     protected $table = 'tbl_users';

//     public function getUserId($username){
//         return DB::table($this->table)
//         ->select('userId')
//         ->where('username',$username)
//         ->value('userId');

//     }
//     public function getUser($Id){
//         $users = DB::table($this->table)
//         ->where('userId',$Id)
//         ->first();
//         return $users;
//     }
//     public function updateUser($id, $data) {
//         $update= DB::table($this->table)
//             ->where('userId', $id)
//             ->update($data);
//         return $update;
//         }
// >>>>>>> e573aac15b9eb28ae49b90d7638665ec7fa9e1ba
// }
