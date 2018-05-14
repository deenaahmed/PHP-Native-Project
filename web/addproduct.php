
<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/Product.php';
include '../model/categories.php';
include '../model/category.php';


session_start();
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == 1) {

    $filePath = "";

    $errorPrice = $errorPhoto = $errorDescription = $errorProductname = $errorCategoryname = "";
    if (!empty($_POST)) {
        //print_r($_FILES);

        $filename = $_FILES['fileToUpload']['tmp_name'];
        $filePath = "\uploads/" . time() . '.jpeg';
        $destination = __DIR__ . $filePath;
        if (empty($_FILES['fileToUpload']['tmp_name'])) {
            $filePath = "/Projecttrial/web/empty-img.png";
        } else if (!move_uploaded_file($filename, $destination)) {
            $errorPhoto .= "This Field required.";
            die('cant upload');
        } else {
            
        }
        if (!isset($_POST['productname']) || !$_POST['productname']) {
            $errorProductname .= "This Field required.";
        } else {
            
        }
        if (!isset($_POST['price']) || !$_POST['price']) {
            $errorPrice .= "This Field required.";
        } else {
            
        }
        if (!isset($_POST['description']) || !$_POST['description']) {
            $errorDescription .= "This Field required.";
        } else {
            
        }


        if ($errorPrice == "" && $errorProductname == "" && $errorDescription == "" && $errorPhoto == "" && $errorCategoryname == "") {
            //mysqli_query($conn, $sql)
            $product = new Product($conn);
            $product->setProductname($_POST['productname']);
            $product->setPrice($_POST['price']);
            $product->setDescription($_POST['description']);
            $product->setPhoto($filePath);
            $product->setCategoryid($_POST['category']);
            $_SESSION['id'] = $product->save();
            // header('Location: account.php');
            exit;
        }
    }
} else {
    
}
?>
<?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == 1): ?>
    <html>
        <head>

        </head>
        <body>
            <h1>Add new product</h1>
            <form method="post" enctype="multipart/form-data">
                Select image to upload:
                <input type="file" name="fileToUpload" id="fileToUpload">
                <br/>
                <br/>
                Product name:<input name="productname" type="text"  value="<?php echo isset($_POST['username']) ? $_POST['username'] : "" ?>"/>
                <br/>
                <br/>
                Price:<input name="price" type="text" />
                <br/>
                <br/>
                Description: <textarea name="description" ></textarea>
                <br/>
                <br/>
                Select your category: <select type="option" id="filterbycategory" name="category">

                    <?php
                    $categoriesO = new categories($conn);
                    $categoriess = $categoriesO->getcategories();
                    ?>
                    <option value=""></option>
                    <?php foreach ($categoriess as $categoriesu): ?>

                        <option value ="<?= $categoriesu->getId(); ?>"><?= $categoriesu->getCategoryname() ?></option>
                    <?php endforeach; ?>

                </select >
                <br/>
                <br/>
                <button type="submit"><a id="tothehomeagain">Add to the products</a></button>
            </form>
            <script src="jquery-3.1.0.min.js"></script>
            <script src="jquery-3.1.1.js"></script>
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script>
                $("#tothehomeagain").click(function () {
                    window.location = "home.php";
                });
            </script>
        </body>
    </html>
<?php else: ?>

<?php endif; ?>


