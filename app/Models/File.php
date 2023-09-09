<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
	protected $table = 'files';
	protected $primaryKey = 'id';
    protected $fillable = [
        'targetType', 'targetID', 'menuID', 'memberID', 'fileName', 'original_fileName', 'fileSize', 'src', 'regDate', 'valid'
    ];	
	
}
