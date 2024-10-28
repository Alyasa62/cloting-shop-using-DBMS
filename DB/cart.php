<!DOCTYPE html>
<html>

<head>
    <title>Shopping Cart</title>
</head>
<style>
    body {
        background-color: while;
        font-family: Arial, sans-serif; 
        margin: 0;  
        padding: 0;
    }
    header, nav, main, footer {
        padding: 10px;      

    }
    header, nav, main, footer {
        background-color: white;
    } 
    header, nav, main {
        margin: 0 auto;
        max-width: 800px;
        min-width: 300px;
    }
    header {
        margin-bottom: 10px;
        text-align: center;
    } 
    table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 10px;
        margin-top: 10px;
        border: 1px solid #dddddd;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        
    }
    tr {
        border-bottom: 1px solid #dddddd;
    }
    th {
        font-weight: bold;
    }
    th, td {
        text-align: left;
        padding: 8px;
        border-right: 1px solid #dddddd;
        border-bottom: 1px solid #dddddd;       
        border-left: 1px solid #dddddd;
        border-top: 1px solid #dddddd;
        border-collapse: collapse;
        width: 100%;    
        height: 100%;       
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        padding: 10px;
        font-size: 14px;
        vertical-align: top;

    }
    th {
        background-color: #dddddd;
        color: black;
        font-weight: bold;
        text-align: center;
        padding: 10px;
        font-size: 16px;
        vertical-align: top;    
        border-right: 1px solid #dddddd;
        border-bottom: 1px solid #dddddd;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;  

    }
    tr:hover {
        background-color: #ddd;

    }   
    footer {
        text-align: center;
        padding: 10px;
        background-color: white;
        color: black;
        font-weight: bold;
        font-size: 14px;

    }   
    .button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 5px;

    }
    .button:hover {
        opacity: 0.8;

    }
    footer {
        background-color: green;
        margin-top: 348px;
        color: black;
        max-width: 264px;
        min-width: 264px;

    }
</style>

<body>
    <header>
        <h1>
            <?php 
            // Check if a session is already started
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if (isset($_SESSION['user'])) {
                $user = $_SESSION['user'];
                echo htmlspecialchars($user['name']) . " Shopping Cart";
            } else {
                echo "Guest Shopping Cart";
            }
            ?>
        </h1>
    </header>

    <nav>
        <ul>
            <li>
                <a href="shop.html">Home</a>
            </li>
            <li>
                <a href="shop.html">Products</a>
            </li>
            <li>
                <a href="mailto:adarsh.raj.2004@outlook.com">Contact Us</a>
            </li>
            <li>
                <a href="cart.php">Cart</a>
            </li>
        </ul>
    </nav>

    <main>
        <section>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "website_commerce";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $total = 0;

                // Check if the cart is set and is not empty
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    // Loop through items in cart and display in table
                    foreach ($_SESSION['cart'] as $product_id => $quantity) {
                        $sql = "SELECT * FROM products WHERE id = $product_id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $name = $row['name'];
                            $price = $row['price'];
                            $item_total = $quantity * $price;
                            $total += $item_total;

                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($name) . "</td>";
                            echo "<td>" . htmlspecialchars($quantity) . "</td>";
                            echo "<td>" . htmlspecialchars($price) . " $</td>";
                            echo "<td>" . htmlspecialchars($item_total) . " $</td>";
                            echo "</tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='4'>Your cart is empty.</td></tr>";
                }

                // Display total
                echo "<tr>";
                echo "<td colspan='3'>Total:</td>";
                echo "<td>" . htmlspecialchars($total) . " $</td>";
                echo "</tr>";
                ?>
            </table>
            <form action="checkout.php" method="post">
                <input type="submit" value="Checkout" class="button" />
            </form>
        </section>
    </main>

    <footer>
        <p>&COPY;2023 GFG Shopping Web Application</p>
    </footer>
</body>

</html>
