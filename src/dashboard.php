<?php
// dashboard.php

require_once __DIR__ . '/../db/connection_db.php';

session_start();

if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    die("Database connection failed. Please try again later.");
}

// Check if the user is logged in
if (!isset($_SESSION['UserID']) || !isset($_SESSION['Username'])) {
    header("Location: ../index.php");
    exit();
}

// Check if the user has the admin role
if (!isset($_SESSION['Role']) || $_SESSION['Role'] !== 'admin') {
    echo "You are not authorized to access this page.";
    exit();
}

$username = $_SESSION['Username'];
$sale_no = 0;

// --- Fetch data for the dashboard ---

// Total number of products
$sql_products = "SELECT COUNT(*) AS total_products FROM products";
if ($conn->connect_error) {
    error_log("Connection error: " . $conn->connect_error);
    die("Database connection failed.");
}
$result_products = $conn->query($sql_products);
$total_products = $result_products->fetch_assoc()['total_products'] ?? 0;

// Total number of categories
$sql_categories = "SELECT COUNT(*) AS total_categories FROM categories";
$result_categories = $conn->query($sql_categories);
$total_categories = $result_categories->fetch_assoc()['total_categories'] ?? 0;

// Total number of customers
$sql_customers = "SELECT COUNT(*) AS total_customers FROM customers";
$result_customers = $conn->query($sql_customers);
$total_customers = $result_customers->fetch_assoc()['total_customers'] ?? 0;



$sql_recent_sales = "SELECT
    s.SaleID,
    s.SaleDate,
    s.TotalAmount,
    c.CustomerName,
    c.ContactNumber,
    c.Email,
    c.CustomerAddress,
    GROUP_CONCAT(
        CONCAT(p.ProductName, ' (Qty: ', si.Quantity, ')')
    ) AS PurchasedItems,
    COUNT(si.ProductID) AS TotalItemsPurchased
FROM
    sales s
LEFT JOIN
    customers c ON s.CustomerID = c.CustomerID
LEFT JOIN
    saleitems si ON s.SaleID = si.SaleID
LEFT JOIN
    products p ON si.ProductID = p.ProductID
GROUP BY
    s.SaleID
ORDER BY
    s.SaleDate ASC";
    
