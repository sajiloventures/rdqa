<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstanceIndicatorCrossCheck extends Model
{
    protected $table = 'instance_indicator_cross_check';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'instance_id',
        'instance_indicator_id',
        'cross_check_1_a_id',
        'cross_check_1_b_id',
        'cross_check_2_a_id',
        'cross_check_2_b_id',
        'cross_check_3_a_id',
        'cross_check_3_b_id',
    ];

    public $timestamps = false;

}
