<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'username'
    ];

    public function user_roles()
    {
        return $this->hasMany(UserRole::class);
    }
}
