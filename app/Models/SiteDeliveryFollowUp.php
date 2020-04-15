<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteDeliveryFollowUp extends Model
{
    protected $table = 'site_delivery_followup';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'instance_id',
        'question_id',
        'site_delivery_id',
        'weakness',
        'description',
        'responsible',
        'time_line',
        'time_line_eng',
        'sort_order',
        'completed',
    ];

    public $timestamps = true;

    public function question()
    {
        return $this->belongsTo('App\Models\Question', 'question_id');
    }
    public function instance(){
        return $this->belongsTo('App\Models\Instance');
    }
}
