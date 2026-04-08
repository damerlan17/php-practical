<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'roles';
    protected $fillable = [
        'role_name'
    ];

    // Связь с пользователями (один ко многим)
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }
}