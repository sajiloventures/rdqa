<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstanceSiteDelivery extends Model
{
    protected $table = 'instance_site_delivery';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facility_user_id',
        'created_by',
        'instance_id',
        'facility_id',
        'facility_name',
        'facility_code',
        'province_name',
        'district_name',
        'palika_name',
        'interviewed_persons',
        'entry_date',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\Models\AdminUser', 'facility_user_id');
    }

    public function siteQuestions()
    {
        return $this->hasMany('App\Models\SiteDeliveryQuestions', 'site_delivery_id');
    }
    public function facility()
    {
        return $this->belongsTo('App\Models\Facility', 'facility_id');
    }

}
