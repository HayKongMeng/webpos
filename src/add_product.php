<?php
// add_product.php

require_once '../db/connection_db.php'; // Include database connection

session_start();

// Check if the user is logged in and has admin role
if (!isset($_SESSION['UserID']) || !isset($_SESSION['Username']) || $_SESSION['Role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST["productName"];
    $categoryId = $_POST["categoryId"];
    $price = $_POST["price"];
    $stockQuantity = $_POST["stockQuantity"];
    $productImage = ""; // Initialize image path

    // Basic validation
    if (empty($productName) || empty($price) || !is_numeric($price) || empty($stockQuantity) || !is_numeric($stockQuantity)) {
        $message = "<p class='text-red-500 text-sm'>Please fill in all required fields with valid data.</p>";
    } else {
        // Handle image upload if a file was selected
        if (isset($_FILES["productImage"]) && $_FILES["productImage"]["error"] == 0) {
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $filename = basename($_FILES["productImage"]["name"]);
            $filetype = $_FILES["productImage"]["type"];
            $filesize = $_FILES["productImage"]["size"];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            $uploadDir = __DIR__ . "/uploads/products/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $uniqueName = uniqid() . "." . $ext;
            $targetFile = $uploadDir . $uniqueName;
            
            $maxSize = 2 * 1024 * 1024; // 2MB

            if (!array_key_exists($ext, $allowed) || !in_array($filetype, $allowed)) {
                $message = "<p class='text-red-500 text-sm'>Error: Please select a valid image file (jpg, jpeg, gif, png).</p>";
            } elseif ($filesize > $maxSize) {
                $message = "<p class='text-red-500 text-sm'>Error: Image size should not exceed 2MB.</p>";
            } else {
                if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile)) {
                     $productImage = "uploads/products/" . $uniqueName;
                } else {
                    $message = "<p class='text-red-500 text-sm'>Error: There was an error uploading your file.</p>";
                }
            }
        }

        // If no validation errors, insert the product into the database
        if (empty($message)) {
            $stmt = $conn->prepare("INSERT INTO products (ProductName, CategoryID, Price, StockQuantity, product_image) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sidds", $productName, $categoryId, $price, $stockQuantity, $productImage);

            if ($stmt->execute()) {
                $message = "<p class='text-green-500 text-sm'>Product added successfully!</p>";
            } else {
                $message = "<p class='text-red-500 text-sm'>Error adding product: " . $stmt->error . "</p>";
            }
            $stmt->close();
            header("Location: view_product.php");

        }
    }
}

// Fetch categories for the dropdown
$categories =[];
$result_categories = $conn->query("SELECT CategoryID, CategoryName FROM categories");

if ($result_categories->num_rows > 0) {
    while ($row = $result_categories->fetch_assoc()) {
        $categories[]= $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen flex">

<?php include 'sidebar.php' ?>

<div class="flex-1 flex items-center justify-center px-4 py-8">
    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl overflow-hidden w-full max-w-4xl flex flex-col md:flex-row">
        <!-- Form Section -->
        <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center md:text-left">Add Product</h2>
            <?php if (!empty($message)): ?>
                <div class="mb-4 text-center text-sm <?php echo strpos($message, 'success') ? 'text-green-600' : 'text-red-500'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label for="productName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product Name</label>
                    <input type="text" id="productName" name="productName" required
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-4 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none transition" />
                </div>
                <div>
                    <label for="categoryId" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                    <select id="categoryId" name="categoryId" required
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-4 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                        <option value="" disabled selected hidden>Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['CategoryID']; ?>"><?php echo htmlspecialchars($category['CategoryName']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-400">$</span>
                        <input type="number" id="price" name="price" step="0.01" required
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-8 pr-4 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none transition" />
                    </div>
                </div>
                <div>
                    <label for="stockQuantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock Quantity</label>
                    <input type="number" id="stockQuantity" name="stockQuantity" required
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-4 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none transition" />
                </div>
                <div>
                    <label for="productImage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Image (Optional)</label>
                    <div class="flex items-center gap-4">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-800 hover:border-blue-400 transition">
                            <input type="file" name="productImage" id="productImage" class="hidden" accept="image/*" />
                            <span class="flex flex-col items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400 dark:text-gray-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1a1 1 0 011-1h4a1 1 0 011 1v1a1 1 0 01-1 1z" />
                                </svg>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Click to upload</span>
                            </span>
                        </label>
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold py-2 rounded-lg shadow-lg transition focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                    Add Product
                </button>
            </form>
            <div class="mt-6 text-center">
                <a href="dashboard.php" class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">← Back to Dashboard</a>
            </div>
        </div>
        <!-- Image Preview Section -->
        <div class="hidden md:flex w-1/2 bg-gradient-to-br from-blue-100 via-indigo-100 to-blue-200 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800 items-center justify-center p-8">
            <div id="image-preview" class="w-full h-64 flex items-center justify-center rounded-xl bg-white/60 dark:bg-gray-900/60 border border-dashed border-gray-200 dark:border-gray-700">
                <div class="text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-400 dark:text-gray-500">Image preview will appear here</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Tailwind config for dark mode
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                fontFamily: { sans: ['Inter', 'sans-serif'] }
            }
        }
    };

    // Image preview logic
    document.getElementById('productImage').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('image-preview');
        previewContainer.innerHTML = '';
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('max-h-56', 'rounded-lg', 'shadow-md', 'mx-auto');
                previewContainer.appendChild(img);
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.innerHTML = `
                <div class="text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-400 dark:text-gray-500">Image preview will appear here</p>
                </div>
            `;
        }
    });
</script>
</body>
</html>
