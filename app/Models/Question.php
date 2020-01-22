<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'part',
        'part_name',
        'part_description',
        'type',
        'type_name',
        'type_description',
        'sub_type',
        'sub_type_name',
        'sub_type_description',
        'sort_order',
        'status',
    ];

    public function scopeByStatus($query, $status = 1) {
        return $query->where($this->table . '.status', $status);
    }

    public function questionList()
    {
        return $this->hasMany('App\Models\QuestionList', 'question_id');
    }
}
