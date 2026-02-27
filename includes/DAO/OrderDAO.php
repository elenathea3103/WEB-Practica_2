<?php

class OrderDAO
{

    public function createOrder(OrderDTO $order)
    {
        $app = Applications::getInstance();
        $conn = $app->getConexionBd();

        $today = date('Y-m-d');
        $query = "SELECT MAX(daily_number) as last FROM orders WHERE DATE(order_date) = '$today'";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $nextNumber = ($row['last'] == null) ? 1 : $row['last'] + 1;

        $userId = $order->getUserId();
        $type = $order->getType();
        $total = $order->getTotalPrice();
        $status = 'Received';

        $sql = "INSERT INTO orders (daily_number, user_id, type, total_price, status) 
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisds", $nextNumber, $userId, $type, $total, $status);

        if ($stmt->execute()) {
            return $conn->insert_id;
        }
        return false;
    }

    public function getOrdersByWaiter()
    {
        $app = Applications::getInstance();
        $conn = $app->getConexionBd();

        $sql = "SELECT * FROM orders WHERE status NOT IN ('Delivered', 'Cancelled') ORDER BY order_date DESC";
        $result = $conn->query($sql);

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = new OrderDTO(
                $row['user_id'],
                $row['type'],
                $row['total_price'],
                $row['daily_number'],
                $row['status'],
                $row['id'],
                $row['order_date']
            );
        }
        return $orders;
    }
}