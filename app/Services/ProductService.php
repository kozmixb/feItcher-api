<?php

namespace App\Services;

class ProductService
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var \App\Service\ApiHandler
     */
    private $api;

    /**
     * define api base url for where we can grab products from
     */
    public function __construct(ApiHandler $api)
    {
        $this->baseUrl = config('api.base_url');
        $this->api = $api;
    }

    /**
     * get products form api
     * 
     * @return array
     */
    public function list(): array
    {
        $url = $this->baseUrl . 'list';
        $data = $this->api->fetch($url);
        return $data;
    }

    /**
     * get product info from api
     * 
     * @param string $productId
     * @return array
     */
    public function show(string $productId): array
    {
        $url = $this->baseUrl . "info?id=$productId";
        $data = $this->api->fetch($url);
        return $data;
    }
}
