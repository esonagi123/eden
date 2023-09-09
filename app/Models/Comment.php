<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;
	protected $table = 'comments';
	protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'board_id', 'document_id', 'comment', 'name', 'pwd', 'date'
    ];
}
