$(document).ready(function()
{
    if ($.cookie('refresh_cart') != undefined)
    {
        $.jStorage.deleteKey('cart');
        $.cookie('refresh_cart', null, {expires: 0, path: '/'});
    }

    initCart();

    $("body").on("click", ".addProduct", function()
    {
        var val = $(this).closest('div.price-descr').find('input.count').val();

        if (val == undefined || val > 0)
        {
            var p = $(this).data();
            var product = new Product(p.id, p.title, p.price, val, p.url, p.image, p.sale, p.type);

            cart.addProduct(product);
//          saveAjaxStorage('cart',cart);
        }
    });
});

$.jStorage.listenKeyChange("cart", function(key, action)
{
    initCart();
});

function initCart()
{
    cart = new Cart;
    cart.init({storage:$.jStorage,storage_key:'cart'});

    cart.setTotal();
    var count = '0';
    var price = '0';
    var sale = '0';

    if (cart.count != 0)
    {
        count = cart.count+'';

        price = number_format(cart.total_price, 2, '.', ' ');
        sale = number_format(cart.total_sale, 2, '.', ' ');
    }
    $('.count-product').html(cart.count);
    $('.total-price').html(price);
    $('.sale-product').html(sale);

    //$('.addProduct').each(function(index)
    //{
    //    if (cart.products_by_id[$(this).data('id')] !== undefined)
    //    {
    //        $(this).addClass('active');
    //    }
    //    else
    //    {
    //        $(this).removeClass('active');
    //    }
    //});
}

function saveAjaxStorage(key, storage)
{
    $.ajax(
        {
            url: "/ajax/saveStorage/",
            type: 'POST',
            dataType: 'JSON',
            data: {
                key: key,
                items: JSON.stringify(storage.products)
            }
        });
}

function getAjaxStorage(key,storage)
{
    $.ajax(
        {
            url:"/ajax/getStorage/",
            type:'POST',
            dataType: 'JSON',
            data:{
                key: key
            },
            success:function(data)
            {
                storage.merge(data);
                storage.save();
            }
        });
}

function number_format(number, decimals, dec_point, thousands_sep)
{
    var i, j, kw, kd, km;

    if(isNaN(decimals = Math.abs(decimals)))
    {
        decimals = 2;
    }
    if(dec_point == undefined)
    {
        dec_point = ",";
    }
    if(thousands_sep == undefined)
    {
        thousands_sep = ".";
    }

    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

    if( (j = i.length) > 3 )
    {
        j = j % 3;
    }
    else
    {
        j = 0;
    }

    km = (j ? i.substr(0, j) + thousands_sep : "");
    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");

    return km + kw + kd;
}