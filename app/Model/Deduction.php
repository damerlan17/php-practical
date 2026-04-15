<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'deductions';
    protected $primaryKey = 'deduction_id';
    protected $fillable = [
        'deduction_name',
        'amount_deduction'
    ];

    // Связь с пользователями (многие ко многим)
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_deductions', 'deduction_id', 'user_id');
    }
}