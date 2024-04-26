(function ($) {
    "use strict";
    var HT = {};
    var counter = 1

    HT.addSlide = (type) => {
        $(document).on('click', '.addSlide', function (e) {
            e.preventDefault()
            if (typeof (type) == 'undefined') {
                type = 'Images';
            }
            var finder = new CKFinder();
            finder.resourceType = type;
            finder.selectActionFunction = function (fileUrl, data, allFiles) {

                let html = '';
                for (var i = 0; i < allFiles.length; i++) {
                    var image = allFiles[i].url
                    html += HT.renderSlideItemHtml(image)
                }

                $('.slide-list').append(html)
                HT.checkSlideNotification()
            }
            finder.popup();
        })
    }

    HT.checkSlideNotification = () => {
        let slideItem = $('.slide-item')
        if (slideItem.length) {
            $('.slide-notification').hide()
        } else {
            $('.slide-notification').show()
        }
    }


    HT.renderSlideItemHtml = (image) => {

        let tab_1 = "tab-" + counter
        let tab_2 = "tab-" + (counter + 1)

        let html = `
        <div class="col-lg-12 ui-state-default">
            <div class="slide-item mb20">
                <div class="row">
                    <div class="col-lg-3">
                        <span class="silde-image img-cover">
                            <img src="${image}" alt="">
                            <input type="hidden" name="slide[title][]" value="${image}">
                            <button type="button" class="delete-slide"><i class="fa fa-trash"></i></button>
                        </span>
                    </div>
                    <div class="col-lg-9">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#${tab_1}">Thông tin
                                        chung</a></li>
                                <li class=""><a data-toggle="tab" href="#${tab_2}">SEO</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="${tab_1}" class="tab-pane active">
                                    <div class="panel-body">
                                        <div class="label-text mb10">Mô tả</div>
                                        <div class="form-row mb10">
                                            <textarea name="slide[description][]" class="form-control" placeholder=""></textarea>
                                        </div>
                                        <div class="form-row form-row-url">
                                            <input type="text" name="slide[url][]" class="form-control"
                                                placeholder="URL" value="" id="">
                                            <div class="overlay">
                                                <div class="uk-flex uk-flex-middle">
                                                    <label for="input_${tab_1}">Mở trong tab mới</label>
                                                    <input type="checkbox" name="slide[window][]" id="input_${tab_1}"
                                                        value="_blank">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="${tab_2}" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="label-text mb10">Tiêu đề</div>
                                        <div class="form-row form-row-url slide-seo-tab mb10">
                                            <input type="text" name="slide[title][]" class="form-control"
                                                placeholder="URL" value="" id="">
                                        </div>

                                        <div class="label-text mb10">Mô tả </div>
                                        <div class="form-row form-row-url slide-seo-tab">
                                            <input type="text" name="slide[alt][]" class="form-control"
                                                placeholder="URL" value="" id="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
`

        counter++

        return html
    }


    HT.deleteSlide = () => {
        $(document).on('click', '.delete-slide', function(){
            let _this = $(this)

            _this.parents('.ui-state-default').remove()
            HT.checkSlideNotification()
        })
    }

    $(document).ready(function () {
        HT.addSlide()
        HT.deleteSlide()
    });



})(jQuery);
