<?php

namespace App\Models\clients;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'tbl_booking';
    protected $primaryKey = 'bookingId';
    public $timestamps = false;

    // Cho phép fill dữ liệu bằng create()
    protected $fillable = [
        'tourId',
        'userId',
        'address',
        'fullName',
        'email',
        'numAdults',
        'numChildren',
        'phoneNumber',
        'totalPrice',
        'bookingStatus',
    ];

    /**
     * Tạo booking mới
     */
    public function createBooking(array $data): int
    {
        $booking = self::create($data);
        return $booking->bookingId;
    }

    /**
     * Hủy booking (cập nhật trạng thái)
     */
    public function cancelBooking(int $bookingId): int
    {
        return self::where('bookingId', $bookingId)
            ->update(['bookingStatus' => 'C']); // C = Cancelled
    }

    /**
     * Cập nhật trạng thái booking
     */
    public function updateBookingStatus(int $bookingId, string $status): int
    {
        return self::where('bookingId', $bookingId)
            ->update(['bookingStatus' => $status]);
    }

    /**
     * Kiểm tra xem user đã đặt tour này chưa
     */
    public function checkBooking(int $tourId, int $userId): bool
    {
        return self::where('tourId', $tourId)
            ->where('userId', $userId)
            ->exists();
    }

    /**
     * Lấy danh sách booking theo user
     */
    public function getBookingsByUser(int $userId)
    {
        return self::join('tbl_tours', 'tbl_booking.tourId', '=', 'tbl_tours.tourId')
            ->where('tbl_booking.userId', $userId)
            ->select('tbl_booking.*', 'tbl_tours.title', 'tbl_tours.destination')
            ->get();
    }

    /**
     * Lấy chi tiết booking theo ID
     */
    public function getBookingDetail(int $bookingId)
    {
        return self::join('tbl_tours', 'tbl_booking.tourId', '=', 'tbl_tours.tourId')
            ->where('tbl_booking.bookingId', $bookingId)
            ->select(
                'tbl_booking.*',
                'tbl_tours.title',
                'tbl_tours.destination',
                'tbl_tours.startDate',
                'tbl_tours.endDate'
            )
            ->first();
    }
}
