<?php
session_start();
require_once("../controllers/search_controller.php");
require_once("../controllers/cat_controller.php");
require_once("../settings/core.php");
require_once("../controllers/cart_controller.php");


$id = $_SESSION['user_id'];
$name = $_SESSION['user_name'];
$email  = $_SESSION['email'];




if (isset($_GET['search'])) {
    $search_query = trim($_GET['search']);

}
$cart_items = get_cart_items($id);
$num =  count($cart_items);

$products = searchItem($search_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbr.css">
    <link rel="stylesheet" href="../css/customer_index.css">

    <link rel="stylesheet" href="../css/side.css">
    
</head>

<body>
   
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #004080;">
        <div class="container-fluid">
           
            <a class="navbar-brand" href="#">POSify</a>

          
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

       
            <div class="collapse navbar-collapse" id="navbarNav">
                
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../home.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index"><i class="fas fa-info-circle"></i> Shop</a>
                    </li>
                </ul>

             
                <ul class="navbar-nav ms-auto align-items-center">
                    
                    <li class="nav-item me-3">
                        <form class="d-flex" action = "../customer/product_search.php" method = "GET">
                            <input class="form-control me-2" type="search" placeholder="Search by product or category" name = 'search' aria-label="Search">
                            <button class="btn btn-outline-light" type="submit">Search</button>
                        </form>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link cart-container" href="../customer/cart_view.php">
                            <i class="fas fa-shopping-cart"></i>
                            <?php if ($num > 0): ?>
                                <span class="cart-badge"><?php echo $num; ?></span>
                            <?php endif; ?>
                            Cart
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle text-white" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <strong><?php echo htmlspecialchars($name); ?></strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="../customer/orders_view.php">Orders</a></li>
                            <li><a class="dropdown-item" href="../login/logout_customer.php">Sign out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    
    <div class="container mt-5 pt-4">
   
        <?php echo getAllsubcat(); ?>
    </div>
    

    <!-- Main Content -->
    <div class="container mt-5 pt-4">
        <h2 class="text-center my-4">Products for: <b style = "color:#004080"> <?php echo $search_query ?></b></h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            if (!empty($products)) {
                foreach ($products as $product) {
                    ?>
                    <div class="col">
                        <div class="card product-card">
                            <img src="../uploads/<?php echo htmlspecialchars($product['img']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="product-price">GHC<?php echo number_format($product['price'], 2); ?></p>
                                <a href="product_detail.php?id=<?php echo $product['product_id']; ?>" class="btn btn-custom btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-muted text-center'>No product found for $search_query </p>";
            }
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Shopify. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>