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
    protected $primaryKey = 'tourId';
    public $timestamps = false;

    protected $fillable = [
        'title', 'description', 'quantity', 'priceAdult', 'priceChild',
        'time', 'domain', 'destination', 'availability', 'startDate', 'endDate'
    ];

    /**
     * Lấy tất cả tours kèm danh sách hình ảnh
     */
    public function getAllTours(): Collection
    {
        $allTours = self::all();

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
        $getTourDetail = self::find($id);

        if ($getTourDetail) {
            $getTourDetail->images = DB::table('tbl_images')
                ->where('tourId', $getTourDetail->tourId)
                ->limit(5)
                ->pluck('imageUrl');

            $getTourDetail->timeline = DB::table('tbl_timeline')
                ->where('tourId', $getTourDetail->tourId)
                ->get();

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
        $query = self::query();

        if (!empty($filters)) {
            foreach ($filters as $column => $value) {
                $query->where($column, $value);
            }
        }

        if (!empty($sorting) && isset($sorting[0][0]) && isset($sorting[0][1])) {
            $query->orderBy($sorting[0][0], $sorting[0][1]);
        }

        $tours = $query->get();

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
        return self::where('tourId', $tourId)->update($data);
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
            ->select('tbl_tours.*', 'tbl_booking.*', 'tbl_checkout.*')
            ->first();
    }

    /**
     * Tạo đánh giá cho tour
     */
    public function createReviews($data): bool
    {
        return DB::table('tbl_reviews')->insert([
            'tourId'  => $data['tourId'],
            'userId'  => $data['userId'],
            'rating'  => $data['rating'],
            'comment' => $data['comment'],
        ]);
    }

    /**
     * Xoá tour
     */
    public function deleteTour($tourId): int
    {
        return self::where('tourId', $tourId)->delete();
    }

    /**
     * Thêm tour mới
     */
    public function createTour($data): int
    {
        $tour = self::create($data);
        return $tour->tourId;
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
