<?php
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec("CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            is_admin BOOLEAN DEFAULT 0,
            inscription_date DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        Model::setBdd($this->pdo);
    }

    public function testAddUser()
    {
        $userDTO = new UserCreateDTO("test@example.com", "secret", false);
        $result = User::add($userDTO, "hashed_password");

        $this->assertTrue($result);
        
        $user = User::getByEmail("test@example.com");
        $this->assertEquals("test@example.com", $user->getEmail());
        $this->assertFalse($user->isAdmin());
    }

    public function testAuthFailure()
    {
        $hash = password_hash("password123", PASSWORD_DEFAULT);
        $this->pdo->exec("INSERT INTO users (email, password, is_admin) VALUES ('test@test.com', '$hash', 0)");

        $user = User::auth("test@test.com");
        
        $this->assertNotNull($user);
        $this->assertFalse(password_verify("wrong_password", $user->password));
    }
}