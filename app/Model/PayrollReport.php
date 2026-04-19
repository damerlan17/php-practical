<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollReport extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'payroll_reports';
    protected $primaryKey = 'report_id';   // исправлено
    protected $fillable = [
        'user_id',
        'date_report',
        'total_accued',
        'total_deducted',
        'final_sum'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}