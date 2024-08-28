<?php
namespace Ai;

require_once('./vendor/autoload.php');

class textModeration {
  
  private $client;

  public function __construct()
  {
    $this->client = new \GuzzleHttp\Client();
  }
  
  
    public function isSafe($text, $lang) {
$response = $this->client->request('POST', 'https://api.edenai.run/v2/text/moderation', [
  'body' => '{"response_as_dict":true,"attributes_as_list":false,"show_base_64":true,"show_original_response":false,"providers":"openai","language":"'.$lang.'","text":"'.$text.' test"}',
  'headers' => [
    'accept' => 'application/json',
    'authorization' => 'Bearer my secret api key',
    'content-type' => 'application/json',
  ],
]);

$Arrayresponse = $response->getBody();

$data = json_decode($Arrayresponse, true);

$label = [];

    foreach ($data['openai']['items'] as $item) {
        if ($item['likelihood'] >= 4) {
        $label[] = $item['label'];
        }
    }

return $label;
}


    
}
