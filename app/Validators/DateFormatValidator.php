<?php
namespace Validators;

use Src\Validator\AbstractValidator;
use DateTime;

class DateFormatValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно соответствовать формату :format';

    public function rule(): bool
    {
        $format = $this->args[0] ?? 'Y-m-d';
        $date = DateTime::createFromFormat($format, $this->value);
        return $date && $date->format($format) === $this->value;
    }

    protected function messageError(): string
    {
        $msg = parent::messageError();
        return str_replace(':format', $this->args[0] ?? 'Y-m-d', $msg);
    }
}