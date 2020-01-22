<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    protected $table = 'instance';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_by',
        'name',
        'level',
        'built_stage',
        'from_date',
        'to_date',
        'evaluation_team',
    ];

    public $timestamps = true;

    public function scopeFilterByStage($query)
    {
        return $query->where($this->table . '.built_stage', '!=', 'step-4');
    }
    public function indicators()
    {
        return $this->hasMany('App\Models\InstanceIndicators', 'instance_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
    public function siteDelivery()
    {
        return $this->hasOne('App\Models\InstanceSiteDelivery', 'instance_id');
    }
    public function siteDeliverySystemAssessment()
    {
        return $this->hasMany('App\Models\SiteDeliverySystemAssessment', 'instance_id');
    }
    public function siteFollowUp()
    {
        return $this->hasMany('App\Models\SiteDeliveryFollowUp', 'instance_id');
    }

}
