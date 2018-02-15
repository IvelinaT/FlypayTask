<?php

namespace Flyt\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Payment Detail model, one-to-one with Payment
 *
 * @property string card_holder
 * @property string phone_number
 * @property string device
 * @property integer payment_id
 * @property \Flyt\Models\Payment payment
 */
class PaymentDetail extends Model
{
    protected $table = 'payment_detail';
    protected $primaryKey = 'payment_id';
    protected $fillable = ['payment_id', 'card_holder', 'phone_number', 'device'];

    public $timestamps = false;


    public function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }
}
