<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = 'resource';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'file',
        'description',
        'files',
        'created_by',
        'status',
    ];

    public $timestamps = true;

    public function scopeByStatus($query, $status = 1) {
        return $query->where($this->table . '.status', $status);
    }
}
