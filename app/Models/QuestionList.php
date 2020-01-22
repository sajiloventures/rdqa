<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionList extends Model
{
    protected $table = 'questions_list';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'question_id',
        'question',
        'question_note',
        'if_not_question',
        'compare_result',
        'compare_type',
        'question_type',
        'sort_order',
        'status',
    ];

    public function scopeByStatus($query, $status = 1) {
        return $query->where($this->table . '.status', $status);
    }
}
