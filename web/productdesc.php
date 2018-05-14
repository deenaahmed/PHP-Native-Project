<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/Product.php';
include '../model/category.php';
include '../model/User.php';
include '../model/productcomment.php';
include '../model/productcomments.php';


session_start();

if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == 1) {
    if (isset($_GET['id']) && $_GET['id']) {
        $prodId = $_GET['id'];
        $_SESSION['prodIdnow'] = $prodId;
        $user = new Product($conn, $prodId);
    }
    
} else {
    
}
?>

<style>
    .comment{
        border: 1px solid black;
    }
</style>

<?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == 1): ?>
    <h1>Product Info</h1>  
    <a href="home.php"><h1>home</h1></a>
    <h3>Product name: <?= $user->productname ?></h3>
    <img src="<?= $user->photo ?>" width="100" height="100" />
    <h3>Category name: <?php
        $catinst = new category($user->getConn(), $user->getCategoryid());
        echo $catinst->getCategoryname();
        ?></h3>
    <h3>Price: <?= $user->price ?></h3>
    <h3>Description: <?= $user->description ?></h3>

    <?php if ($_SESSION['userId'] == 1): ?>
        <h3><a href="editprod.php?prodId=<?= $user->id ?>">Edit Product info</a></h3>
        <h3><a href="deleteprod.php?prodId=<?= $user->id ?>">Delete the product</a></h3>
    <?php endif; ?>
<?php else: ?>
<?php endif; ?>

<br/>
<br/>
<form method="post" >
    <textarea  id="comment" ></textarea>
    <br/>
    Rate: <input type="number" id="rate" min="1" max="5"/>
    <button  id="addcommentandrate" type="submit" value="<?= "1" ?>">Add Comment and Rate</button>
</form>
<script src="jquery-3.1.1.js"></script>
<script src="jquery-3.1.0.min.js"></script>
<script>
   $(document).ready(function () {
        $("#addcommentandrate").click(function () {
            $var1 = $('#comment').val();
            $var2 = $('#rate').val();
            $.ajax({
                url: 'addcomment.php',
                type: 'post',
                data: {
                    text: $var1,
                    ratee: $var2,
                },
                success: function (response) {
                    //alert(response);
                    document.getElementById("allcomments").prepend('<div class="comment"><h3>' + response.username + '</h3><h5>' + response.comment + '</h5><h6>' + response.date + '</h6></<div>');
                }
            });
        });
   });
</script>
<br/>
<br/>
<br/>
<?php
$prodId = $_GET['id'];
$comments = new productcomments($conn);
$commentsObj = $comments->getCommentss($prodId);
$counter = 0;
$avrate = 0;
foreach ($commentsObj as $comment):
    $avrate = $avrate + $comment->getRate();
    $counter++;
endforeach;
if($counter==0)
{
  $avrate=0;  
}
else
{
    $avrate = $avrate / $counter;
}

?>
<h3> Product's average rate : <?= $avrate ?></h3>
<div id="allcomments">
    <?php foreach ($commentsObj as $comment): ?>
        <div class="comment">
            <h7> <?php
                $commentinst = new User($comment->getConn(), $comment->getUserid());
                echo $commentinst->getUsername();
                ?></h7>
            <br/>
            <h5> <?= $comment->getComment() ?> </h5>
            <h6> <?= $comment->getCreatedat() ?> </h6>
        </div>
        <br/>
    <?php endforeach; ?>
</div>




