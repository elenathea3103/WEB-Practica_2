<?php
class Product {
    private $id, $name, $description, $category_id, $base_price, $vat, $stock, $is_active, $image_url;

    public function __construct($name, $description, $category_id, $base_price, $vat, $stock = 1, $is_active = 1, $image_url = 'default.png', $id = null) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->category_id = $category_id;
        $this->base_price = $base_price;
        $this->vat = $vat;
        $this->stock = $stock;
        $this->is_active = $is_active;
        $this->image_url = $image_url;
    }

    public static function getAll($conn) {
        $sql = "SELECT p.*, c.name as category_name FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id";
        $result = $conn->query($sql);
        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function save($conn) {
        $n = $conn->real_escape_string($this->name);
        $d = $conn->real_escape_string($this->description);
        $img = $conn->real_escape_string($this->image_url);

        $sql = "INSERT INTO products (name, description, category_id, base_price, vat, stock, is_active, image_url) 
                VALUES ('$n', '$d', '$this->category_id', '$this->base_price', '$this->vat', '$this->stock', '$this->is_active', '$img')";
        return $conn->query($sql);
    }

    public function getName() { return $this->name; }
    public function getBasePrice() { return $this->base_price; }
    public function getVat() { return $this->vat; }
}
?>