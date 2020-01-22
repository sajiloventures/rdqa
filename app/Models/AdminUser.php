<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'first_name',
        'last_name',
        'password',
        'province',
        'district',
        'municipality',
        'health_post_name',
        'register_token',
        'enabled',
        'province_user_id',
        'district_user_id',
        'palika_user_id',
        'hf_user',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeFilterByRole($query)
    {
        if (\AclHelper::getUserRole() == 'palika-user')
            $query->where($this->table . '.palika_user_id', auth()->user()->id);

        return $query;
    }

    public function scopeByStatus($query, $status = 1)
    {
        return $query->where($this->table . '.enabled', $status);

    }

}
