<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'deductions';
    protected $primaryKey = 'deduction_id';   // важно!
    protected $fillable = [
        'deduction_name',
        'amount_deduction'
    ];
}