<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteDeliverySystemAssessment extends Model
{
    protected $table = 'site_delivery_system_assessment';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_delivery_questions_id',
        'instance_id',
        'question_id',
        'question_list_id',
        'value',
        'remarks',
    ];

    public $timestamps = true;


    public function siteQuestion()
    {
        return $this->belongsTo('App\Models\SiteDeliveryQuestions', 'site_delivery_questions_id');
    }

    public function question()
    {
        return $this->belongsTo('App\Models\Question', 'question_id');
    }
}
