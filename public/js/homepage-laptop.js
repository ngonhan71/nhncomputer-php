const imgProducts = $('.product-item .product-img')
const products = $('.homepage-product .product-item')



let isWithWindowLessThan1024px = false;
function myFunction(x) {
    if (x.matches) { // If media query matches
        
    } else {
        isWithWindowLessThan1024px = true;
    }
}

let checkWindow = window.matchMedia("(min-width: 1024px)")
myFunction(checkWindow) 
checkWindow.addListener(myFunction) 

if (!isWithWindowLessThan1024px) {
    $.each(imgProducts, function(index, img) {
        $(this).hover(function() {
            $.each(products, function(index, load) {
                if ($(this).find('.load-hover'))
                    $(this).children('.load-hover').remove()
            })
            const productId = $(this).data('id')
            const _this = $(this).parent();
            $.ajax({
                url: "./api/product/product.php",
                type: "get",
                data: {
                    action: 'get-product-info',
                    id: productId
                },
                dataType: "json",
                success: function(result) {
                    let html = ``;
                    let arrStatus = ['Hết hàng', 'Còn hàng']
                    let price = result['price']
                    let discount = price - (price * result['discount'])/100;
                    discount = Math.round(discount/10000)*10000;
                    discount = new Intl.NumberFormat('de-DE').format(discount)
                    price = new Intl.NumberFormat('de-DE').format(price)
                    // console.log(result)
                    html = `<div class="load-hover">
                                <div class="load-header">
                                    <h4 class="load_product-name">${result['name']} (${result['cpu']}/${result['ram']}GB RAM/${result['graphics']}/${result['hard_drive_size']})</h4>
                                </div>
                                <div class="load-body">
                                    <div class="load_product-overview">
                                            <p class="load_product-price">- Giá bán: ${price}đ</p>
                                            <p class="load_product-discount">- Giá bán hiện tại: <span style="color:red; font-weight: bold">${discount}đ</span></p>
                                            <p class="load_product-status">- Tình trạng: ${arrStatus[result['status']]}</p>
                                            
                                    </div>
                                    <div class="load_product-info">
                                        <p class="title">Thông số sản phẩm</p>
                                        <p>- Bộ vi xử lý: ${result['cpu']}</p>
                                        <p>- RAM: ${result['ram']}GB</p>
                                        <p>- Ổ cứng: ${result['hard_drive_size']}</p>
                                        <p>- VGA: ${result['graphics']}</p>
                                        <p>- Màn hình: ${result['screen']}</p>
                                    </div>
                                </div>
                            </div>`
                    // console.log(html)
                    _this.append(html)
                    if (index % 5 == 4) {
                            $('.load-hover').css({"right": "50%", "left": "auto"})
                    }
                        }
                    })
            
        }, function() {
            $.each(products, function(index, load) {
                if ($(this).find('.load-hover'))
                    $(this).children('.load-hover').remove()
            })
        })
    })
}