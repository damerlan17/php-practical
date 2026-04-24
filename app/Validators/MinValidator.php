<?php
namespace Validators;

use Src\Validator\AbstractValidator;

class MinValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно быть не меньше :min';

    public function rule(): bool
    {
        $min = (float)($this->args[0] ?? 0);
        return (float)$this->value >= $min;
    }

    protected function messageError(): string
    {
        $msg = parent::messageError();
        return str_replace(':min', $this->args[0] ?? '0', $msg);
    }
}