$result_recent_sales = $conn->query($sql_recent_sales);
if (!$result_recent_sales) {
    error_log("Query failed: " . $conn->error);
    die("An error occurred. Please contact the administrator.");
}
$recent_sales = $result_recent_sales->fetch_all(MYSQLI_ASSOC);

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            light: '#818cf8',
                            DEFAULT: '#4f46e5',
                            dark: '#3730a3',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-track {
            background: #1f2937;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4b5563;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen">

<?php include 'sidebar.php'; 
if (file_exists('sidebar.php')) {
    include 'sidebar.php';
} else {
    error_log("sidebar.php not found");
}
?>

<!-- Main content area -->
<div class="transition-all duration-300 ease-in-out md:ml-64 p-4 sm:p-6 lg:p-8">
    <!-- Spacer for mobile menu button -->
    <div class="h-14 md:h-0"></div>

    <!-- Welcome header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome, <?php echo htmlspecialchars($username); ?></h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Here’s your store overview for today.</p>
        </div>
        <div>
            <button class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Sale
            </button>
        </div>
    </div>

    <!-- Stats cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow flex items-center gap-4 border border-gray-100 dark:border-gray-700">
            <div class="p-3 bg-indigo-100 dark:bg-indigo-900 rounded-full">
                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0v10l-8 4m0-10V7m0 10l-8-4V7"></path>
                </svg>
            </div>
            <div>
                <div class="text-gray-500 dark:text-gray-400 text-sm">Total Products</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo $total_products; ?></div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow flex items-center gap-4 border border-gray-100 dark:border-gray-700">
            <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div>
                <div class="text-gray-500 dark:text-gray-400 text-sm">Total Categories</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo $total_categories; ?></div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow flex items-center gap-4 border border-gray-100 dark:border-gray-700">
            <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div>
                <div class="text-gray-500 dark:text-gray-400 text-sm">Total Customers</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo $total_customers; ?></div>
            </div>
        </div>
    </div>

    <!-- Recent Sales Cards Modern Layout -->
    <div class="mb-10">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Recent Sales Transactions</h3>
        <?php if (!empty($recent_sales)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php foreach ($recent_sales as $sale): $sale_no += 1; ?>
                    <div class="sale-card bg-white dark:bg-gray-800 rounded-2xl shadow hover:shadow-lg transition-all duration-300 overflow-hidden cursor-pointer border border-gray-100 dark:border-gray-700"
                        data-no="<?= htmlspecialchars($sale_no) ?>"
                        data-date="<?= htmlspecialchars(date('M j, Y H:i', strtotime($sale['SaleDate']))) ?>"
                        data-customer="<?= $sale['CustomerName'] ? htmlspecialchars($sale['CustomerName']) : 'Guest' ?>"
                        data-contact="<?= $sale['ContactNumber'] ? htmlspecialchars($sale['ContactNumber']) : 'N/A' ?>"
                        data-email="<?= $sale['Email'] ? htmlspecialchars($sale['Email']) : 'N/A' ?>"
                        data-address="<?= $sale['CustomerAddress'] ? htmlspecialchars($sale['CustomerAddress']) : 'N/A' ?>"
                        data-items="<?= htmlspecialchars($sale['PurchasedItems']) ?>"
                        data-total-items="<?= htmlspecialchars($sale['TotalItemsPurchased']) ?>"
                        data-total-amount="<?= htmlspecialchars(number_format($sale['TotalAmount'], 2)) ?>">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-100 dark:bg-indigo-900 px-2 py-1 rounded">#<?= htmlspecialchars($sale_no) ?></span>
                                <span class="text-sm font-bold text-green-600 dark:text-green-400">$<?= htmlspecialchars(number_format($sale['TotalAmount'], 2)) ?></span>
                            </div>
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-white">
                                        <?= $sale['CustomerName'] ? htmlspecialchars($sale['CustomerName']) : 'Guest' ?>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?= htmlspecialchars(date('M j, Y H:i', strtotime($sale['SaleDate']))) ?></div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <?= $sale['ContactNumber'] ? htmlspecialchars($sale['ContactNumber']) : 'N/A' ?>
                                </div>
                                <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 gap-2 mt-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <?= $sale['Email'] ? htmlspecialchars($sale['Email']) : 'N/A' ?>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="text-xs text-gray-400 dark:text-gray-500 mb-1">Items (<?= htmlspecialchars($sale['TotalItemsPurchased']) ?>)</div>
                                <div class="text-sm text-gray-700 dark:text-gray-200 line-clamp-2">
                                    <?php
                                    $items = explode(',', $sale['PurchasedItems']);
                                    echo htmlspecialchars(count($items) > 2 
                                        ? trim($items[0]) . ', ' . trim($items[1]) . ' ...' 
                                        : $sale['PurchasedItems']);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-3 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700 text-right">
                            <button class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium flex items-center ml-auto">
                                View Details
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <p class="mt-2 text-gray-600 dark:text-gray-400">No sales transactions recorded yet.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Sale Modal (unchanged, keep as is) -->
    <div id="saleModal" class="fixed top-0 left-0 w-full h-full bg-gray-200 bg-opacity-75 dark:bg-gray-800 dark:bg-opacity-75 hidden items-center justify-center z-50">
        <div class="bg-gray-100 dark:bg-gray-700 rounded-xl shadow-lg w-11/12 md:w-2/3 mx-auto md:ml-64 overflow-hidden border border-gray-300 dark:border-gray-600">
            <div class="px-6 py-5 border-b dark:border-gray-600 bg-gray-100 dark:bg-gray-700">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Sale Details</h2>
            </div>
            <div class="p-6 grid grid-cols-2 gap-y-3">
                <p class="font-semibold text-gray-700 dark:text-gray-300">No:</p>
                <p id="modal-no" class="text-gray-600 dark:text-gray-400"></p>

                <p class="font-semibold text-gray-700 dark:text-gray-300">Date:</p>
                <p id="modal-date" class="text-gray-600 dark:text-gray-400"></p>

                <p class="font-semibold text-gray-700 dark:text-gray-300">Customer:</p>
                <p id="modal-customer" class="text-gray-600 dark:text-gray-400"></p>

                <p class="font-semibold text-gray-700 dark:text-gray-300">Contact:</p>
                <p id="modal-contact" class="text-gray-600 dark:text-gray-400"></p>

                <p class="font-semibold text-gray-700 dark:text-gray-300">Email:</p>
                <p id="modal-email" class="text-gray-600 dark:text-gray-400"></p>

                <p class="font-semibold text-gray-700 dark:text-gray-300">Address:</p>
                <p id="modal-address" class="text-gray-600 dark:text-gray-400"></p>

                <p class="font-semibold text-gray-700 dark:text-gray-300">Items Purchased:</p>
                <ul id="modal-items" class="list-disc pl-4 text-gray-600 dark:text-gray-400"></ul>

                <p class="font-semibold text-gray-700 dark:text-gray-300">Total Items:</p>
                <p id="modal-total-items" class="font-medium text-gray-600 dark:text-gray-400"></p>

                <p class="font-semibold text-gray-700 dark:text-gray-300">Total Amount:</p>
                <p class="font-medium text-gray-600 dark:text-gray-400">$<span id="modal-total-amount"></span></p>
            </div>
            <div class="px-6 py-4 bg-gray-100 dark:bg-gray-700 text-right rounded-b-xl">
                <button id="closeModal" class="bg-white dark:bg-gray-600 text-gray-700 dark:text-gray-200 font-bold py-2 px-4 rounded-md shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 transition ease-in-out duration-150">Close</button>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        const saleCards = document.querySelectorAll('.sale-card');
        const modal = document.getElementById('saleModal');
        const closeModalButton = document.getElementById('closeModal');
        const modalNo = document.getElementById('modal-no');
        const modalDate = document.getElementById('modal-date');
        const modalCustomer = document.getElementById('modal-customer');
        const modalContact = document.getElementById('modal-contact');
        const modalEmail = document.getElementById('modal-email');
        const modalAddress = document.getElementById('modal-address');
        const modalItems = document.getElementById('modal-items');
        const modalTotalItems = document.getElementById('modal-total-items');
        const modalTotalAmount = document.getElementById('modal-total-amount');

        saleCards.forEach(card => {
            card.addEventListener('click', function () {
                modalNo.textContent = this.dataset.no;
                modalDate.textContent = this.dataset.date;
                modalCustomer.textContent = this.dataset.customer;
                modalContact.textContent = this.dataset.contact;
                modalEmail.textContent = this.dataset.email;
                modalAddress.textContent = this.dataset.address;

                // Populate items list
                modalItems.innerHTML = ''; // Clear previous items
                const items = this.dataset.items ? this.dataset.items.split(',') : [];
                items.forEach(item => {
                    const li = document.createElement('li');
                    li.textContent = item.trim();
                    modalItems.appendChild(li);
                });
                if (items.length === 0) {
                    const li = document.createElement('li');
                    li.textContent = 'No items';
                    modalItems.appendChild(li);
                }

                modalTotalItems.textContent = this.dataset.totalItems;
                modalTotalAmount.textContent = this.dataset.totalAmount;
                modal.classList.remove('hidden');
            });
        });

        closeModalButton.addEventListener('click', function () {
            modal.classList.add('hidden');
        });

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>
</body>
</html>
