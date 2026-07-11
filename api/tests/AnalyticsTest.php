<?php
use PHPUnit\Framework\TestCase;

class AnalyticsTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec("CREATE TABLE analytics_events (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            event_name VARCHAR(750) NOT NULL,
            page_url TEXT NOT NULL,
            metadata TEXT NOT NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public function testSaveEventInsertsDataCorrectly()
    {
        $analytics = new Analytics($this->pdo);
        
        $eventName = "button_click";
        $pageUrl = "/home";
        $metadata = ["user_id" => 123, "browser" => "chrome"];
        
        $result = $analytics->saveEvent($eventName, $pageUrl, $metadata);
        
        $this->assertTrue($result);

        $stmt = $this->pdo->query("SELECT * FROM analytics_events");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals($eventName, $row['event_name']);
        $this->assertEquals(json_encode($metadata), $row['metadata']);
    }

    public function testSaveEventThrowsExceptionOnInvalidJson()
    {
        $this->expectException(Exception::class);
        
        $analytics = new Analytics($this->pdo);
        $analytics->saveEvent("error", "/url", ["data" => fopen('php://memory', 'r')]);
    }

    public function testViewEventsReturnsCorrectStructure()
    {
        $analytics = new Analytics($this->pdo);
        $analytics->saveEvent('ev1', '/p1', []);
        
        $results = $analytics->viewEvents(0, 1);
        
        $this->assertIsArray($results);
        $this->assertObjectHasProperty('event_name', $results[0]);
    }
}