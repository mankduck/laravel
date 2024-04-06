(function($) {
	"use strict";
	var HT = {}; 

    HT.setupProductVariant = () => {
        if($('.turnOnVariant').length){
            $(document).on('click', '.turnOnVariant', function(){
                let _this = $(this)
                if(_this.siblings('input:checked').length == 0){
                    $('.variant-wrapper').removeClass('hidden')
                }else{
                    $('.variant-wrapper').addClass('hidden')
                }
            })
        }
    }

    HT.addVariant = () => {
        if($('.add-variant').length){
            $(document).on('click', '.add-variant', function(){
                let html = HT.renderVariantItem(attributeCatalogue)
                $('.variant-body').append(html)
                HT.checkMaxAttributeGroup(attributeCatalogue);
                HT.disabledAttributeCatalogueChoose();
            })
        }
    }

    HT.renderVariantItem = (attributeCatalogue) => {
        let html = '';
        html = html + '<div class="row mb20 variant-item">';
            html = html + '<div class="col-lg-3">';
                html = html + '<div class="attribute-catalogue">';
                    html = html + '<select name="" id="" class="choose-attribute niceSelect">';
                        html = html + '<option value="">Chọn Nhóm thuộc tính</option>';
                        for(let i = 0; i < attributeCatalogue.length; i++){
                        html = html + '<option value="'+attributeCatalogue[i].id+'">'+attributeCatalogue[i].name+'</option>';
                        }
                    html = html + '</select>';
                html = html + '</div>';
            html = html + '</div>';
            html = html + '<div class="col-lg-8">';
                html = html + '<input type="text" name="" disabled class="fake-variant form-control">';
            html = html + '</div>';
            html = html + '<div class="col-lg-1">';
                html = html + '<button type="button" class="remove-attribute btn btn-danger"><svg data-icon="TrashSolidLarge" aria-hidden="true" focusable="false" width="15" height="16" viewBox="0 0 15 16" class="bem-Svg" style="display: block;"><path fill="currentColor" d="M2 14a1 1 0 001 1h9a1 1 0 001-1V6H2v8zM13 2h-3a1 1 0 01-1-1H6a1 1 0 01-1 1H1v2h13V2h-1z"></path></svg></button>';
            html = html + '</div>';
        html = html + '</div>';

        return html;
    }

    HT.chooseVariantGroup = () => {
        $(document).on('change', '.choose-attribute', function(){
            let _this = $(this)
            let attributeCatalogueId = _this.val()
            if(attributeCatalogueId != 0){
                _this.parents('.col-lg-3').siblings('.col-lg-8').html(HT.select2Variant(attributeCatalogueId))
                $('.selectVariant').each(function(key, index){
                    HT.getSelect2($(this))
                })
            }else{
                _this.parents('.col-lg-3').siblings('.col-lg-8').html('<input type="text" name="" disabled="" class="fake-variant form-control">')
            }

            HT.disabledAttributeCatalogueChoose();
        })
    }


    HT.createProductVariant = () => {
        $(document).on('change', '.selectVariant', function(){
            let _this = $(this)
            HT.createVariant()
        })
    }

    HT.createVariant = () => {

        let attributes = []
        let variant = []
        let attributeTitle = []

        $('.variant-item').each(function(){
            let _this = $(this)
            let attr = []
            const attributeCatalogueId = _this.find('.choose-attribute').val()
            const optionText = _this.find('.choose-attribute option:selected').text()
            const attribute = $('.variant-'+attributeCatalogueId).select2('data')

            for(let i = 0; i < attribute.length; i++){
                let item = {}
                let itemVariant = {}
                item[optionText] = attribute[i].text
                attr.push(item)
            }
            attributeTitle.push(optionText)
            attributes.push(attr)

        })
       
        attributes = attributes.reduce(
            (a, b) => a.flatMap( d => b.map( e => ( {...d, ...e} ) ) )
        )

        let html = HT.renderTableHtml(attributes, attributeTitle);
        $('table.variantTable').html(html)
        
    }

    HT.renderTableHtml = (attributes, attributeTitle) => {
        let html = ''

        html = html + '<thead>'
            html = html + '<tr>'
                html = html + '<td>Hình ảnh</td>'
                for(let i = 0; i < attributeTitle.length; i++){
                    html = html + '<td>'+attributeTitle[i]+'</td>'
                }
               
                html = html + '<td>Số lượng</td>'
                html = html + '<td>Giá tiền</td>'
                html = html + '<td>SKU</td>'
            html = html + '</tr>'
        html = html + '</thead>'
        html = html + '<tbody>'
            for(let j = 0; j < attributes.length; j++){
                html = html + '<tr class="variant-row">'
                    html = html + '<td>'
                        html = html + '<span class="image img-cover"><img src="https://daks2k3a4ib2z.cloudfront.net/6343da4ea0e69336d8375527/6343da5f04a965c89988b149_1665391198377-image16-p-500.jpg" alt=""></span>'
                    html = html + '</td>'
                    $.each(attributes[j], function(idex, value){
                        html = html + '<td>'+value+'</td>'
                    })
                    
                    html = html + '<td>-</td>'
                    html = html + '<td>-</td>'
                    html = html + '<td>-</td>'
                html = html + '</tr>'
            }
            
        html = html + '</tbody>'

        return html
    }

    HT.getSelect2 = (object) => {
        let option = {
            'attributeCatalogueId' : object.attr('data-catid')
        }
        $(object).select2({
            minimumInputLength: 2,
            placeholder: 'Nhập tối thiểu 2 kí tự để tìm kiếm',
            ajax: {
                url: 'ajax/attribute/getAttribute',
                type: 'GET',
                dataType: 'json',
                deley: 250,
                data: function (params){
                    return {
                        search: params.term,
                        option: option,
                    }
                },
                processResults: function(data){
                    return {
                        results: data.items
                    }
                },
                cache: true
              
              }
        });
    }

    HT.niceSelect = () => {
        $('.niceSelect').niceSelect();
    }

    HT.destroyNiceSelect = () => {
        if($('.niceSelect').length){
            $('.niceSelect').niceSelect('destroy')
        }
    }
    
    HT.disabledAttributeCatalogueChoose = () => {
        let id = [];
        $('.choose-attribute').each(function(){
            let _this = $(this)
            let selected = _this.find('option:selected').val()
            if(selected != 0){
                id.push(selected)
            }
        })


        $('.choose-attribute').find('option').removeAttr('disabled')
        for(let i = 0; i < id.length; i++){
            $('.choose-attribute').find('option[value='+id[i]+']').prop('disabled', true)
        }
        HT.destroyNiceSelect()
        HT.niceSelect()
        $('.choose-attribute').find('option:selected').removeAttr('disabled')
    }

    HT.checkMaxAttributeGroup = (attributeCatalogue) => {
        let variantItem = $('.variant-item').length
        if(variantItem >= attributeCatalogue.length){
            $('.add-variant').remove()
        }else{
            $('.variant-foot').html('<button type="button" class="add-variant">Thêm phiên bản mới</button>')
        }
    }

    HT.removeAttribute = () => {
        $(document).on('click', '.remove-attribute', function(){
            let _this = $(this)
            _this.parents('.variant-item').remove()
            HT.checkMaxAttributeGroup(attributeCatalogue)
        })
    }

    HT.select2Variant = (attributeCatalogueId) => {
        let html = '<select class="selectVariant variant-'+attributeCatalogueId+' form-control" name="attribute['+attributeCatalogueId+'][]" multiple data-catid="'+attributeCatalogueId+'"></select>'
        return html
    }

    HT.variantAlbum = () => {
        $(document).on('click', '.click-to-upload-variant', function(e){
            HT.browseVariantServerAlbum()
            e.preventDefault();
        })
    }

    HT.browseVariantServerAlbum = () => {
        var type = 'Images';
        var finder = new CKFinder();
        
        finder.resourceType = type;
        finder.selectActionFunction = function( fileUrl, data, allFiles ) {
            let html = '';
            for(var i = 0; i < allFiles.length; i++){
                var image = allFiles[i].url
                html += '<li class="ui-state-default">'
                   html += ' <div class="thumb">'
                       html += ' <span class="span image img-scaledown">'
                            html += '<img src="'+image+'" alt="'+image+'">'
                            html += '<input type="hidden" name="variantAlbum[]" value="'+image+'">'
                        html += '</span>'
                        html += '<button class="variant-delete-image"><i class="fa fa-trash"></i></button>'
                    html += '</div>'
                html += '</li>'
            }
           
            $('.click-to-upload-variant').addClass('hidden')
            $('#sortable2').append(html)
            $('.upload-variant-list').removeClass('hidden')
        }
        finder.popup();
    }

    HT.deleteVariantAlbum = () => {
        $(document).on('click','.variant-delete-image', function(){
            let _this = $(this)
            _this.parents('.ui-state-default').remove()
            if($('.ui-state-default').length == 0){
                $('.click-to-upload-variant').removeClass('hidden')
                $('.upload-variant-list').addClass('hidden')
            }
        })
    }

    HT.switchChange = () => {
        $(document).on('change', '.js-switch', function(){
            let _this = $(this)
            let isChecked = _this.prop('checked');
            if(isChecked == true){
                _this.parents('.col-lg-2').siblings('.col-lg-10').find('.disabled').removeAttr('disabled')
            }else{
                _this.parents('.col-lg-2').siblings('.col-lg-10').find('.disabled').attr('disabled', true)
            }
        })
    }

	$(document).ready(function(){
        // HT.setupProductVariant()
        HT.addVariant()
        HT.niceSelect()
        HT.chooseVariantGroup()
        HT.removeAttribute()
        HT.createProductVariant()
        HT.variantAlbum()
        HT.deleteVariantAlbum()
        HT.switchChange()
	});

})(jQuery);

