<?php

class User extends Model
{
    private static function map(stdClass $user): UserDTO
    {
        return new UserDTO(
            (int) $user->id,
            $user->email,
            (bool) $user->is_admin,
            $user->inscription_date
        );
    }

    public static function add(UserCreateDTO $user, string $hashedPassword): bool
    {
        $req = self::getBdd()->prepare("INSERT INTO users(email, password, is_admin) VALUES(:email, :password, :is_admin)");
        $req->bindValue(":email", $user->email, PDO::PARAM_STR);
        $req->bindValue(":password", $hashedPassword, PDO::PARAM_STR);
        $req->bindValue(":is_admin", $user->isAdmin(), PDO::PARAM_BOOL);

        return $req->execute();
    }

    public static function getById(int $id): ?UserDTO
    {
        $req = self::getBdd()->prepare("SELECT id, email, is_admin, inscription_date FROM users WHERE id=:id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        $req->execute();
        $user = $req->fetch(PDO::FETCH_OBJ);

        return $user ? self::map($user) : null;
    }

    public static function getByEmail(string $email): ?UserDTO
    {
        $req = self::getBdd()->prepare("SELECT id, email, is_admin, inscription_date FROM users WHERE email=:email");
        $req->bindValue(":email", $email, PDO::PARAM_STR);
        $req->execute();
        $user = $req->fetch(PDO::FETCH_OBJ);

        return $user ? self::map($user) : null;
    }

    public static function auth(string $email): ?stdClass
    {
        $req = self::getBdd()->prepare("SELECT * FROM users WHERE email=:email");
        $req->bindValue(":email", $email, PDO::PARAM_STR);
        $req->execute();
        return $req->fetch(PDO::FETCH_OBJ) ?: null;
    }
}
