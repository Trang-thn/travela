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
