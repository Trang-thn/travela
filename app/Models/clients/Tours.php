<?php

namespace App\Models\clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class Tours extends Model
{
    use HasFactory;

    protected $table = 'tbl_tours';

    // Nếu bảng không có created_at/updated_at thì tắt timestamps
    public $timestamps = false;

    /**
     * Lấy tất cả tours kèm danh sách hình ảnh
     */
    public function getAllTours(): Collection
    {
        $allTours = DB::table($this->table)->get();

        foreach ($allTours as $tour) {
            $tour->images = DB::table('tbl_images')
                ->where('tourId', $tour->tourId)
                ->pluck('imageUrl');
        }

        return $allTours;
    }

    /**
     * Lấy chi tiết tour theo ID
     */
    public function getTourDetail($id)
    {
        $getTourDetail = DB::table($this->table)
            ->where('tourId', $id)
            ->first();

        if ($getTourDetail) {
            // Lấy danh sách hình ảnh (giới hạn 5 ảnh)
            $getTourDetail->images = DB::table('tbl_images')
                ->where('tourId', $getTourDetail->tourId)
                ->limit(5)
                ->pluck('imageUrl');

            // Lấy timeline
            $getTourDetail->timeline = DB::table('tbl_timeline')
                ->where('tourId', $getTourDetail->tourId)
                ->get();

            // Lấy đánh giá
            $getTourDetail->reviews = DB::table('tbl_reviews')
                ->join('users', 'tbl_reviews.userId', '=', 'users.id')
                ->where('tourId', $getTourDetail->tourId)
                ->select('tbl_reviews.*', 'users.name as userName')
                ->get();
        }

        return $getTourDetail;
    }

    /**
     * Lọc và sắp xếp tours
     */
    public function filterTours($filters = [], $sorting = null)
    {
        $getTours = DB::table($this->table);

        // Áp dụng bộ lọc
        if (!empty($filters)) {
            foreach ($filters as $column => $value) {
                $getTours->where($column, $value);
            }
        }

        // Sắp xếp
        if (!empty($sorting) && isset($sorting[0][0]) && isset($sorting[0][1])) {
            $getTours->orderBy($sorting[0][0], $sorting[0][1]);
        }

        $tours = $getTours->get();

        // Lấy hình ảnh cho từng tour
        foreach ($tours as $tour) {
            $tour->images = DB::table('tbl_images')
                ->where('tourId', $tour->tourId)
                ->pluck('imageUrl');
        }

        return $tours;
    }

    /**
     * Cập nhật tour
     */
    public function updateTours($tourId, $data): int
    {
        return DB::table($this->table)
            ->where('tourId', $tourId)
            ->update($data);
    }

    /**
     * Lấy tour đã đặt (join booking + checkout)
     */
    public function tourBooked($bookingId, $checkoutId)
    {
        return DB::table($this->table)
            ->join('tbl_booking', 'tbl_tours.tourId', '=', 'tbl_booking.tourId')
            ->join('tbl_checkout', 'tbl_booking.bookingId', '=', 'tbl_checkout.bookingId')
            ->where('tbl_booking.bookingId', $bookingId)
            ->where('tbl_checkout.checkoutId', $checkoutId)
            ->first();
    }

    /**
     * Tạo đánh giá cho tour
     */
    public function createReviews($data): bool
    {
        $insert = DB::table('tbl_reviews')->insert([
            'tourId'  => $data['tourId'],
            'userId'  => $data['userId'],
            'rating'  => $data['rating'],
            'comment' => $data['comment'],
        ]);

        return $insert ? true : false;
    }

    /**
     * Xoá tour
     */
    public function deleteTour($tourId): int
    {
        return DB::table($this->table)
            ->where('tourId', $tourId)
            ->delete();
    }

    /**
     * Thêm tour mới
     */
    public function createTour($data): int
    {
        return DB::table($this->table)->insertGetId([
            'title'       => $data['title'],
            'description' => $data['description'],
            'quantity'    => $data['quantity'],
            'priceAdult'  => $data['priceAdult'],
            'priceChild'  => $data['priceChild'],
            'time'        => $data['time'],
            'domain'      => $data['domain'], // b/t/n
            'destination' => $data['destination'],
            'availability'=> $data['availability'],
            'startDate'   => $data['startDate'],
            'endDate'     => $data['endDate'],
            'reviews'     => $data['reviews'] ?? null,
        ]);
    }

    /**
     * Lấy danh sách đánh giá của tour
     */
    public function getReviews($tourId): Collection
    {
        return DB::table('tbl_reviews')
            ->join('users', 'tbl_reviews.userId', '=', 'users.id')
            ->where('tourId', $tourId)
            ->select('tbl_reviews.*', 'users.name as userName')
            ->get();
    }
}
