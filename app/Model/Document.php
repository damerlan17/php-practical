<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'documents';
    protected $fillable = ['inn',
        'snils',
        'payment_account',
        'tabel_name'];

    // Связь с пользователем (один к одному)
    public function user()
    {
        return $this->hasOne(User::class, 'document_id', 'document_id');
    }
}