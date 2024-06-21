let itemId = 0, sliderId = 0, sliderType;

let SliderHandler = function() {
    $( document )
        .on('click','.js_slider__delete', this.delete)
        .on('click','.js_slider__options', this.optionsLoad)
        .on('submit','#js_slider_form__options', this.optionsSave)
        .on('click','#js_slider_item__add', this.itemAdd)
        .on('click','.js_slider_item', this.itemInfo)
        .on('click','.js_slider_item__delete', this.itemDelete)
        .on('submit','#js_slider_item__edit', this.itemSave)

    if(typeof $('#js_slider_item__sort').html() != 'undefined') {
        Sortable.create(js_slider_item__sort, {
            animation: 200,
            // Element dragging ended
            onEnd: function (/**Event*/evt) {
                let o = 0;
                $.each($(".js_slider_item"), function (e) {
                    let i = $(this).attr("data-id");
                    $('#js_slider_item_sort_' + i).val(o);
                    o++;
                });
                SliderHandler.prototype.itemSort();
            },
        });
        $('.js_slider_item').first().trigger('click');
    }
};

SliderHandler.prototype.add = function(element) {

    let loading  = SkilldoUtil.buttonLoading(element.find('button[type="submit"]'))

    let name 	= element.find('input[name="name"]').val();

    let type 	= element.find('input[name="type"]:checked').val();

    if(name.length === 0) {
        SkilldoMessage.error('Không được bỏ trống tên slider');
        return false;
    }

    if(typeof type == 'undefined' || type.length === 0) {
        SkilldoMessage.error('Bạn chưa chọn loại slider');
        return false;
    }

    loading.loading()

    let data = {
        'action' 		: 'AdminAjaxSlider::add',
        'name' 			: name,
        'type' 			: type,
    };

    request.post(ajax, data).then(function( response ) {

        SkilldoMessage.response(response);

        loading.success()

        if(response.status === 'success') {

            window.location.reload();
        }
    });

    return false;
};

SliderHandler.prototype.delete = function(e) {

    sliderId 	= $(this).data('id');

    let data = {
        'action' 		: 'AdminAjaxSlider::delete',
        'id' 			: sliderId,
    };

    request.post(ajax, data).then(function( response ) {

        SkilldoMessage.response(response);

        if(response.status === 'success') {
            window.location.reload();
        }
    });

    return false;
};

SliderHandler.prototype.optionsLoad = function(e) {

    sliderId 	= $(this).data('id');

    $('#sliderOptionsModal .loading').show();

    $('.js_slider_options_box').show();

    $('#sliderOptionsModal #sliderOptionsModal_content').html('');

    let data = {
        'action'    : 'AdminAjaxSlider::optionsLoad',
        'id' 	    : sliderId,
    };

    request.post(ajax, data).then(function( response ) {

        $('#sliderOptionsModal .loading').hide();

        if(response.status === 'success') {
            $('#sliderOptionsModal #sliderOptionsModal_content').html(response.data);
            formBuilderReset();
        }
        else {
            SkilldoMessage.response(response);
        }
    });

    return false;
};

SliderHandler.prototype.optionsSave = function(e) {

    $('#sliderOptionsModal .loading').show();

    let data = $(this).serializeJSON();

    data.action = 'AdminAjaxSlider::optionsSave';

    data.id = sliderId;

    request.post(ajax, data).then(function( response ) {

        $('#sliderOptionsModal .loading').hide();

        SkilldoMessage.response(response);

        if(response.status === 'success') {

            $('#sliderOptionsModal').modal('hide');
        }
    });

    return false;
};

SliderHandler.prototype.itemInfo = function(e) {

    $('.js_slider_item .item').removeClass('active');

    $(this).find('.item').addClass('active');

    $('#js_slider_item_box__edit .loading').show();

    itemId = $(this).attr('data-id');

    sliderId = $(this).attr('data-group');

    sliderType = $(this).attr('data-type');

    let data = {
        'action'    : 'AdminAjaxSlider::itemLoad',
        'id' 	    : itemId,
        'sliderType': sliderType,
    };

    request.post(ajax, data).then(function( response ) {

        $('#js_slider_item_box__edit .loading').hide();

        if(response.status === 'success') {

            $('#js_slider_item__edit').html(response.data);

            FormHelper.reset();
        }
        else {
            SkilldoMessage.response(response);
        }
    });

    return false;
};

SliderHandler.prototype.itemAdd = function(e) {

    sliderId = $(this).attr('data-id');

    sliderType = $(this).attr('data-type');

    let data = {
        'action' 	: 'AdminAjaxSlider::itemAdd',
        'sliderId' 	: sliderId,
    };

    request.post(ajax, data).then(function( response ) {
        SkilldoMessage.response(response);
        if(response.status === 'success') {
            window.location = base + '/plugins?page=slider&view=detail&id=' + sliderId;
        }
        if(response.status === 'success') {
            location.reload();
        }
    });

    return false;
};

SliderHandler.prototype.itemSave = function(e) {

    let data = $(this).serializeJSON();

    data.action = 'AdminAjaxSlider::itemSave';

    data.id = itemId;

    data.type = sliderType;

    request.post(ajax, data).then(function( response ) {
        SkilldoMessage.response(response);
    });

    return false;
};

SliderHandler.prototype.itemSort = function(e) {

    let data = $(':input', $('#js_slider_item__sort')).serializeJSON();

    data.action = 'AdminAjaxSlider::itemSort';

    request.post(ajax, data).then(function( response ) {
        SkilldoMessage.response(response);
    });

    return false;
};

SliderHandler.prototype.itemDelete = function(e) {

    let box = $(this).closest('.js_slider_item');

    let id = box.attr('data-id');

    let data = {
        'action' : 'AdminAjaxSlider::itemDelete',
        'id'	 : id,
    };

    request.post(ajax, data).then(function( response ) {
        SkilldoMessage.response(response);
        if(response.status === 'success') {
            box.remove();
            if(id == itemId) {
                itemId = 0;
                $('#js_slider_item__edit').html('');
            }
        }
    });

    return false;
};

$(function () {
    if(typeof $('.list-sliders').html() != 'undefined') {
        new SliderHandler();
    }
});