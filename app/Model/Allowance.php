<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'allowances';
    protected $primaryKey = 'allowance_id';
    protected $fillable = [
        'name_allowance',
        'precent_allowance'
    ];

    // Связь "многие ко многим" с должностями через промежуточную таблицу position_allowances
    public function positions()
    {
        return $this->belongsToMany(Position::class, 'position_allowances', 'allowance_id', 'id_allowance_position');
    }
}