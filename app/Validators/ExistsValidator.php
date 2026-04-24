<?php
namespace Validators;

use Illuminate\Database\Capsule\Manager as Capsule;
use Src\Validator\AbstractValidator;

class ExistsValidator extends AbstractValidator
{
    protected string $message = 'Выбранное значение для :field не существует';

    public function rule(): bool
    {
        $table = $this->args[0] ?? null;
        $column = $this->args[1] ?? $this->field;
        if (!$table) return true;

        $count = Capsule::table($table)->where($column, $this->value)->count();
        return $count > 0;
    }
}