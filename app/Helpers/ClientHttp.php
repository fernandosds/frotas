<?php

use Illuminate\Support\Facades\Http;

/**
 * @param String $url
 * @param String|NULL $https
 * @param array $post
 * @return array;
 */
function ClientHttp(String $url, array $post = [])
{

    $baseRequest = Http::withHeaders(['Content-Type' => 'application/json'])
                                    ->withOptions(['verify' => false])
                                    ->timeout(120);

    if (!empty($post)) {
        $response = $baseRequest->post($url, $post);
    } else {
        $response = $baseRequest->get($url);
    }

    return $response->json();
}

function ClientHttpImg(String $url)
{

    $baseRequest = Http::timeout(120);

    if (!empty($post)) {
        $response = $baseRequest->post($url, $post);
    } else {
        $response = $baseRequest->get($url);
    }
    return $response;
}