function Product(id, title, price, count, url, image, sale, type)
{
    if (!id || !title)
    {
        throw new Error('id, title is required');
    }

    this.id = id;
    this.title = title;
    this.price = price;
    this.image = image ? image : null;
    this.count = count ? count : 1;
    this.url = url ? url : null;
    this.sale = sale ? sale : null;
    this.type = type ? type : null;
}