<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class document extends Model
{
    use HasFactory;
	protected $table = 'documents';
	protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'board_id', 'title', 'content', 'name', 'pwd', 'secret', 'date', 'count'
    ];
}
