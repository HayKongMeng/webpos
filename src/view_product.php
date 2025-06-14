<?php
// view_products.php

require_once '../db/connection_db.php'; // Include database connection
// require_once '../vendor/autoload.php';


session_start();

// Check if the user is logged in (adjust this check if needed)
if (!isset($_SESSION['UserID']) || !isset($_SESSION['Username'])) {
    header("Location: ../index.php");
    exit();
}

// Fetch all products from the database
$sql_products = "SELECT p.ProductID, p.ProductName, p.product_image, p.Price, p.StockQuantity, p.add_date, c.CategoryName FROM products p INNER JOIN categories c ON p.CategoryID = c.CategoryID";
$result_products = $conn->query($sql_products);
$products = $result_products->fetch_all(MYSQLI_ASSOC);

$sql_categories = "SELECT CategoryID, CategoryName FROM categories";
$result_categories = $conn->query($sql_categories);
$categories = $result_categories->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        /* Print modal style */
        @media print {
            body * { visibility: hidden !important; }
            #print-modal, #print-modal * { visibility: visible !important; }
            #print-modal { position: absolute !important; top: 0; left: 0; width: 100% !important; background: white !important; z-index: 9999 !important; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen flex">

<?php include 'sidebar.php' ?>

<div class="flex-1 ml-0 md:ml-64 transition-all duration-300">
    <div class="p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Products</h3>
            <a href="add_product.php" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg transition focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Add Product
            </a>
        </div>

        <?php if (!empty($products)): ?>
        <div class="overflow-x-auto rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead>
                <tr class="bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-gray-800 dark:to-gray-900">
                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Product</th>
                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Image</th>
                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Price</th>
                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Category</th>
                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Added</th>
                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                <?php foreach ($products as $product): ?>
                    <tr class="hover:bg-blue-50 dark:hover:bg-gray-800 transition">
                        <td class="py-4 px-6 whitespace-nowrap text-base font-semibold text-gray-900 dark:text-white">
                            <?= htmlspecialchars($product['ProductName']) ?>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?= htmlspecialchars($product['ProductName']) ?>" class="h-14 w-14 object-cover rounded-lg shadow border border-gray-200 dark:border-gray-700">
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap text-base text-gray-900 dark:text-white font-mono">
                            $<?= htmlspecialchars(number_format($product['Price'], 2)) ?>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                <?= ($product['StockQuantity'] > 10) ? 'bg-green-100 text-green-800 dark:bg-green-600 dark:text-green-100' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-100'; ?>">
                                <?= htmlspecialchars($product['StockQuantity']) ?>
                            </span>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap text-base text-gray-900 dark:text-white">
                            <?= htmlspecialchars($product['CategoryName']) ?>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <?= htmlspecialchars($product['add_date']) ?>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="flex gap-3">
                                <button data-product-id="<?= $product['ProductID'] ?>" class="edit-btn text-indigo-600 hover:text-indigo-900 transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button data-product-id="<?= $product['ProductID'] ?>" class="delete-btn text-red-600 hover:text-red-900 transition" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <button data-product-id="<?= $product['ProductID'] ?>" class="print-btn text-gray-600 hover:text-blue-500 transition" title="Print">
                                    <i class="fa-solid fa-print"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <div class="text-center py-16 text-gray-400 dark:text-gray-500 text-lg font-medium">
                No products found.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Print Modal -->
<div id="print-modal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden">
  <div class="flex items-center justify-center min-h-screen px-4">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-md p-8 print:bg-white">
      <!-- Header -->
      <div class="flex justify-between items-center border-b pb-4 mb-4">
        <div>
          <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Invoice</h2>
          <p class="text-sm text-gray-500 dark:text-gray-300">POS Mart</p>
        </div>
        <div class="text-sm text-right text-gray-600 dark:text-gray-300">
          <p id="invoice-date"></p>
          <p>Invoice #: <span id="invoice-id" class="font-semibold"></span></p>
        </div>
      </div>
      <!-- Invoice Body -->
      <div class="space-y-3 text-gray-700 dark:text-gray-100 text-base">
        <div class="flex justify-between">
          <span class="font-medium">Product Name:</span>
          <span id="invoice-name"></span>
        </div>
        <div class="flex justify-between">
          <span class="font-medium">Category:</span>
          <span id="invoice-category"></span>
        </div>
        <div class="flex justify-between">
          <span class="font-medium">Price:</span>
          <span>$<span id="invoice-price"></span></span>
        </div>
        <div class="flex justify-between">
          <span class="font-medium">Stock Quantity:</span>
          <span id="invoice-stock"></span>
        </div>
        <div class="flex justify-between">
          <span class="font-medium">Added Date:</span>
          <span id="invoice-date-added"></span>
        </div>
      </div>
      <!-- Footer -->
      <div class="border-t mt-6 pt-4 text-center text-xs text-gray-500 dark:text-gray-400">
        Thank you for choosing POS Mart
      </div>
      <!-- Actions -->
      <div class="mt-6 flex justify-end gap-3">
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-5 py-2 rounded-lg shadow transition">
          <i class="fas fa-print mr-1"></i> Print
        </button>
        <button id="print-cancel" class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm px-5 py-2 rounded-lg dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 transition">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div id="delete-modal" class="fixed z-50 inset-0 bg-black bg-opacity-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4 w-full">
        <div class="relative w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl shadow-2xl">
            <div class="p-8">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Delete Product</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-6">Are you sure you want to delete this product?</p>
                <div class="flex justify-end gap-4">
                    <button id="delete-cancel" class="bg-gray-200 hover:bg-gray-300 text-gray-700 dark:text-gray-300 font-medium py-2 px-5 rounded-lg transition">Cancel</button>
                    <button id="delete-confirm" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-5 rounded-lg transition">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="edit-modal" class="fixed z-50 inset-0 bg-black bg-opacity-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4 w-full">
        <div class="relative w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl shadow-2xl">
            <form id="edit-product-form" action="edit_product.php" method="post" class="p-8">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Edit Product</h3>
                <input type="hidden" id="edit-product-id" name="productID">
                <div class="mb-4">
                    <label for="edit-product-name" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Product Name</label>
                    <input type="text" name="productName" class="rounded-lg border border-gray-300 dark:border-gray-700 w-full py-2 px-4 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none" id="edit-product-name">
                </div>
                <div class="mb-4">
                    <label for="edit-product-price" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Price</label>
                    <input type="number" name="price" class="rounded-lg border border-gray-300 dark:border-gray-700 w-full py-2 px-4 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none" id="edit-product-price">
                </div>
                <div class="mb-4">
                    <label for="edit-product-stock" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Stock Quantity</label>
                    <input type="number" name="stockQuantity" class="rounded-lg border border-gray-300 dark:border-gray-700 w-full py-2 px-4 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none" id="edit-product-stock">
                </div>
                <div class="mb-6">
                    <label for="edit-product-category" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Category</label>
                    <select name="categoryname" id="edit-product-category" class="rounded-lg border border-gray-300 dark:border-gray-700 w-full py-2 px-4 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category['CategoryName']) ?>">
                                <?= htmlspecialchars($category['CategoryName']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex justify-end gap-4">
                    <button type="button" id="edit-cancel" class="bg-gray-200 hover:bg-gray-300 text-gray-700 dark:text-gray-300 font-medium py-2 px-5 rounded-lg transition">Cancel</button>
                    <button type="submit" id="edit-confirm" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-5 rounded-lg transition">Apply Change</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                fontFamily: { sans: ['Inter', 'sans-serif'] }
            }
        }
    };

    // Print modal logic
    const printButtons = document.querySelectorAll('.print-btn');
    const printModal = document.getElementById('print-modal');
    const printCancel = document.getElementById('print-cancel');
    const productsData = <?php echo json_encode($products); ?>;

    printButtons.forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.dataset.productId;
            const product = productsData.find(p => p.ProductID == productId);
            if (product) {
                document.getElementById('invoice-id').textContent = productId.toString().padStart(4, '0');
                document.getElementById('invoice-name').textContent = product.ProductName;
                document.getElementById('invoice-category').textContent = product.CategoryName;
                document.getElementById('invoice-price').textContent = parseFloat(product.Price).toFixed(2);
                document.getElementById('invoice-stock').textContent = product.StockQuantity;
                document.getElementById('invoice-date-added').textContent = product.add_date;
                document.getElementById('invoice-date').textContent = new Date().toLocaleString();
                printModal.classList.remove('hidden');
            }
        });
    });
    printCancel.addEventListener('click', () => { printModal.classList.add('hidden'); });

    // Edit modal logic
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-btn');
        const editModal = document.getElementById('edit-modal');
        const editCancelButton = document.getElementById('edit-cancel');
        const editProductIdInput = document.getElementById('edit-product-id');
        const editProductNameInput = document.getElementById('edit-product-name');
        const editProductPriceInput = document.getElementById('edit-product-price');
        const editProductStockInput = document.getElementById('edit-product-stock');
        const editProductCategoryInput = document.getElementById('edit-product-category');
        let productIdToEdit = null;

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                productIdToEdit = this.dataset.productId;
                editProductIdInput.value = productIdToEdit;
                const product = productsData.find(p => p.ProductID == productIdToEdit);
                if (product) {
                    editProductNameInput.value = product.ProductName;
                    editProductPriceInput.value = product.Price;
                    editProductStockInput.value = product.StockQuantity;
                    editProductCategoryInput.value = product.CategoryName || "";
                }
                editModal.classList.remove('hidden');
            });
        });
        editCancelButton.addEventListener('click', function() {
            editModal.classList.add('hidden');
            productIdToEdit = null;
        });

        // Delete modal logic
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const deleteModal = document.getElementById('delete-modal');
        const delete_cancel = document.getElementById('delete-cancel');
        let productIdToDelete = null;

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                productIdToDelete = this.dataset.productId;
                deleteModal.classList.remove('hidden');
            });
        });
        delete_cancel.addEventListener('click', function() {
            deleteModal.classList.add('hidden');
            productIdToDelete = null;
        });
        const deleteConfirmButton = document.getElementById('delete-confirm');
        if (deleteConfirmButton) {
            deleteConfirmButton.addEventListener('click', function() {
                if (productIdToDelete) {
                    window.location.href = 'delete_product.php?id=' + productIdToDelete;
                }
            });
        }
    });
</script>
</body>
</html>