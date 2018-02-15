<?php

namespace Flyt\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Payment model
 *
 * One-to-many with PaymentDetail
 */

/**
 * @property integer id
 * @property double amount
 * @property double tip
 * @property string currency
 * @property string location
 * @property integer table_number
 * @property string reference
 * @property string card_type
 * @property \Carbon\Carbon created_at
 * @property \Flyt\Models\PaymentDetail payment_detail
 */
class Payment extends Model
{
    protected $table = 'payment';
    protected $primaryKey = 'id';
    protected $fillable = ['amount', 'tip', 'currency', 'location', 'table_number', 'reference', 'card_type', 'created_at'];
    protected $guarded = ['id'];
    protected $dates = ['created_at'];
    public $timestamps = false;

    const ACCT = array('VISA', 'Mastercard', 'American Express', 'Discover', 'JCB', 'Diners Club', 'Maestro', 'InstaPayment');
    const CURRENCIES = array('USD', 'EUR');

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public function payment_details()
    {

        return $this->hasOne(PaymentDetail::class, 'payment_id', 'id');
    }


    public function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }

    /**
     * Check if payment detail available
     *
     * @param null $id
     *
     * @return bool
     */
    public function isPaymentDetailAvailable($id = null)
    {
        if (is_null($id)) {
            return false;
        }

        if ($id instanceof self) {
            $id = $id->id;
        }

        return $this->newBaseQueryBuilder()
            ->from('payment_detail')
            ->where('payment_id', $id)
            ->exists();
    }
}
