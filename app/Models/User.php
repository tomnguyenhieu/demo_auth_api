<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = [
        'email',
        'password',
        'role',
        'status',
        'avatar',
        'information_id',
        'score',
        'total_score'
    ];

    public function information()
    {
        return $this->hasOne(Information::class, 'id', 'information_id');
    }
}
