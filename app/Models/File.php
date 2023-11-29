<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class File extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file',
        'assigned_to',
        'download_link',
        'expires_at',
    ];
}
