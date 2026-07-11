<?php
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec("CREATE TABLE sav (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            message_from VARCHAR(750) NOT NULL,
            message_to VARCHAR(750) NOT NULL,
            subject VARCHAR(3500) NOT NULL,
            content MEDIUMTEXT NOT NULL,
            creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        )");

        Model::setBdd($this->pdo);
    }

    public function testAddMessage()
    {
        $result = Contact::add(
            "client@test.com", 
            "admin@site.com", 
            "Sujet de test", 
            "Contenu du message"
        );

        $this->assertTrue($result);

        $stmt = $this->pdo->query("SELECT * FROM sav");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals("client@test.com", $data['message_from']);
        $this->assertEquals("Sujet de test", $data['subject']);
    }

    public function testGetList()
    {
        Contact::add("a@test.com", "b@test.com", "Sujet 1", "Contenu 1");
        Contact::add("c@test.com", "d@test.com", "Sujet 2", "Contenu 2");

        $list = Contact::getList();
        
        $this->assertCount(2, $list);
        $this->assertEquals("Sujet 1", $list[0]->subject);
    }
}