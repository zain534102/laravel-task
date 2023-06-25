<?php

namespace App\Models;

use App\Modules\Common\Model\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
    ];
}
