<?php

namespace App\Models\clients;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checkout extends Model
{
    use HasFactory;

    protected $table = 'tbl_checkout';
    protected $primaryKey = 'checkoutId';
    public $timestamps = false; // tắt created_at, updated_at

    protected $fillable = [
        'bookingId',
        'paymentMethod',
        'amount',
        'paymentStatus',
        'transactionId',
    ];

    /**
     * Tạo checkout mới
     */
    public function createCheckout(array $data): int
    {
        $checkout = self::create($data);
        return $checkout->checkoutId;
    }

    /**
     * Cập nhật trạng thái checkout theo bookingId
     */
    public function updateCheckoutStatusByBookingId(int $bookingId, string $status): int
    {
        return self::where('bookingId', $bookingId)
            ->update(['paymentStatus' => $status]);
    }

    /**
     * Hủy checkout (cập nhật trạng thái)
     */
    public function cancelCheckout(int $checkoutId): int
    {
        return self::where('checkoutId', $checkoutId)
            ->update(['paymentStatus' => 'cancelled']);
    }

    /**
     * Lấy chi tiết checkout theo bookingId
     */
    public function getCheckoutByBookingId(int $bookingId)
    {
        return self::where('bookingId', $bookingId)->first();
    }
}
