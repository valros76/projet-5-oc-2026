<?php
class Analytics
{
    private static PDO $bdd;

    public function __construct($bdd = null)
    {
        if (! is_null($bdd)) {
            self::setBdd($bdd);
        }
    }

    public static function saveEvent($event_name, $page_url, $metadata)
    {
        $req = self::$bdd->prepare("INSERT INTO analytics_events(event_name, page_url, metadata) VALUES(:event_name, :page_url, :metadata)");
        $req->bindValue(":event_name", $event_name, PDO::PARAM_STR);
        $req->bindValue(":page_url", $page_url, PDO::PARAM_STR);
        $encodedMetadatas = json_encode($metadata);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Données metadata invalides : " . json_last_error_msg());
        }
        $req->bindValue(":metadata", $encodedMetadatas, PDO::PARAM_STR);

        return $req->execute();
    }

    public static function viewEvents(int $offset, int $limit = 250)
    {

        $sql = "SELECT id, event_name, page_url, metadata, created_at
            FROM analytics_events ORDER BY id DESC, created_at DESC LIMIT :limit OFFSET :offset";

        $offset = intval($offset) * intval($limit);
        $req = self::$bdd->prepare($sql);
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        $req->bindValue(':offset', $offset, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_OBJ);
    }

    public static function countEvents()
    {
        return self::$bdd->query("SELECT COUNT(id) FROM analytics_events")->fetchColumn();
    }

    private static function setBdd(PDO $bdd)
    {
        self::$bdd = $bdd;
    }
}
