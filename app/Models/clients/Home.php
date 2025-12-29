<?php

namespace App\Models\clients;

 

 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class Home extends Model
{
    use HasFactory;

    protected $table = 'tbl_tours';
    

public function getHomeTours(): Collection
{
    $tours = DB::table('tbl_tours')
        ->select(['tourId', 'title', 'description','priceAdult','destination','duration'])
        ->get();

    foreach ($tours as $tour) {
        $tour->imageURL = DB::table('tbl_images')
            ->where('tourId', $tour->tourId)
            ->pluck('imageURL');// lấy 1 ảnh đầu tiên

        // $tour->timeline = DB::table('tbl_timeline')
        //     ->where('tourId', $tour->tourId)
        //     ->pluck('title'); // lấy danh sách tiêu đề timeline
    }

    return $tours;
}
}


//     public function getHomeTours(): Collection
//     {
//         $getTours = DB::table($this->table)
//             ->select([
//                  'tbl_tours.title', 
//                  'tbl_tours.description', 
//                  'tbl_timeline.title as timeline', 
//                  'tbl_images.imageURL' ])
//             ->leftJoin('tbl_images', 'tbl_tours.tourId', '=', 'tbl_images.tourId')
//             ->leftJoin('tbl_timeline', 'tbl_tours.tourId', '=', 'tbl_timeline.tourId')
            
           
//             ->get();

//         return $getTours;
//     }
// }

