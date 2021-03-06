<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'billing_email', 'billing_name', 'billing_address', 'billing_city',
        'billing_province', 'billing_postalcode', 'billing_phone', 'billing_name_on_card', 'billing_discount', 'billing_discount_code', 'billing_subtotal', 'billing_tax', 'billing_total', 'payment_gateway', 'error',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('quantity');
    }

    public static function getOrderbyCustomer($id)
    {
        return $this->join('users as a', function ($join) {
            $join->on('users.id', '=', 'loc.location_id');
        })
        ->where(['users_id'=>$id])
        ->select(
            'trx_nonex_adjustment.id',
            'trx_nonex_adjustment.location_id',
            'loc.location_code',
            'loc.location_name',
            'trx_nonex_adjustment.trx_date',
            'trx_nonex_adjustment.trx_id',
            'trx.control_number',
            'trx.remco_id',
            'trx_nonex_adjustment.service_code',
            'trx_nonex_adjustment.action_taken',
            'trx_nonex_adjustment.orig_amount',
            'trx_nonex_adjustment.adjusted_amount',
            'trx_nonex_adjustment.requested_by',
            DB::raw("CONCAT(u1.first_name,' ',u1.last_name) as requesting_fla"),
            'trx_nonex_adjustment.requested_date',
            'trx_nonex_adjustment.approved_by',
            DB::raw("CONCAT(u2.first_name,' ',u2.last_name) as cs_name"),
            'trx_nonex_adjustment.approved_date',
            'trx_nonex_adjustment.approved_ip',
            'trx_nonex_adjustment.status',
            'trx_nonex_adjustment.remarks'
        )
        ->get();
        return Order::where('user_id', $id)->get();
    }
}
