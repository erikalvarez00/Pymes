<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Closed_answer extends Model
{
    protected $fillable = ['id_question', 'closed_answer'];
    protected $primaryKey = 'id_closed_answer';
}
