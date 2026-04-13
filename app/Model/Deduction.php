<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'deductions';
    protected $fillable = [
        'deduction_name',
        'amount_deduction'
    ];

    // Связь с пользователями (один ко многим)
    public function users()
    {
        return $this->hasMany(User::class, 'deduction_id', 'deduction_id');
        return $this->belongsToMany(User::class, 'user_deductions', 'deduction_id', 'user_id');

    }

}