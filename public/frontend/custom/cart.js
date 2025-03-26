(function ($) {
    "use strict";
    var HT = {};
    var _token = $('meta[name="csrf-token"]').attr('content');

    var proQty = $('.pro-qty');
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');


    HT.quantityProductInCart = () => {
        $('.pro-qty').on('click', '.qtybtn', function () {
            var $button = $(this);
            var $row = $button.closest('tr'); // Chỉ lấy dữ liệu của dòng hiện tại
            var $input = $row.find('input');
            var $cartClose = $row.find('.cart__close')
            var prdId = $cartClose.attr('data-prd-id')
            var oldValue = parseFloat($input.val());

            var priceText = $row.find('.cart__price').text().replace(/\D/g, ''); // Lấy giá trị số từ text
            var price = parseFloat(priceText) || 0;

            var newVal = oldValue;
            if ($button.hasClass('inc')) {
                newVal++;
            } else {
                if (oldValue > 1) newVal--;
            }

            HT.updateTotalCart(prdId, newVal)
            var totalPrice = price * newVal;
            $row.find('.cart__total').text(totalPrice.toLocaleString() + 'đ'); // Cập nhật total chỉ dòng đó
            $input.val(newVal);
            HT.updateCartTotal()
        });
    };

    HT.removePrdInCart = () => {
        $(document).on('click', '.cart__close', function () {
            var $row = $(this).closest('tr');
            Swal.fire({
                title: "Bạn muốn xóa khỏi giỏ hàng?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Đồng ý",
                cancelButtonText: "Hủy",
            }).then((result) => {
                if (result.isConfirmed) {
                    var prdId = $(this).attr('data-prd-id')
                    HT.ajaxRemovePrdInCart(prdId)
                } else {
                    Swal.fire("Đã hủy!", "Hành động đã bị hủy!", "error");
                }
            });

        })
    }

    HT.updateCartTotal = () => {
        let total = 0;

        $('.cart__total').each(function () {
            let priceText = $(this).text().replace(/[^\d]/g, '').trim();
            let price = parseFloat(priceText) || 0;
            total += price;
        });

        $('.sum-total-amount').text(total.toLocaleString('vi-VN') + 'đ');
    }

    HT.ajaxRemovePrdInCart = (prdId) => {
        let option = {
            'id': prdId,
            '_token': _token
        }

        $.ajax({
            url: 'ajax/frontend/removeCart',
            type: 'POST',
            data: option,
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        title: "Thành công!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.reload();
                    })
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


    HT.updateTotalCart = (prdId, total) => {
        let option = {
            'id': prdId,
            'total': total,
            '_token': _token
        }

        $.ajax({
            url: 'ajax/frontend/updateTotalCart',
            type: 'POST',
            data: option,
            dataType: 'json',
            success: function (response) {
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('Lỗi: ' + textStatus + ' ' + errorThrown);
            }
        });
    }

    $(document).ready(function () {
        HT.quantityProductInCart()
        HT.removePrdInCart()
        HT.updateCartTotal()
    });

})(jQuery);
