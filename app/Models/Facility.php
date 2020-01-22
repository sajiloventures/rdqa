<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $table = 'facility';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    //    'user_id',
        'province_code',
        'province_name',
        'district_code',
        'district_name',
        'palika_code',
        'palika_name',
        'ward_code',
        'ward_name',
        'hf_id',
        'hf_code',
        'hf_name',
        'hf_type',
        'ownership_type',
        'urban_rural',
        'geography',
        'public_nonpublic',
        'status',
    ];

    public $timestamps = true;

    public function scopeByStatus($query, $status = 1) {
        return $query->where($this->table . '.status', $status);
    }
}
