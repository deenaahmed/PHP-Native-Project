<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/Product.php';
include '../model/category.php';

session_start();
if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == 1) &&(isset($_SESSION['userId']))) {
    $arr = $_SESSION['prodId'];
    $countprice = 0;
} 

?>

<?php if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == 1) &&(isset($_SESSION['userId']))): ?>

    <html>
        <h1>Product added to your card</h1>
        <br/>
        <br/>
        <br/>
        <a href="home.php">Back to home</a>

        <body>

            <div class="productall" id="productall1" >
                <?php foreach($arr as $productuid): ?>
                    <?php
                    $productu = new Product($conn, $productuid);
                    $temp = $productu->getPrice();
                    $countprice = (int) $countprice + (int) $temp;
                    ?>
                    <div class="product" style="display: inline-block; margin-top:2em;"  id="<?= $productu->getId() ?>">

                        <br/>
                        <a><button class="removefromcard" id="<?= $productu->getId() ?>" price="<?= $productu->getPrice() ?>">Remove from Card</button ></a>
                        <h4> <a href="productdesc.php?id=<?= $productu->getId() ?>&userId=<?= $_SESSION['userId'] ?>"><?= $productu->getProductname() ?></a></h4>
                        <img src="<?= $productu->getPhoto() ?>"  width="400" height="100"/>
                        <br/>
                        <br/>
                        <h7>Price: <?= $productu->getPrice() ?></h7>
                        <br/>
                        <h7>Category: <?php
                            $catinst = new category($productu->getConn(), $productu->getCategoryid());
                            echo $catinst->getCategoryname();
                            ?></h7>
                        <br/>
                        <h7>Description: <?= substr($productu->getDescription(), 0, 30) ?></h7>
                        </br><h7> <?= substr($productu->getDescription(), 30, 30) ?></h7>
                        </br><h7><?= substr($productu->getDescription(), 60, 30) ?></h7>
                        </br><h7><?= substr($productu->getDescription(), 90, 10) ?></h7>
                    </div>
                    <?php endforeach; ?>
                <?php $_SESSION['price'] = $countprice;
                ?>
            </div>
            <h1 id="totalprice">Total price : <?= $_SESSION['price'] ?>  L.E</h1>
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

    $('.removefromcard').click(function () {
        $(this).parents(".product").remove();
        var rmprodiid = $(this).attr("id");
        $.ajax({
            url: 'removeprod.php',
            type: 'post',
            data: {removedprodId: rmprodiid,
            },
            success: function (response) {
                $("#totalprice").text("Total price :" + response + "L.E");
            }
        });
    });
</script>
        </body>
    </html>
<?php else: ?>
<?php endif; ?>