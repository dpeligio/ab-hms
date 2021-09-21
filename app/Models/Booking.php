<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    public $table = 'bookings';

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'booking_date',
    ];

    protected $fillable = [
        'room_id',
        'user_id',
        'amount',
        'payment_status',
        'created_at',
        'updated_at',
        'deleted_at',
        'booking_date',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function payments() {
        return $this->hasMany('App\Models\Payment', 'booking_id');
    }

    public function getBookingDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setBookingDateAttribute($value)
    {
        $this->attributes['booking_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
