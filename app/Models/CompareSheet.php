<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompareSheet extends Model
{
    protected $table = 'compare_sheet';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'name_2',
        'description',
        'user_id',
        'status',
    ];

    public $timestamps = true;

    public function scopeByStatus($query, $status = 1) {
        return $query->where($this->table . '.status', $status);
    }
}
