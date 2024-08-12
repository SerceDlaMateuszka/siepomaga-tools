<?php declare(strict_types=1);

function getCampaignData($id)
{
    $url = sprintf("https://www.siepomaga.pl/api/v2/permalinks/%s?locale=pl", $id);
    $json = @file_get_contents($url);
    if ($json === false) {
        return null;
    }

    try {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        return $data ?? null;
    } catch (JsonException $e) {
        return null;
    }
}

$id = $_GET['id'] ?? null;
$data = $id ? getCampaignData($id) : [];
header("Cache-Control: max-age=300, must-revalidate");
echo $data['data']['target']['fundraise']['funds_current'] ?? 0;
