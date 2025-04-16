<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseStatusMessage extends Model
{
    public $timestamps = false; // Disable automatic timestamp management

    protected $fillable = ['purchase_id', 'message', 'created_at'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
