<?php
//require __DIR__ . '/../vendor/autoload.php'; 

use GuzzleHttp\Client;
use GuzzleHttp\Promise;

function getPriceAsync($stockSymbol){
    $client = new Client();
    // $res = $client->request('GET', 'https://api.github.com/user', [
    //     'auth' => ['user', 'pass']
    // ]);
    $urls =[
        "https://api1.com/price?symbol=$stockSymbol",
        "https://api2.com/price?symbol=$stockSymbol",
        "https://api3.com/price?symbol=$stockSymbol"
    ];

    $promise =[];
    foreach ($urls as $url){
        $promise = $client->getAsync($url);
    }
    //result
    $results = Promise\Utils::settle($promise)->wait();

    foreach($results as $result){
        $data = $result["value"]->getBody();
        if(isset($data['price'])){
            $price[] = $data["price"];
        }
    }
    $divisor = count($price);
    $sum = array_sum($price);

    return $divisor> 0 ?$sum/$divisor : 0;
}   

//getPriceAsync("mmm");