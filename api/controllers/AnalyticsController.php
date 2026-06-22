<?php
class AnalyticsController
{

    private static function connect()
    {
        return new Analytics(BDD::getInstance(Config::getConfig()));
    }

    public function SaveEvent()
    {
        $json  = file_get_contents('php://input');
        $datas = json_decode($json);

        $event_name = $datas->event_name;
        $page_url   = $datas->page_url;
        $metadata   = $datas->metadata;

        try {
            $analytics = new Analytics(BDD::getInstance(Config::getConfig()));
            if (! $analytics->saveEvent($event_name, $page_url, $metadata)) {
                JSON::response("Une erreur s'est produite lors du log de l'évènement.", 400, [
                    "event_name" => $event_name,
                    "page_url"   => $page_url,
                    "metadata"   => $metadata,
                ]);
            }

            JSON::response("L'évènement a été loggué en BDD.", 200, [
                "event_name" => $event_name,
                "page_url"   => $page_url,
                "metadata"   => $metadata,
            ]);
        } catch (Exception $e) {
            JSON::response("Une erreur s'est produite lors du log de l'évènement.", 400, [
                "event_name" => $event_name,
                "page_url"   => $page_url,
                "metadata"   => $metadata,
                "error"      => $e->getMessage(),
            ]);
        }
    }

    public function ViewEvents()
    {
        $offset    = isset($_GET["offset"]) && ! empty($_GET["offset"]) ? intval($_GET["offset"]) : 0;
        $limit     = isset($_GET["limit"]) && ! empty($_GET["limit"]) ? intval($_GET["limit"]) : 250;
        $analytics = new Analytics(BDD::getInstance(Config::getConfig()));
        $datas = $analytics->viewEvents($offset, $limit);
        $datas_ids = array_column($datas, "id");
        $max_id = !empty($datas_ids) ? max($datas_ids) : 0;
        JSON::response("Récupération des derniers évènements réussie !", 200, [
            "max_id" => $max_id,
            "datas" => $datas
        ]);
    }

    public function CountEvents()
    {
        $analytics = self::connect();
        $count     = intval($analytics::countEvents());
        JSON::response("Récupération du nombre d'évènements existants en BDD.", 200, [
            "events_count" => $count,
        ]);
    }
}
