<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $table = 'informations';
    protected $fillable = [
        'name',
        'birth',
        'gender',
        'phone',
        'address',
        'citizen_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
