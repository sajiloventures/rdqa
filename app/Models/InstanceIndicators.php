<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstanceIndicators extends Model
{
    protected $table = 'instance_indicators';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'instance_id',
        'indicator_id',
        'from_date',
        'to_date',
        'from_date_eng',
        'to_date_eng',
    ];

    public $timestamps = true;

    public function indicator()
    {
        return $this->belongsTo('App\Models\Indicator', 'indicator_id');
    }
    public function indicatorCrossCheck()
    {
        return $this->hasOne('App\Models\InstanceIndicatorCrossCheck', 'instance_indicator_id');
    }
}
