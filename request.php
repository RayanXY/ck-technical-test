<?php
class SimpleJsonRequest
{
    private static function makeRequest(string $method, string $url, array $parameters = null, array &$cache_service = null, array $data = null)
    {
        $opts = [
            'http' => [
                'method'  => $method,
                'header'  => 'Content-type: application/json',
                'content' => $data ? json_encode($data) : null
            ]
        ];

        // Create a new cache to be checked or stored
        $new_request = new Cache('GET', $url, $parameters);

        // Check if the cache already exists
        if (!empty($cache_service)) {
            foreach ($cache_service as $cache) {
                if ($new_request->method == $cache->method &&
                    $new_request->url == $cache->url &&
                    $new_request->parameters == $cache->parameters &&
                    $new_request->data == $cache->data) {
                    return $cache->getResult();
                }
            }
        }

        // At this point the request is not in the cache
        $url .= ($parameters ? '?' . http_build_query($parameters) : '');
        $response = file_get_contents($url, false, stream_context_create($opts));

        // Save the response of this request and cache it
        $new_request->setResponse($response);
        array_push($cache_service, $new_request);

        return $response;
    }

    public static function get(string $url, array &$cache_service, array $parameters = null)
    {
        return json_decode(self::makeRequest('GET', $url, $parameters, $cache_service));
    }

    public static function post(string $url, array &$cache_service, array $parameters = null, array $data)
    {
        return json_decode(self::makeRequest('POST', $url, $parameters, $cache_service, $data));
    }

    public static function put(string $url, array &$cache_service, array $parameters = null, array $data)
    {
        return json_decode(self::makeRequest('PUT', $url, $parameters, $cache_service, $data));
    }

    public static function patch(string $url, array &$cache_service, array $parameters = null, array $data)
    {
        return json_decode(self::makeRequest('PATCH', $url, $parameters, $cache_service, $data));
    }

    public static function delete(string $url, array &$cache_service, array $parameters = null, array $data = null)
    {
        return json_decode(self::makeRequest('DELETE', $url, $parameters, $cache_service, $data));
    }
}
