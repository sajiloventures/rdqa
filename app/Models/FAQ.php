<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    protected $table = 'faq';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question',
        'answer',
        'sort_order',
        'status',
        'created_by',
    ];

    public function scopeByStatus($query, $status = 1) {
        return $query->where($this->table . '.status', $status);
    }
}
