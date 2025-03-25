<?php

namespace Helpers;

use Exception;

class Request
{
    protected array $rules = [];
    protected array $errors = [];
    protected array $validatedData = [];

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    public function validate(array $data): array
    {
        foreach ($this->rules as $field => $conditions) {
            $value = $data[$field] ?? null;

            foreach (explode('|', $conditions) as $rule) {
                if ($rule === 'required' && empty($value)) {
                    $this->addError($field, "The $field field is required.");
                }

                if (str_starts_with($rule, 'min:')) {
                    $min = (int) str_replace('min:', '', $rule);
                    if (strlen($value) < $min) {
                        $this->addError($field, "The $field must be at least $min characters.");
                    }
                }

                if (str_starts_with($rule, 'max:')) {
                    $max = (int) str_replace('max:', '', $rule);
                    if (strlen($value) > $max) {
                        $this->addError($field, "The $field must not exceed $max characters.");
                    }
                }

                if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "The $field must be a valid email address.");
                }

                if ($rule === 'numeric' && !is_numeric($value)) {
                    $this->addError($field, "The $field must be a number.");
                }

                if ($rule === 'alpha' && !ctype_alpha($value)) {
                    $this->addError($field, "The $field must contain only letters.");
                }

                if ($rule === 'boolean' && !in_array($value, [0, 1, '0', '1', true, false], true)) {
                    $this->addError($field, "The $field must be a boolean value.");
                }
                if ($rule === 'yes_or_no' && !in_array(strtolower($value), ['yes', 'no'])) {
                    $this->addError($field, "The $field must be either 'yes' or 'no'.");
                }
                if ($rule === 'decimal' && !preg_match('/^\d+(\.\d+)?$/', $value)) {
                    $this->addError($field, "The $field must be a valid decimal number.");
                }
            }

           

            if (!isset($this->errors[$field])) {
                $this->validatedData[$field] = $value;
            }
        }
        
        return [
            'errors' => $this->errors,
            'data' => $this->validatedData
        ];
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    protected function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }
}