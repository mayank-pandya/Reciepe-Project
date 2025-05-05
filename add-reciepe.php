<?php



require_once "./controls/functions.php";
require_once "./controls/functions.php";
session_start();


$recipe_message = "";
$recipe_status = "";

if (!isset($_SESSION['user_id'])) {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Redirecting...</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: "error",
                title: "❌ You must be logged in to add a recipe.",
                text: "Redirecting to login page...",
                showConfirmButton: false,
                timer: 3000
            }).then(() => {
                window.location.href = "login.php";
            });
        </script>
    </body>
    </html>';
    exit();
}




if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['user_id'])) {
        $recipe_message = "❌ You must be logged in to add a recipe.";
        $recipe_status = "error";
    } else {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $youtube_link = trim($_POST['youtube_link']);
        $user_id = $_SESSION['user_id'];

        // Handle Image Upload
        if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] === UPLOAD_ERR_OK) {
            $img_name = $_FILES['recipe_image']['name'];
            $img_tmp = $_FILES['recipe_image']['tmp_name'];
            $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($img_ext, $allowed)) {
                $new_filename = "uploads/" . uniqid("recipe_", true) . '.' . $img_ext;

                if (!file_exists('uploads')) {
                    mkdir('uploads', 0777, true);
                }

                if (move_uploaded_file($img_tmp, $new_filename)) {
                    // Insert Recipe
                    executeQuery(
                        "INSERT INTO recipes (title, description, youtube_link, image_path, user_id) VALUES (?, ?, ?, ?, ?)",
                        [$title, $description, $youtube_link, $new_filename, $user_id],
                        "ssssi"
                    );
                    $recipe_message = "✅ Recipe added successfully!";
                    $recipe_status = "success";


                    echo '<script>window.location.href = "recipepage.php";</script>';
                } else {
                    $recipe_message = "❌ Failed to save the image.";
                    $recipe_status = "error";
                }
            } else {
                $recipe_message = "❌ Invalid image type. Only JPG, PNG, WEBP allowed.";
                $recipe_status = "error";
            }
        } else {
            $recipe_message = "❌ Please upload a recipe image.";
            $recipe_status = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Recipe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            animation: fadeIn 0.5s ease-in;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        form {
            display: grid;
            gap: 20px;
        }

        input[type="text"],
        input[type="url"],
        textarea,
        input[type="file"] {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 16px;
            width: 100%;
        }

        textarea {
            resize: vertical;
        }

        button {
            padding: 14px;
            background: #2d89e5;
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #1c6ec8;
        }

        .preview-container {
            text-align: center;
        }

        .preview-container img {
            max-width: 100%;
            max-height: 250px;
            border-radius: 12px;
            margin-top: 10px;
            display: none;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Add a New Recipe</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Recipe Title" required>

            <textarea name="description" placeholder="Ingredients and instructions..." rows="6" required></textarea>

            <input type="url" name="youtube_link" placeholder="YouTube Video Link (Optional)">

            <input type="file" name="recipe_image" accept=".jpg,.jpeg,.png,.webp" onchange="previewImage(event)" required>

            <div class="preview-container">
                <img id="imagePreview" alt="Image Preview" />
            </div>

            <button type="submit">Submit Recipe</button>
        </form>
    </div>

    <?php if (!empty($recipe_message)): ?>
        <script>
            Swal.fire({
                icon: "<?php echo $recipe_status; ?>",
                title: "<?php echo $recipe_message; ?>",
                showConfirmButton: false,
                timer: 2500
            });
        </script>
    <?php endif; ?>

    <script>
        function previewImage(event) {
            const preview = document.getElementById("imagePreview");
            const file = event.target.files[0];

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = "block";
            } else {
                preview.src = "";
                preview.style.display = "none";
            }
        }
    </script>
</body>

</html>
