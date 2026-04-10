<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;


class User extends Model implements IdentityInterface
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'first_name',
        'login',
        'password',
        'last_name',
        'surname',
        'document_id',
        'role_id',
        'position_id',
    ];
    protected static function booted()
    {
        static::created(function ($user) {
            $user->password = md5($user->password);
            $user->save();
        });
    }

    // Выборка пользователя по первичному ключу
    public function findIdentity(int $id)
    {
        return self::where('id', $id)->first();
    }

    // Возврат первичного ключа
    public function getId(): int
    {
        return $this->id;
    }

    // Возврат аутентифицированного пользователя
    public function attemptIdentity(array $credentials)
    {
        return self::where(['login' => $credentials['login'],
            'password' => md5($credentials['password'])])->first();
    }

    // Связь с должностью
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'position_id');
    }

    // Связь с удержанием
    public function deduction()
    {
        return $this->belongsTo(Deduction::class, 'deduction_id', 'deduction_id');
    }

    // Связь с документами
    public function document() {
        return $this->belongsTo(Document::class, 'document_id', 'document_id');
    }

    // Связь с отчётами по зарплате
    public function payrollReports()
    {
        return $this->hasMany(PayrollReport::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }
}