<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionAllowance extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'position_allowances';
    protected $primaryKey = 'id_allowance_position';
    protected $fillable = [
        'allowance_id'
    ];

    // Связь с надбавкой
    public function allowance()
    {
        return $this->belongsTo(Allowance::class, 'allowance_id', 'allowance_id');
    }

    // Связь с должностью (один к одному, так как внешний ключ в positions)
    public function position()
    {
        return $this->hasOne(Position::class, 'id_allowance_position', 'id_allowance_position');
    }
}