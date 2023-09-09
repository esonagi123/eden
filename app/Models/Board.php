<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;
	protected $table = 'boards';
	protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'menu_id', 'board_name', 'message', 'secret_option', 'secret'
    ];		
}
