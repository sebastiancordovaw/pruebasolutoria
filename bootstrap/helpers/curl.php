<?php
    use Illuminate\Support\Facades\Http;
use PhpParser\Node\Expr\Cast\Array_;

    function curl(string $url,Array $head,string $type, Array $post = [])
    {
        $apiURL = $url;
        // Headers
        $headers = $head;
        // POST
        $postInput = $post;

        if($type == "post")
        {
            $response = Http::withHeaders($headers)->post($apiURL, $postInput);
        }
        else if($type == "get")
        {
            $response = Http::withHeaders($headers)->get($apiURL, $postInput);
        }

        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);

        return ["code"=>$statusCode,"body"=>$responseBody];

    }


?>
