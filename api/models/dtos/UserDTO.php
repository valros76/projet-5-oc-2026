<?php
readonly class UserDTO implements UserI
{

    public function __construct(
        public int $id,
        public string $email,
        public bool $is_admin,
        public ?string $inscription_date = null
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }
    public function getInscriptionDate(): string
    {
        return $this->inscription_date;
    }
}