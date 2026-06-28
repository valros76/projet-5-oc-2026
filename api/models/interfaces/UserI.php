<?php
interface UserI
{
    public function getId(): int;
    public function getEmail(): string;
    public function isAdmin(): bool;
}