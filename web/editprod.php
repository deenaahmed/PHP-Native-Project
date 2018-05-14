<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/Product.php';
include '../model/category.php';
include '../model/categories.php';

session_start();
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==1)
{
$prodId = $_SESSION['prodIdnow'];

$product = new Product($conn,$prodId);



if(!empty($_POST))
{
    if(!empty($_FILES['fileToUpload']['tmp_name']))
    {
    $filename = $_FILES['fileToUpload']['tmp_name'];
    $filePath = "\uploads/" . time() . '.jpeg';
    $destination = __DIR__ . $filePath;
    if(!move_uploaded_file($filename, $destination))
    {
        die('cant upload');
    }

        $product->setPhoto($filePath);

    }

    if(!empty($_POST['productname']))
    {
    $product->setProductname($_POST['productname']);
    }

    if(!empty($_POST['description']))
    {
    $product->setDescription($_POST['description']);
    }

    if(!empty($_POST['category']))
    {
    $product->setCategoryid($_POST['category']);
    }
    if(!empty($_POST['price']))
    {
    $product->setPrice($_POST['price']);
    }
    $product->update();

    header("Location: home.php");
    exit;
}
}
else {}
?>
<?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==1): ?>
<form method="post" enctype="multipart/form-data">
    <img src="<?= $product->photo ?>" width="100" height="100" />
    Change photo:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br/>
    Product name: <input name="productname" value="<?= $product->productname ?>" />
    <br/>
    Description: <textarea name="description"  ><?= $product->description ?></textarea>
    <br/>
    Change the Category: <select type="option"  name="category">

            <?php
            $categoriesO = new categories($conn);
            $categoriess = $categoriesO->getcategories();
            ?>
            <option value="">All</option>
            <?php foreach ($categoriess as $categoriesu): ?>

                <option value ="<?= $categoriesu->getId(); ?>"><?= $categoriesu->getCategoryname() ?></option>
            <?php endforeach; ?>

        </select >
    <br/>
    Price: <input name="phone" value="<?= $product->price ?>" />
    <br/>

    <button type="submit">Update</button>
</form>
<?php else: ?>

<?php endif; ?>
