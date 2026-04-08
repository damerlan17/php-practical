<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'positions';
    protected $fillable = [
        'id_allowance_position',
        'base_salary'
    ];

    // Связь с промежуточной таблицей position_allowances (должность имеет одну запись в связке)
    public function positionAllowance()
    {
        return $this->belongsTo(PositionAllowance::class, 'id_allowance_position', 'id_allowance_position');
    }

    // Доступ к надбавке через промежуточную таблицу
    public function allowance()
    {
        return $this->hasOneThrough(
            Allowance::class,
            PositionAllowance::class,
            'id_allowance_position', // внешний ключ в position_allowances
            'allowance_id',          // внешний ключ в allowances
            'id_allowance_position', // локальный ключ в positions
            'allowance_id'           // локальный ключ в position_allowances
        );
    }

    // Связь с пользователями (один ко многим)
    public function users()
    {
        return $this->hasMany(User::class, 'position_id', 'position_id');
    }
}