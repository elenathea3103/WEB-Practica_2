<?php

class OrderItemDTO
{
    private $id;
    private $orderId;
    private $productId;
    private $quantity;
    private $priceAtPurchase;

    public function __construct($productId, $quantity, $priceAtPurchase, $orderId = null, $id = null)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->priceAtPurchase = $priceAtPurchase;
        $this->orderId = $orderId;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getOrderId()
    {
        return $this->orderId;
    }
    public function getProductId()
    {
        return $this->productId;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function getPriceAtPurchase()
    {
        return $this->priceAtPurchase;
    }
}