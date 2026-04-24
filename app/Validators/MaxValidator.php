<?php
namespace Validators;

use Src\Validator\AbstractValidator;

class MaxValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно быть не больше :max';

    public function rule(): bool
    {
        $max = (float)($this->args[0] ?? 0);
        return (float)$this->value <= $max;
    }

    protected function messageError(): string
    {
        $msg = parent::messageError();
        return str_replace(':max', $this->args[0] ?? '0', $msg);
    }
}
