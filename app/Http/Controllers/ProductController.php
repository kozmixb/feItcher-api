<?php

namespace App\Http\Controllers;

use App\Services\ProductService;

class ProductController extends Controller
{
    /**
     * @var \App\Services\ProductService
     */
    private $service;

    /**
     * Initializing product service
     */
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * List products
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->service->list();
        return response()->json($products);
    }

    /**
     * Show more details of a product
     * 
     * @param string $productId
     * @return \Illuminate\Http\Response
     */
    public function show(string $productId)
    {
        $info = $this->service->show($productId);
        return response()->json($info);
    }
}
