<?php
readonly class UserCreateDTO
{
    public function __construct(
        public string $email,
        public string $password,
        public bool $is_admin
    ) {}

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }
}