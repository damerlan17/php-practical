<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public $timestamps = false;          // отключаем created_at и updated_at
    protected $table = 'documents';
    protected $primaryKey = 'document_id';
    protected $fillable = [
        'inn', 'snils', 'payment_account', 'tabel_name'
    ];
}