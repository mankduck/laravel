(function ($) {
    "use strict";
    var HT = {};
    var _token = $('meta[name="csrf-token"]').attr('content')


    $.fn.elExit = function () {
        return this.length > 0
    }



    HT.promotionNeverEnd = () => {
        $(document).on('change', '#neverEnd', function () {
            let _this = $(this)
            let isChecked = _this.prop('checked')
            if (isChecked) {
                $('input[name=endDate]').attr('disabled', true)
            } else {
                $('input[name=endDate]').attr('disabled', false)
            }
        })
    }

    HT.promotionSource = () => {
        $(document).on('click', '.chooseSource', function () {
            let _this = $(this)
            let flag = (_this.attr('id') == 'allSource') ? true : false
            if (flag) {
                _this.parents('.ibox-content').find('.source-wrapper').remove()
            } else {
                let sourceData = [
                    {
                        id: 1,
                        name: 'TikTok'
                    },
                    {
                        id: 2,
                        name: 'Shopee'
                    },
                    {
                        id: 3,
                        name: 'Lazada'
                    }
                ]
                let sourceHtml = HT.renderPromotionSource(sourceData).prop('outerHTML')
                _this.parents('.ibox-content').append(sourceHtml)
                HT.promotionMutipleSelect2()
            }
        })
    }

    HT.renderPromotionSource = (sourceData) => {
        // if (sourceData.length) {
        let wrapper = $('<div>').addClass('source-wrapper mt10')
        let select = $('<select>').addClass('multipleSelect2').attr('name', 'source').attr('multiple', true)
        for (let i = 0; i < sourceData.length; i++) {
            let option = $('<option>').attr('value', sourceData[i].id).text(sourceData[i].name)
            select.append(option)
        }
        wrapper.append(select)
        // }
        return wrapper
    }


    HT.chooseCustomerCondition = () => {
        $(document).on('click', '.chooseApply', function () {
            let _this = $(this)
            let id = _this.attr('id')
            if (id == 'allApply') {
                _this.parents('.ibox-content').find('.apply-wrapper').remove()
            } else {
                let applyData = [
                    {
                        id: 'staff_take_care_customer',
                        name: 'Nhân viên phụ trách'
                    },
                    {
                        id: 'customer_group',
                        name: 'Nhóm khách hàng'
                    },
                    {
                        id: 'customer_gender',
                        name: 'Giới tính'
                    },
                    {
                        id: 'customer_birthday',
                        name: 'Ngày sinh nhật'
                    }
                ]
                let applyHtml = HT.renderApplyCondition(applyData).prop('outerHTML')
                _this.parents('.ibox-content').append(applyHtml)
                HT.promotionMutipleSelect2()
            }
        })
    }


    HT.renderApplyCondition = (applyData) => {
        let wrapper = $('<div>').addClass('apply-wrapper')
        let wrapperConditionItem = $('<div>').addClass('wrapper-condition mt10')
        let select = $('<select>').addClass('multipleSelect2 conditionItem').attr('name', 'applyObject').attr('multiple', true)
        for (let i = 0; i < applyData.length; i++) {
            let option = $('<option>').attr('value', applyData[i].id).text(applyData[i].name)
            select.append(option)
        }
        wrapperConditionItem.append(select)
        wrapper.append(wrapperConditionItem)
        // }
        return wrapper
    }


    HT.chooseApplyItem = () => {
        $(document).on('change', '.conditionItem', function () {
            let _this = $(this)
            let condition = {
                value: _this.val(),
                label: _this.select2('data')
            }

            $('.wrapperConditionItem').each(function () {
                let _item = $(this)
                let itemClass = _item.attr('class').split(' ')[1]
                if (condition.value.includes(itemClass) == false) {
                    _item.remove()
                }
            })


            for (let i = 0; i < condition.value.length; i++) {
                let value = condition.value[i]
                let html = HT.createConditionItem(value, condition.label[i].text)
            }
        })
    }

    HT.createConditionLabel = (label, value) => {
        // let deleteButton = $('<div>').addClass('delete').html('<svg data-icon="TrashSolidLarge" aria-hidden="true" focusable="false" width="15" height="16" viewBox="0 0 15 16" class="bem-Svg" style="display: block;"><path fill="currentColor" d="M2 14a1 1 0 001 1h9a1 1 0 001-1V6H2v8zM13 2h-3a1 1 0 01-1-1H6a1 1 0 01-1 1H1v2h13V2h-1z"></path></svg>').attr('data-condition-item', value)
        let conditionLabel = $('<div>').addClass('conditionLabel').text(label)
        let flex = $('<div>').addClass('uk-flex uk-flex-middle uk-flex-space-between')
        let wrapperBox = $('<div>').addClass('mb10 mt20')

        // flex.append(conditionLabel).append(deleteButton)
        flex.append(conditionLabel)

        wrapperBox.append(flex)
        return wrapperBox.prop('outerHTML')
    }


    HT.createConditionItem = (value, label) => {

        let optionData = [
            {
                id: 1,
                name: 'Khách Vip'
            },
            {
                id: 2,
                name: 'Khách Bán Buôn'
            }
        ]
        let conditionItem = $('<div>').addClass('wrapperConditionItem ' + value)
        let select = $('<select>').addClass('multipleSelect2 objectItem').attr('name', 'customerGroup').attr('multiple', true)

        for (let i = 0; i < optionData.length; i++) {
            let option = $('<option>').attr('value', optionData[i].id).text(optionData[i].name)
            select.append(option)
        }
        const conditionLabel = HT.createConditionLabel(label, value)
        conditionItem.append(conditionLabel)
        conditionItem.append(select)
        if ($('.wrapper-condition').find('.' + value).elExit()) {
            return
        } else {
            $('.wrapper-condition').append(conditionItem)
        }

        HT.promotionMutipleSelect2()


    }




    HT.promotionMutipleSelect2 = () => {
        $('.multipleSelect2').select2({
            // minimumInputLength: 2,
            // placeholder: 'Nhập tối thiểu 2 kí tự để tìm kiếm',
            // ajax: {
            //     url: 'ajax/attribute/getAttribute',
            //     type: 'GET',
            //     dataType: 'json',
            //     deley: 250,
            //     data: function (params) {
            //         return {
            //             search: params.term,
            //             option: option,
            //         }
            //     },
            //     processResults: function (data) {
            //         return {
            //             results: data.items
            //         }
            //     },
            //     cache: true

            // }
        });
    }


    // HT.deleteCondition = () => {
    //     $(document).on('click', '.wrapperConditionItem', function () {
    //         let _this = $(this)
    //         let unSelectedValue = _this.attr('data-condition-item')
    //         let selectedItem = $('.conditionItem').val()           //Lấy ra 1 mảng các giá trị data-condition-item được chọn
    //         let indexOf = selectedItem.indexOf(unSelectedValue)   //Tìm ra vị trí phần tử cần xóa trong mảng

    //         if(indexOf !== -1){
    //             selectedItem.splice(selectedItem, indexOf)
    //         }
    //         $('.conditionItem').val(unSelectedValue).trigger('change')
    //     })
    // }

    $(document).ready(function () {
        HT.promotionNeverEnd()
        HT.promotionSource()
        HT.chooseCustomerCondition()
        HT.promotionMutipleSelect2()
        HT.chooseApplyItem()
        // HT.deleteCondition()
    });



})(jQuery);
