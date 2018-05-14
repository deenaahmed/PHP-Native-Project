<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/Product.php';
include '../model/Products.php';
include '../model/category.php';
include '../model/categories.php';
include '../model/productcomment.php';
include '../model/productcomments.php';

session_start();
?>
<html>
    <head>
    <h1>Shopping application home page</h1>
    <?php if (!isset($_SESSION['userId']) || !$_SESSION['userId'] || !isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']): ?>
        <a href="login.php">Login</a>
        <a href="signup.php">Register</a>
    <?php elseif ($_SESSION['loggedIn'] != 1): //not loggedin ?> 
        <a href="login.php">Login</a>
        <a href="signup.php">Register</a>
    <?php else: ?>    
        <button><a id="account" >Account</a></button>
        <button><a id="logout">Logout</a></button>
    <?php endif; ?>
    <br/>
    <br/>
    <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1):  //admin ?>
        <a href="addproduct.php" ><button id="addprod">Add Product</button ></a>
        <a href="addcategory.php" ><button id="addcategory">Add Category</button></a>
    <?php endif; ?>
    <br/>
    <br/>
    <?php if (isset($_SESSION['userId']) && $_SESSION['loggedIn'] == 1): //loggedin user?>
        <a><button id="tothecard1">View card</button></a>
    <?php endif; ?>
    <input type="text" placeholder="search for a product" id="searchProduct" class="ui-autocomplete-loading"/>
    <br/>
    <br/>
    <form method="post" action="">
        Select your category: <select type="option" id="filterbycategory"  name="category">
            <?php
            $categoriesO = new categories($conn);
            $categoriess = $categoriesO->getcategories();
            ?>
            <option  value="0"></option>
            <option  value="0">All</option>
            <?php foreach ($categoriess as $categoriesu): ?>

                <option value ="<?= $categoriesu->getId(); ?>"><?= $categoriesu->getCategoryname() ?></option>
            <?php endforeach; ?>

        </select >
    </form>


    <style>
        .product{
            border: 1px solid black;
            width: 400px;
            height: 400px;
        }
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!--    <link rel="stylesheet" href="/resources/demos/style.css">-->
    <style>
        .ui-autocomplete-loading {
            background: white right center no-repeat;
        }
    </style>
</head>
<body>

    <br/>
    <br/>
    <br/>

    <?php
    if ($_SESSION['catid'] == 0) {
        $productsO = new Products($conn);
        $products = $productsO->getProducts();
    } else {
        $productsO = new Products($conn);
        $products = $productsO->getProductsbycatid($_SESSION['catid']);
    }
    ?>
    <?php foreach ($products as $productu): ?>
        <div class="product" style="display: inline-block;margin-top:2em;" >
            </br>
            <button class="addtocard" id="<?= $productu->getId() ?>" > Add to card</button>
            <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == 1): ?>
                <h4> <a href="productdesc.php?id=<?= $productu->getId() ?>&userId=<?= $_SESSION['userId'] ?>"><?= $productu->getProductname() ?></a></h4>
            <?php else: ?>
                <h4><?= $productu->getProductname() ?></h4>
            <?php endif; ?>
            <img src="<?= $productu->getPhoto() ?>"  width="400" height="100"   />
            </br>
            <br/>
            <h7>Price: <?= $productu->getPrice() ?></h7>
            </br>
            <br/>
            <h7>Category: <?php
                $catinst = new category($productu->getConn(), $productu->getCategoryid());
                echo $catinst->getCategoryname();
                ?></h7>
            </br>
            <br/>
            <h7>Description: <?= substr($productu->getDescription(), 0, 30) ?></h7>
            <h7> <?= substr($productu->getDescription(), 30, 30) ?></h7>
            <h7><?= substr($productu->getDescription(), 60, 30) ?></h7>
            <h7><?= substr($productu->getDescription(), 90, 10) ?></h7>
            </br>
            <br/>
            <?php
            $comments = new productcomments($conn);
            $commentsObj = $comments->getCommentss($productu->getId());
            $counter = 0;
            $avrate = 0;
            foreach ($commentsObj as $comment):
                $avrate = $avrate + $comment->getRate();
                $counter++;
            endforeach;
            if ($counter == 0) {
                $avrate = 0;
            } else {
                $avrate = $avrate / $counter;
            }
            ?>
            <h7> Product's average rate : <?= $avrate ?></h7>
        </div>

    <?php endforeach; ?>
    <script src="jquery-3.1.0.min.js"></script>
    <script src="jquery-3.1.1.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="searchproduct.js"></script>
    <script>
        var arr = [];
<?php if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == 1) && isset($_SESSION['userId'])): ?>
            $("#tothecard1").attr("disabled", false);
            $(".addtocard").attr("disabled", false);
            $("#addprod").attr("disabled", false);
            $("#addcategory").attr("disabled", false);
<?php else: ?>
            $("#tothecard1").attr("disabled", true);
            $(".addtocard").attr("disabled", true);
            $("#addprod").attr("disabled", true);
            $("#addcategory").attr("disabled", true);
<?php endif; ?>

        $('.addtocard').click(function () {

            $(this).html('Added');
            $(this).attr("disabled", true);
            var prodiid = $(this).attr("id");
            $.ajax({
                url: 'card.php',
                type: 'post',
                data: {prodId: prodiid},
                success: function (response) {
//                    console.log(response);
                    arr = response;
                }
            });
        });
        $("#tothecard1").click(function () {
            if (arr.length == 0) {
<?php if (isset($_SESSION['prodId'])): ?>
                    //{
    <?php if ($_SESSION['prodId'] == 0): ?>

                        alert("you haven't choosen any products yet");
    <?php else: ?>

                        window.location = "cardview.php";
                        exit;
    <?php endif; ?>
                    // }
<?php else: ?>
                    // {
                    alert("you haven't choosen any products yet");
                    // }
<?php endif; ?>
            } else {
                window.location = "cardview.php";
                exit;
            }

        });
        $("#logout").click(function () {
            $.ajax({
                url: 'logout.php',
                type: 'post',
            });
            window.location = "login.php";
        });
        $("#account").click(function () {
            window.location = "account.php";
        });


        $("#filterbycategory").change(function () {
            $.ajax({
                url: 'filter.php',
                type: 'post',
                data: {catid: $("#filterbycategory").val()},
            });
            window.location = "home.php?catid=" + $("#filterbycategory").val();
        });
    </script>
</body>
</html>
