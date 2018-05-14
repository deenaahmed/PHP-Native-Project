
<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/Product.php';
include '../model/categories.php';
include '../model/category.php';

session_start();
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==1)
{

$errorCategoryname="";
if (!empty($_POST)) {
    
    if (!isset($_POST['categoryname']) || !$_POST['categoryname']) {
        $errorProductname .= "This Field required.";
    } else {
        
    }
    


    if ($errorCategoryname == "" ) {
        //mysqli_query($conn, $sql)
        session_start();
        $category0 = new category($conn);
        $category0->setCategoryname($_POST['categoryname']);
        

        $_SESSION['id'] = $category0->save();

       // header('Location: account.php');
        exit;
    }
}
}
 else {
    
 }
?>
<?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==1): ?>
<html>
    <head>

    </head>
    <body>
        <h1>Add new Category</h1>
        <form method="post" enctype="multipart/form-data">
            Category name:<input name="categoryname" type="text"  value="<?php echo isset($_POST['categoryname']) ? $_POST['categoryname'] : "" ?>"/>
            <br/>
            <br/>
           
            <button type="submit">Add to the categories</button>
        </form>
    </body>
</html>
<?php else: ?>

<?php endif; ?>

