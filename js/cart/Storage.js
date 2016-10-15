function Storage()
{
    this.storage;
    this.storage_key;
    this.products = [];
    this.products_by_id = new Object;
}

Storage.prototype.init = function (options)
{
    this.storage = options.storage;
    this.storage_key = options.storage_key;
    this.products_by_id = new Object;

    var storage = this.storage.get(this.storage_key);

    this.products = JSON.parse(storage);
    if (this.products === null)
    {
        this.products = [];
    }

    for(var i = 0; i < this.products.length; i++)
    {
        if (this.hasProduct(this.products[i]))
        {
            this.products.splice(i,1);
        }
        else
        {
            this.products_by_id[this.products[i].id] = this.products[i];
        }
    }
}

Storage.prototype.hasProduct = function (product)
{
    var id = product.id;

    if(this.products_by_id[id] == undefined)
    {
        return false;
    }
    return true;
}

Storage.prototype.removeProduct=function(product)
{
    if (product instanceof Product)
    {
        if (this.hasProduct(product))
        {
            for(var i=0;i<this.products.length;i++)
            {
                if (this.products[i].id==product.id)
                {
                    this.removeItem(i);
                }
                break;
            }
        }
    }
    this.save();
}

Storage.prototype.destroy = function ()
{

}

Storage.prototype.save = function ()
{
    this.storage.set(this.storage_key,JSON.stringify(this.products));

    $(".container.cart .price b, .container.cart .price_total_item b").each(function()
    {
        $(this).text( number_format($(this).text(), 2, ".", " ") );
    });
}

Storage.prototype.addProduct = function (product)
{
    if (product instanceof Product)
    {
        if (!this.hasProduct(product))
        {
            this.products_by_id[product.id]=product;
            this.products.push(product);
        }
    }
    this.save();
}

Storage.prototype.removeItem = function(index)
{
    delete this.products_by_id[this.products[index].id];
    this.products.splice(index , 1);
    this.save();
}

Storage.prototype.merge=function(data)
{
    for(var i = 0; i < data.length; i++)
    {
        if (!this.hasProduct(data[i], false))
        {
            this.products.push(data[i]);
        }
    }
}