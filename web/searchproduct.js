$(function () {
    $("#searchProduct").autocomplete({
        source: "searchproduct.php",
        minLength: 1,
        select: function (event, ui) {
            window.location = "productdesc.php?id=" + ui.item.value;
        }
    });     
});