<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['url', 'title', 'description'];
}
