var Cart = function()
{
    this.total_price = 0;
    this.count = 0;
    this.total_sale = 0;
}

Cart.prototype = new Storage();

Cart.prototype.destroy = function ()
{
    this.total_price = 0;
    this.count = 0;
}

Cart.prototype.downCountItem = function(index)
{
    this.products[index].count--;
    if (this.products[index].count<=0)
    {
        this.products[index].count=1;
    }
    this.save();
}

Cart.prototype.upCountItem=function(index)
{
    this.products[index].count++;
    this.save();
}

Cart.prototype.addProduct = function (product)
{
    if (product instanceof Product)
    {
        product.count = parseInt(product.count);
        product.price = parseFloat(product.price).toFixed(2);

        if (isNaN(product.count))
        {
            product.count = 1;
        }

        if (!this.hasProduct(product))
        {
            this.products_by_id[product.id] = product;
            this.products.push(product);
        }
        else
        {
            this.products_by_id[product.id].count = this.products_by_id[product.id].count + product.count;
        }
    }
    this.save();
}

Cart.prototype.setTotal = function()
{
    var self = this;
    $.each(this.products, function(k, v)
    {
        self.count += v.count;
        self.total_price += (v.sale) ? v.sale * v.count : v.price * v.count;
        self.total_sale += (v.sale) ? (v.price - v.sale) * v.count : 0;
    });
}