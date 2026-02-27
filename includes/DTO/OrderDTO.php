<?php

class OrderDTO
{
    private $id;
    private $dailyNumber;
    private $userId;
    private $orderDate;
    private $type;
    private $status;
    private $totalPrice;

    public function __construct($userId, $type, $totalPrice, $dailyNumber = null, $status = 'New', $id = null, $orderDate = null)
    {
        $this->userId = $userId;
        $this->type = $type;
        $this->totalPrice = $totalPrice;
        $this->dailyNumber = $dailyNumber;
        $this->status = $status;
        $this->id = $id;
        $this->orderDate = $orderDate;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getDailyNumber()
    {
        return $this->dailyNumber;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function getOrderDate()
    {
        return $this->orderDate;
    }
    public function getType()
    {
        return $this->type;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }
}