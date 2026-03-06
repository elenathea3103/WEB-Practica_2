<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$user_role = isset($_SESSION['user_role']) ? strtolower($_SESSION['user_role']) : '';

if ($user_role !== 'admin' && $user_role !== 'manager') {
   
    die("Access Denied: You do not have the right permissions to manage categories.");
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_category'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $desc = $conn->real_escape_string($_POST['description']);
    $conn->query("INSERT INTO categories (name, description) VALUES ('$name', '$desc')");
    header("Location: manage_categories.php?success=1");
    exit();
}

$categories = $conn->query("SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories - Bistro</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 30px; background: #fdf2f4; }
        .container { max-width: 900px; margin: auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
        h2 { color: #333; border-bottom: 2px solid #cca3bb; padding-bottom: 10px; }
        .form-section { background: #fef9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #f2dae5; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #eee; padding: 12px; text-align: left; }
        th { background: #cca3bb; color: white; }
        .btn-add { background: #cca3bb; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-add:hover { background: #b089a0; }
        input, textarea { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .back-link { display: inline-block; margin-top: 20px; color: #b089a0; text-decoration: none; }
    </style>
</head>
<body>
<div style="margin: 15px 0;">
    <a href="index.php" style="
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        color: #fff;
        background-color: #cca3bb; /* Rozul bistro-ului tău */
        padding: 10px 20px;
        border-radius: 5px;
        font-family: 'Segoe UI', sans-serif;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    ">
        <span style="margin-right: 8px;">🏠</span> Back 
    </a>
</div>
<div class="container">
    <h2>Category Management</h2>
    
    <div class="form-section">
        <h3>Add New Category</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="Category Name (e.g., Pizza, Drinks)" required>
            <textarea name="description" placeholder="Description of this category..." rows="2"></textarea>
            <button type="submit" name="add_category" class="btn-add">Add Category</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($c = $categories->fetch_assoc()): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><strong><?= htmlspecialchars($c['name']) ?></strong></td>
                <td><?= htmlspecialchars($c['description']) ?></td>
                <td>
                    <a href="delete_category.php?id=<?= $c['id'] ?>" 
                       style="color: #d9534f; text-decoration: none;"
                       onclick="return confirm('Warning: Products in this category might become unclassified. Continue?')">
                       Delete
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
    <a href="product_list.php" class="back-link">← Back to Product List</a>
</div>

</body>
</html>