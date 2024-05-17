(function ($) {
    "use strict";
    var HT = {};
    var _token = $('meta[name="csrf-token"]').attr('content')
    var typingTimer
    var doneTypingInterval = 300 //1s

    HT.searchModel = () => {
        $(document).on('keyup', '.search-model', function () {
            let _this = $(this)
            if ($('input[type=radio]:checked').length === 0) {
                alert('Bạn chưa chọn Module!')
                _this.val('')
                return false
            }
            let keyword = _this.val()
            let option = {
                model: $('input[type=radio]:checked').val(),
                keyword: keyword
            }
            clearTimeout(typingTimer)
            typingTimer = setTimeout(function () {
                HT.sendAjax(option)
            }, doneTypingInterval)
        })
    }


    HT.chooseModel = () => {
        $(document).on('change', '.input-radio', function () {
            let _this = $(this)
            let option = {
                model: _this.val(),
                keyword: $('.search-model').val()
            }

            $('.search-model-result').html('')

            if (keyword.length >= 2) {
                HT.sendAjax(option)
            }
        })
    }


    HT.sendAjax = (option) => {
        $.ajax({
            url: 'ajax/dashboard/findModelObject',
            type: 'GET',
            data: option,
            dataType: 'json',
            success: function (res) {
                let html = HT.renderSearchResult(res)
                if (html.length) {
                    $('.ajax-search-result').html(html).show()
                } else {
                    $('.ajax-search-result').html(html).hide()
                }
            },
            beforeSend: function () {
                $('.ajax-search-result').html('').hide()
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }

    HT.renderSearchResult = (data) => {
        let html = ''
        if (data.length) {
            for (let i = 0; i < data.length; i++) {

                let flag = ($('#model-' + data.id).length) ? 1 : 0
                let setChecked = ($('#model-' + data.id).length) ? HT.setChecked() : ''

                html += `
                <button class="ajax-search-item" data-flag="${flag}" data-canonical="${data[i].languages[0].pivot.canonical}" data-name="${data[i].languages[0].pivot.name}" data-image="${data[i].image}" data-id="${data[i].id}">
                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                        <span>${data[i].languages[0].pivot.name}</span>
                        <div class="auto-icon">
                            ${setChecked}
                        </div>
                    </div>
                </button>
                `
            }
        }
        return html
    }

    HT.autoIcon = () => {
        return `
        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="12"
            height="12" viewBox="0 0 25 25">
                <path
                d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z">
            </path>
        </svg>
        `
    }

    HT.unfocusSearchBox = () => {
        $(document).on('click', 'html', function (e) {
            if (!$(e.target).hasClass('search-model-box') || !$(e.target).hasClass('search-model')) {
                $('.ajax-search-result').html('')
            }
        })

        $(document).on('click', '.ajax-search-result', function (e) {
            e.stopPropagation()
        })
    }


    HT.addModel = () => {
        $(document).on('click', '.ajax-search-item', function (e) {
            e.preventDefault()
            let _this = $(this)

            let data = _this.data()
            let flag = _this.attr('data-flag')

            if (flag == 0) {
                _this.find('.auto-icon').html(HT.autoIcon())
                _this.attr('data-flag', 1)
                $('.search-model-result').append(HT.modelTemplate(data))
            } else {
                $('#model-' + data.id).remove()
                _this.find('.auto-icon').html('')
                _this.attr('data-flag', 0)
            }

        })
    }


    HT.modelTemplate = (data) => {
        let html = `
            <div class="search-result-item" id="model-${data.id}" data-modelid="${data.id}">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <div class="uk-flex uk-flex-middle">
                        <span class="image img-cover">
                            <img src="${data.image}" alt="">
                        </span>
                        <span class="name">${data.name}</span>
                    </div>
                    <div class="deleted">
                        <button class=""><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
        `
        return html
    }

    $(document).ready(function () {
        HT.searchModel()
        HT.unfocusSearchBox()
        HT.addModel()
    });



})(jQuery);
