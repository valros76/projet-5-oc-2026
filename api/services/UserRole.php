<?php
class UserRole
{
  public static function get(UserI $user): RoleE
  {
    return $user->isAdmin() ? RoleE::ADMIN : RoleE::GUEST;
  }
}
