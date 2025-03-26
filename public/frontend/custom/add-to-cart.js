(function ($) {
    "use strict";
    var HT = {};
    var _token = $('meta[name="csrf-token"]').attr('content');

    let variantData = JSON.parse(variant)
    let attrData = JSON.parse(attribute)
    let productData = JSON.parse(product)

    $(document).on('click', '.chooseProductBtn', function () {
        let attributeItems = JSON.parse(attributeItem)
        console.log(attributeItems);

        let html = HT.renderHTMLChoosePrd(attributeItems)
        $('.choose-prd-modal-body').append(html)

        $(document).on('click', '.card-choose-prd', function () {
            $('.card-choose-prd').removeClass('selected');
            $(this).addClass('selected');
        });
    })

    $(document).on('click', '.btnAddToCart', function () {
        let selectedCard = $('.card-choose-prd.selected')
        if (selectedCard.length === 0) {
            alert('Vui lòng chọn sản phẩm!');
            return
        }

        if ($('.btnAddToCart').attr('data-user-id') == 0) {
            alert('Bạn cần đăng nhập để thêm giỏ hàng!')
            return
        }

        let hiddenInput = selectedCard.find('.dataHidden');

        HT.sendAjaxAddToCart(hiddenInput)
    })

    HT.sendAjaxAddToCart = (hiddenInput) => {
        let option = {
            'user_id': $('.btnAddToCart').attr('data-user-id'),
            'productId': productData.id,
            'attributeName': hiddenInput.attr('data-variant-name'),
            'price': hiddenInput.attr('data-variant-price'),
            'total': hiddenInput.attr('data-variant-total') || 1,
            'quantity': hiddenInput.attr('data-variant-quantity'),
            'image': hiddenInput.attr('data-variant-image'),
            'sku': hiddenInput.attr('data-variant-sku'),
            'uuid': hiddenInput.attr('data-variant-uuid'),
            '_token': _token
        }

        $.ajax({
            url: 'ajax/frontend/addToCart',
            type: 'POST',
            data: option,
            dataType: 'json',
            success: function (response) {
                if (response.type == 'create') {
                    let numCard = parseInt($('.num-card').html(), 10)
                    $('.num-card').html(numCard += 1)
                }
                if (response.status) {
                    Swal.fire({
                        title: "Thành công!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    });
                } else {
                    Swal.fire({
                        title: "Lỗi!",
                        text: response.message,
                        icon: "error",
                        confirmButtonText: "Thử lại"
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: "Lỗi!",
                    text: "Có lỗi xảy ra, vui lòng thử lại.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                console.log('Lỗi: ' + textStatus + ' ' + errorThrown);
            }
        });
    }

    HT.renderHTMLChoosePrd = (attributeItems) => {
        let html = ''
        html += '<div class="row">'

        if (attrData && Object.keys(attrData).length > 0) {
            let length = variantData.length
            let inputHiddenFields = []

            variantData.forEach(element => {
                const skuParts = element.sku.split("-");
                const lastIds = skuParts.slice(-2).map(Number);

                const attributeNames = attributeItems.flat().filter(attr => lastIds.includes(attr.id)).map(attr => attr.name);
                html += `
                    <div class="col-md-4">
                        <div class="card card-choose-prd">
                            <img src="${element.album}" class="card-img-top img-custom" alt="Ảnh sản phẩm">
                            <div class="card-body">
                                <p class="card-text m-1">Mẫu: ${attributeNames}</p>
                                <p class="card-text m-1">Giá: ${element.price}</p>
                                <p class="card-text m-1">Số lượng: ${element.quantity}</p>
                                <input type="hidden" class="dataHidden" data-variant-name="${attributeNames}" data-variant-uuid="${element.uuid}" data-variant-sku="${element.sku}" data-variant-price="${element.price}" data-variant-image="${element.album}" data-variant-quantity="${element.quantity}" data-variant-total="">
                            </div>
                        </div>
                    </div>
                `
            });
            // for (let index = 0; index < length; index++) {
            //     const skuParts = variantData.sku[index].split("-");
            //     const lastIds = skuParts.slice(-2).map(Number);

            //     const attributeNames = attributeItems.flat().filter(attr => lastIds.includes(attr.id)).map(attr => attr.name);
            //     console.log(variantData.album[index]);
            //     html += `
            //         <div class="col-md-4">
            //             <div class="card card-choose-prd">
            //                 <img src="${variantData.album[index]}" class="card-img-top img-custom" alt="Ảnh sản phẩm">
            //                 <div class="card-body">
            //                     <p class="card-text m-1">Mẫu: ${attributeNames}</p>
            //                     <p class="card-text m-1">Giá: ${variantData.price[index]}</p>
            //                     <p class="card-text m-1">Số lượng: ${variantData.quantity[index]}</p>
            //                     <input type="hidden" class="dataHidden" data-variant-name="${attributeNames}" data-variant-sku="${variantData.sku[index]}" data-variant-price="${removeDots(variantData.price[index])}" data-variant-image="${variantData.album[index]}" data-variant-quantity="${variantData.quantity[index]}" data-variant-total="">
            //                 </div>
            //             </div>
            //         </div>
            //     `
            // }
        } else {
            html += `
            <div class="col-md-4">
                <div class="card card-choose-prd">
                    <img src="${productData.image}" class="card-img-top img-custom" alt="Ảnh sản phẩm">
                    <div class="card-body">
                        <p class="card-text m-1">Giá: ${productData.price}</p>
                        <p class="card-text m-1">Số lượng: 100</p>
                        <input type="hidden" class="dataHidden" data-variant-name="" data-variant-uuid="" data-variant-sku="" data-variant-price="${productData.price}" data-variant-image="${productData.image}" data-variant-quantity="" data-variant-total="">
                    </div>
                </div>
            </div>
            `
        }
        html += '</div>'
        $(this).toggleClass('selected')
        return html
    }

    $('#choosePrdModal').on('hidden.bs.modal', function () {
        $('.choose-prd-modal-body').html('')
    });


    function removeDots(value) {
        return value.replace(/\./g, '');
    }

    $(document).ready(function () {
    });

})(jQuery);
