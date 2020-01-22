<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteDeliveryQuestions extends Model
{
    protected $table = 'site_delivery_questions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'instance_id',
        'site_delivery_id',
        'question_id',
        'question_list_id',
        'question_detail',
        'question_type',
        'part',
        'type',
        'sub_type',
    ];

    public $timestamps = true;

    public function siteData()
    {
        return $this->hasMany('App\Models\SiteDeliveryData', 'site_delivery_questions_id');
    }
    public function siteAssessment()
    {
        return $this->hasOne('App\Models\SiteDeliverySystemAssessment', 'site_delivery_questions_id');
    }
}
