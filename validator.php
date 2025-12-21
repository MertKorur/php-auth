<?php
class Validator
{
    public const ERR_USERNAME_FORMAT = "Username must be 3-20 characters long and can only contain letters, numbers, and underscores.";
    public const ERR_PASSWORD_LENGTH = "Password must at least be 8 characters long.";
    public const ERR_EMAIL_FORMAT = "Invalid email format.";
    public const ERR_PASSWORD_MATCH = "Passwords do not match.";
    public const ERR_PASSWORD_UPPER = "Password must contain at least one uppercase letter.";
    public const ERR_PASSWORD_LOWER = "Password must contain at least one lowercase letter.";
    public const ERR_PASWORD_NUM = "Password must contain at least one number.";

    private array $errors = [];

    public function required(string $key, string $value, ?string $message = null): void
    {
        if (trim($value) === "") {
            $this->errors[$key] = $message ?? "{$key} is required.";
        }
    }

    public function username(string $key, string $value): void
    {
        if (!preg_match("/^[a-zA-Z0-9_]{3,20}$/", $value)) {
            $this->errors[$key] = self::ERR_USERNAME_FORMAT;
        }
    }

    public function email(string $key, string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$key] = self::ERR_EMAIL_FORMAT;
        }
    }

    public function password(string $key, string $value): void
    {
        if (strlen($value) < 8) {
            $this->errors[$key] = self::ERR_PASSWORD_LENGTH;
        }

        if (!preg_match('/[A-Z]/', $value)) {
            $this->errors[$key] = self::ERR_PASSWORD_UPPER;
        }

        if (!preg_match('/[a-z]/', $value)) {
            $this->errors[$key] = self::ERR_PASSWORD_LOWER;
        }

        if (!preg_match('/[0-9]/', $value)) {
            $this->errors[$key] = self::ERR_PASWORD_NUM;
        }
    }

    public function match(string $key, string $value1, string $value2, ?string $message = null): void
    {
        if ($value1 !== $value2) {
            $this->errors[$key] = $message ?? self::ERR_PASSWORD_MATCH;
        }
    }

    public function fails(): bool
    {
        return count($this->errors) > 0;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}