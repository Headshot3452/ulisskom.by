(function($)
{
    $(".form-group.buttons").hide();

    $("body").on("change click", "input, textarea, .redactor-editor, select, " +
                "button, img.fa-close, label.checkbox-active, .marker", function()
    {
        viewSubmitButton(this);
    });

    $(".form-group.buttons span").on('click',function()
    {
        $(".form-group.buttons").hide();
    });

    $('.seo-text textarea').on('keyup', function()
    {
        if($(this).val().length > 255)
        {
            $(this).val($(this).val().substr(0, 255));
        }
        var value = 255 - $(this).val().length;
        $(this).prev().find('span').text(value);
    });

})(jQuery);

// добавления по карточке товара

$(document).ready(function()
{
    checkStock('#stock');
    $(document).on('change','#stock', function()
    {
        checkStock($(this));
    });

    $(document).on('click','.marker', function()
    {
        $(this).toggleClass('active');
        $(this).find('i').toggleClass('fa-bookmark');
        if($(this).find('input[type="checkbox"]').prop('checked'))
        {
            $(this).find('input[type="checkbox"]').prop('checked', false);
            $(this).find('i').removeClass('fa-bookmark');
            $(this).find('i').addClass('fa-bookmark-o');
        }
        else
        {
            $(this).find('input[type="checkbox"]').prop('checked', true);
            $(this).find('i').removeClass('fa-bookmark-o');
            $(this).find('i').addClass('fa-bookmark');
        }
    });

    $(document).on('click', '.add_sale.add', function()
    {
        $(this).hide();
        $('.sale').show();
    });

    $("#main-left-tree-menu a.title, #modal_releated a.title").hover(function(event)
    {
        event.stopPropagation();
        $(this).find('div.hidden_info').stop( true, true ).delay( 500 ).fadeIn();
    },
    function()
    {
        event.stopPropagation();
        $(this).find('div.hidden_info').stop( true, true ).fadeOut();
    });

    $(document).on('click','.checkbox-action', function()
    {
        var $t = $(this),
            $f = $(this).closest('#products-list');

            if($f.length == 0)
            {
                var $f = $(this).closest('#table-sotrudniki');
            }

        var $fc = $f.find('input[type=checkbox]');

        if ($t.hasClass('checked-all')){
            $fc.prop('checked', false);
            $t.removeClass('checked-all');
        }
        else if($t.hasClass('checked-single')){
            $fc.prop('checked', false);
            $t.removeClass('checked-single');
        }
        else
        {
            $fc.prop('checked', true);
            $t.addClass('checked-all');
        }
    });

    $(document).on('click', 'input[type=checkbox].group', function(e)
    {
        var $t = $(this),
            $f = $(this).parents('#products-list');

            if($f.length == 0)
            {
                var $f = $(this).closest('#table-sotrudniki');
            }

        var $fb = $f.find('.checkbox-action'); //button check all

        if ($f.find('input[type=checkbox]:checked').length == $f.find('input[type=checkbox]').length){
            $fb.removeClass('checked-single checked-all').addClass('checked-all');
        }
        else if($f.find('input[type=checkbox]:checked').length < $f.find('input[type=checkbox]').length && $f.find('input[type=checkbox]:checked').length != 0)
        {
            $fb.removeClass('checked-single checked-all').addClass('checked-single');
        }
        else
        {
            $fb.removeClass('checked-single checked-all');
        }
    });

    $(document).on('click', '.copy_products, .move_products', function ()
    {
        var a = $('.items').find('input[type=checkbox]:checked').clone();
        $('form.copy').html(a);
        return false;
    });

    $(document).on('click',' .move_products', function ()
    {
        $('form.copy').append('<input hidden type="text" name="move" value="1" />');
        return false;
    });


    $(document).on('click', '#modal_copy_products a', function ()
    {
        var parent_category = $(this).data('id');
        $('form.copy').append('<input hidden name="parent_category" value="'+parent_category+'" />');
        var data = $('form.copy').serialize();
        $.ajax(
        {
            url: '/admin/'+$('form.copy').data('module')+'/copy_product/',
            type: 'POST',
            data: data,
            success: function(e)
            {
                $("#modal_copy_products").modal('hide');
                window.location.reload();
            }
        });
        return false;
    });

    $(document).on('click','#modal_moderate.modal_review .change_status, #modal_answer.modal_review .change_status, #modal_delete .delete, #modal_not_active .change_status, #modal_active .change_status, #modal_archive.modal_review .change_status', function()
    {
        var a = $('.items').find('input[type=checkbox]:checked').clone();
        $('form.copy').html(a);
        var data = $('form.copy').serialize();
        var status = $(this).data('status');
        $.ajax(
        {
            url: '/admin/'+$('form.copy').data('module')+'/status_products/',
            type: 'POST',
            data: data+'&status='+status,
            success: function(e)
            {
                window.location.reload();
            }
        });
    });

    $(document).on('click','#product_review_container .items .one_item .name', function()
    {
        var id = $(this).closest('.one_item').attr('id');
        $.ajax(
        {
            type: 'POST',
            url: '/admin/catalog/modal/',
            data: 'model_review='+id,
            success: function(e)
            {
                $("#_modal_reviews_container").find('.products').remove();
                $("#_modal_reviews_container").append('<div class = "products"> </div>');
                $("#_modal_reviews_container .products").html(e);
                $('#modal_review').modal("show");
            }
        });
    });


    $(document).on('click','#catalog-products-product-form #modal_moderate .change_status, #catalog-products-product-form #modal_answer .change_status, #catalog-products-product-form #modal_delete .delete, #catalog-products-product-form #modal_archive .change_status', function()
    {
        var a = $('.items').find('input[type=checkbox]:checked').clone();
        $('form.copy').html(a);
        var data = $('form.copy').serialize();
        var status = $(this).data('status');
        $.ajax(
        {
            url: '/admin/'+$('form.copy').data('module')+'/status_reviews/',
            type: 'POST',
            data: data+'&status='+status,
            success: function(e)
            {
                window.location.reload();
            }
        });
    });

    $(document).on('click', '#modal_delete button:last-child', function ()
    {
        $('#modal_delete .close').trigger('click');
    });

    $(document).on('click change', '#modal_releated .pagination li a', function()
    {
        if($(this).attr('href') && !$(this).closest('li').hasClass('disabled') && !$(this).closest('li').hasClass('active'))
        {
            var product_id = $('#product_id').val();
            var currentPage;

            var param = $(this).attr('href');
            var re = /page=([0-9])/;
            var page = re.exec(param);

            if(!page)
            {
                currentPage = 1;
            }
            else
            {
                currentPage = page[1];
            }

            var data = 'product_id='+product_id+'&page='+currentPage;

            if($('#modal_tree a.active').data('id'))
            {
                var category_id = $('#modal_tree a.active').data('id');
                data = 'category_id='+category_id+'&product_id='+product_id+'&page='+currentPage
            }

            $.ajax(
            {
                url: '/admin/catalog/products_releated_select/',
                type: 'POST',
                data: data,
                success: function(e)
                {
                    $('#modal_releated .modal-body').find('.products').remove();
                    $('#modal_releated .modal-body').append('<div class = "products"> </div>');
                    $('#modal_releated .modal-body .products').html(e);
                }
            });
        }

        return false;
    });

    $(document).on('click change', '#modal_releated #modal_tree a', function()
    {
        var product_id = $('#product_id').val();
        var data = 'product_id='+product_id;

        $('#modal_releated #modal_tree a').each(function()
        {
            $(this).removeClass('active');
        });

        $(this).addClass('active');

        if(!$(this).hasClass('root'))
        {
            var category_id = $(this).data('id');
            data = 'category_id='+category_id+'&product_id='+product_id;
        }

        $.ajax(
        {
            url: '/admin/catalog/products_releated_select/',
            type: 'POST',
            data: data,
            success: function(e)
            {
                $('#modal_releated .modal-body').find('.products').remove();
                $('#modal_releated .modal-body').append('<div class = "products"> </div>');
                $('#modal_releated .modal-body .products').html(e);
            }
        });
        return false;
    });

    $(document).on('click', '#modal_releated.modal_catalog + .buttons button[type=submit]', function()
    {
        var a = $('#modal_releated.modal_catalog .items').find('input[type=checkbox]:checked').clone();
        $('form.copy').html(a);
        var data = $('form.copy').serialize();
        var id = $('#product_id').val();
        $.ajax(
        {
            url: '/admin/catalog/products_releated_save/',
            type: 'POST',
            data: data+'&product_id='+id
        });
    });

    $(document).on('click', '#modal_releated.modal_orders + .buttons button[type=submit]', function()
    {
        var a = $('#modal_releated.modal_orders .items').find('input[type=checkbox]:checked').clone();
        var orders = $("#modal_releated.modal_orders #orders").val();
        $('form.copy').html(a);
        var data = $('form.copy').serialize();
        $.ajax(
        {
            url: '/admin/orders/add_products_save/',
            type: 'POST',
            data: data+"&orders="+orders,
        });
    });

    $(".col-info .status div, .o-status .o-status-div div, #tab-details btn-success").on("click", function()
    {
        var order = $(this).parent().data("order");
        var status = $(this).data("status");

        $("#modal_status").modal("show").find(".change_status").attr("order", order).attr("new-status", status);
    });
});

function viewSubmitButton(obj)
{
    var el = $(obj).closest("form").find(".form-group.buttons");

    if (!el.is(':visible'))
    {
        el.show(500);
    }
}

function number_format_on_input( str )
{
    return str.replace(/(\s)+/g, '').replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
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

function checkStock(object)
{
    var val = $(object).val();
    var color = 'black';
    switch (val)
    {
        case '0':
            color = 'green';
            $('#stock').closest('div').next().hide();
            $('#stock').closest('div').next().next().hide();
            break;
        case '1':
            color = 'red';
            $('#stock').closest('div').next().show();
            $('#stock').closest('div').next().next().show();
            break;
        default :
            break;
    }
    $(object).css('color', color);
    $(object).find('option').css('color', 'black');
}

function proverka(input)
{
    ch = input.value.replace(/[^\d.]/g, '');
    pos = ch.indexOf('.');
    if(pos != -1)
    {
        result = input.value.match(/[.]/g).length;
        if(result > 1)
        {
            ch = ch.slice(0, -1);
        }
    }
    input.value = ch;
};