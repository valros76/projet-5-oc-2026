<?php
enum RoleE: string{
  case ADMIN = "ROLE_ADMIN";
  case GUEST = "ROLE_GUEST";

  public function isAdmin(): bool{
    return $this === self::ADMIN;
  }

  public function canAccessToAdmin(): bool{
    return $this->isAdmin();
  }

  public function canEditPost(): bool{
    return $this->isAdmin();
  }
}