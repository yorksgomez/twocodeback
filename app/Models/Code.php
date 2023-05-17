<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Code extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'code',
        'project_id'
    ];

    public function project() : HasOne {
        return $this->hasOne(Project::class);
    }

}
