/*
 * Slider Index Class
 * - A class for handling slider index functionalities
 * - Uses jQuery for DOM manipulation
 * - Handles adding, removing, and updating slider index
 * - Assumes the existence of a loading element with id 'js_slider_loading'
 * - Assumes the existence of a list wrapper element with id 'js_slider_list_wrapper'
 */
class SliderIndex {
    constructor()
    {
        this.id = 0;

        this.element = {
            loading: document.getElementById('js_slider_loading'),
            sliderList: document.getElementById('js_slider_list_wrapper'),
            optionsBox: document.getElementsByClassName('js_slider_options_box'),
            optionsContent: document.getElementById('sliderOptionsModal_content'),
            optionsLoading: null,
        }

        if(this.element.loading && this.element.sliderList)
        {
            this.element.optionsLoading = document.getElementById('sliderOptionsModal').querySelector('.loading');

            let self = this;

            $(document)
                .on('click','.js_slider_options_btn', function () {
                    self.optionsLoad($(this))
                    return false;
                })
                .on('submit','#js_slider_options_form', function () {
                    self.optionsSave($(this))
                    return false;
                })

            this.load();
        }
    }

    load() {

        this.element.loading.style.display = 'block';

        request.post(ajax, { action: 'SliderAdminAjax::load' }).then(function(response) {

            this.element.loading.style.display = 'none';

            if(response.status === 'success')
            {
                this.element.sliderList.innerHTML = response.data.slider;

                SkilldoConfirm.init();
            }
        }.bind(this));
    }

    add(element){

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

        loading.start()

        let data = {
            'action' 		: 'SliderAdminAjax::sliderAdd',
            'name' 			: name,
            'type' 			: type,
        };

        request.post(ajax, data).then(function( response ) {

            SkilldoMessage.response(response);

            loading.stop()

            if(response.status === 'success')
            {
                this.element.sliderList.insertAdjacentHTML("afterbegin", response.data.slider)

                bootstrap.Modal.getInstance(document.getElementById("modelAddSlider")).hide();

                SkilldoConfirm.init();
            }
        }.bind(this));

        return false;
    }

    optionsLoad(element) {

        this.id = element.data('id');

        this.element.optionsLoading.style.display = 'block';

        this.element.optionsBox[0].style.display = 'block';

        this.element.optionsContent.innerHTML = '';

        let data = {
            'action'    : 'SliderAdminAjax::optionsLoad',
            'id' 	    : this.id,
        };

        request.post(ajax, data).then(function( response ) {

            this.element.optionsLoading.style.display = 'none';

            if(response.status === 'success')
            {
                this.element.optionsContent.innerHTML = response.data.html;

                FormHelper.reset();
            }
            else
            {
                SkilldoMessage.response(response);
            }
        }.bind(this));

        return false;
    }

    optionsSave(element) {

        this.element.optionsLoading.style.display = 'block';

        let data = element.serializeJSON();

        data.action = 'SliderAdminAjax::optionsSave';

        data.id = this.id;

        request.post(ajax, data).then(function( response ) {

            this.element.optionsLoading.style.display = 'none';

            SkilldoMessage.response(response);
        }.bind(this));

        return false;
    }

    deleteSuccess(response, button)
    {
        $(button.button).closest('.slider-item').remove();
    }
}

const sliderIndex = new SliderIndex()

/*
 * Slider Detail Class
 *
 * @package    Skilldo
 * @author     Skilldo Team
 * @copyright  2017 Skilldo
 * @link      https://skilldo.vn
 */
let sliderReview = null;

const SliderReview = {
    captionSlider1 : () => {
        sliderReview = $('.slider_demo_caption').revolution({
            delay:1500,
            startWidth:1170,
            startHeight:500,
            height:500,
            hideThumbs:10,

            touchEnabled:"on",
            onHoverStop:"off",

            navigationHAlign:"center",
            navigationVAlign:"bottom",
            navigationHOffset:0,
            navigationVOffset:0,

            soloArrowLeftHAlign:"left",
            soloArrowLeftVAlign:"center",
            soloArrowLeftHOffset:20,
            soloArrowLeftVOffset:0,

            soloArrowRightHAlign:"right",
            soloArrowRightVAlign:"center",
            soloArrowRightHOffset:20,
            soloArrowRightVOffset:0,

            shadow:0,
            fullWidth:"on",
            fullScreen:"off",

            stopLoop:"on",
            stopAfterLoops:0,
            stopAtSlide:1,


            shuffle:"off",

            autoHeight:"off",
            forceFullWidth:"off",

            hideThumbsOnMobile:"off",
            hideBulletsOnMobile:"on",
            hideArrowsOnMobile:"on",
            hideThumbsUnderResolution:0,

            hideSliderAtLimit:0,
            hideCaptionAtLimit:768,
            hideAllCaptionAtLimit:0,
            startWithSlide:0,
            fullScreenOffsetContainer: ""
        })
    },
    callChanger1: () => {
        let anim    = $('#transition_effect').val();
        let timer   = $('#transition_speed').val();
        let slot    = $('#transition_slot').val();

        $('.slider_demo_caption ul li').each(function() {
            $(this).data("transition",anim);
            $(this).data("slotamount",slot);
            $(this).data("masterspeed",timer);
        });

        sliderReview.revnext();
    },
    captionSlider3 : () => {

        let slider = $('.slider_demo_caption');

        let sliderWidth = slider.width();

        let sliderHeight = Math.ceil(sliderWidth*(parseFloat(1)/parseFloat(2)));

        $('.slider_demo_caption .sliderItem').css('height', sliderHeight+'px');

        let sliderMain = slider.find('.js_slider_title_list');

        sliderMain.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            autoplay: false,
            loop:true,
            lazyLoad: 'progressive',
            dots: true,
        });
    },
}

class SliderCaption
{
    constructor() {

        this.slider = {
            itemId: null,
            type: null,
        }

        this.captionKey = null;

        this.element = {
            captionItem: $('.slider-caption-list .nav-item a')
        }

        if(this.element.captionItem)
        {
            this.events();
        }
    }

    init(id, type)
    {
        this.element = {
            captionItem: $('.slider-caption-list .nav-item a'),
            captionForm: $('#js_slider_item_caption__form'),
            captionDemo: $('#js_slider_item_caption__demo'),
        }

        this.slider.itemId = id;

        this.slider.type = type;
    }

    clickCaption(element)
    {
        this.element.captionItem.removeClass('active');

        this.element.captionItem.find('input[type="radio"]').prop('checked', false);

        element.find('input[type="radio"]').prop('checked', true);

        element.addClass('active');

        this.captionKey = element.find('input[type="radio"]').val();

        if(this.captionKey === 'none')
        {
            this.element.captionForm.html('');
            this.element.captionDemo.html('');
        }
        else
        {
            this.loadCaption();
        }
    }

    loadCaption() {
        request.post(ajax, {
            action  : 'SliderItemAdminAjax::captionLoad',
            id      : this.slider.itemId,
            type    : this.slider.type,
            key     : this.captionKey,
        })
        .then(function(response) {

            if(response.status === 'success')
            {
                this.element.captionForm.html(response.data.form);
                this.element.captionDemo.html(response.data.demo);

                if(this.slider.type == 'slider1')
                {
                    SliderReview.captionSlider1()
                }

                if(this.slider.type == 'slider3')
                {
                    SliderReview.captionSlider3()
                }
            }
        }.bind(this));
    }

    events() {
        let self = this;

        $(document).on('click', '.slider-caption-list .nav-item a', function() {
            self.clickCaption($(this));
            return false
        })
    }
}

const sliderCaption = new SliderCaption();

class SliderTransition
{
    constructor() {

        this.slider = {
            itemId: null,
            type: null,
        }

        this.transitionKey = null;

        this.element = {
            transitionItem: $('.slider-transition-list .nav-item a')
        }

        this.events();
    }

    init(id, type)
    {
        this.element = {
            transitionItem: $('.slider-transition-list .nav-item a'),
            transitionForm: $('#js_slider_item_transition__form'),
            transitionDemo: $('#js_slider_item_transition__demo'),
        }

        this.slider.itemId = id;

        this.slider.type = type;
    }

    clickTransition(element)
    {
        this.element.transitionItem.removeClass('active');

        this.element.transitionItem.find('input[type="radio"]').prop('checked', false);

        element.find('input[type="radio"]').prop('checked', true);

        element.addClass('active');

        this.transitionKey = element.find('input[type="radio"]').val();

        if(this.transitionKey === 'none')
        {
            this.element.transitionForm.html('');
            this.element.transitionForm.html('');
        }
        else
        {
            this.loadTransition();
        }
    }

    loadTransition() {
        request.post(ajax, {
            action  : 'SliderItemAdminAjax::transitionLoad',
            id      : this.slider.itemId,
            type    : this.slider.type,
            key     : this.transitionKey,
        })
            .then(function(response) {

                if(response.status === 'success')
                {
                    this.element.transitionForm.html(response.data.form);
                    this.element.transitionDemo.html(response.data.demo);

                    if(this.slider.type == 'slider1')
                    {
                        if(this.slider.type == 'slider1')
                        {
                            SliderReview.captionSlider1()
                        }
                    }
                }
            }.bind(this));
    }

    events() {
        let self = this;

        $(document).on('click', '.slider-transition-list .nav-item a', function() {
            self.clickTransition($(this));
            return false
        })
    }
}

const sliderTransition = new SliderTransition();

class SliderDetail
{
    constructor()
    {
        this.element = {
            list: document.getElementById('js_slider_items_list'),
            editBox: document.getElementById('js_slider_item_edit_form'),
            editLoading: null,
        }

        this.id = 0;

        if(this.element.list)
        {
            this.element.editLoading = document.getElementById('js_slider_item_edit').querySelector('.loading');

            this.sliderId = document.querySelector('.slider-detail').getAttribute('data-slider-id');

            this.sliderType = document.querySelector('.slider-detail').getAttribute('data-slider-type');

            let self = this;

            Sortable.create(this.element.list, {
                animation: 200,
                // Element dragging ended
                onEnd: function (/**Event*/evt) {
                    let o = 0;
                    $.each($(".js_slider_item"), function (e) {
                        let i = $(this).attr("data-id");
                        $('#js_slider_item_sort_' + i).val(o);
                        o++;
                    });
                    self.sort();
                },
            });

            this.event();

            $('.js_slider_item .js_slider_item_inner').first().trigger('click');
        }
    }

    add(element)
    {
        let data = {
            'action' 	: 'SliderItemAdminAjax::add',
            'sliderId' 	: this.sliderId,
            'sliderType': this.sliderType,
        };

        request.post(ajax, data).then(function( response )
        {
            SkilldoMessage.response(response);

            if(response.status === 'success')
            {
                this.element.list.insertAdjacentHTML("afterbegin", response.data.item)

                SkilldoConfirm.init();

                $('.js_slider_item .js_slider_item_inner').first().trigger('click');
            }
        }.bind(this));
    }

    edit(element)
    {
        $('.js_slider_item .item').removeClass('active');

        element.addClass('active');

        this.id = element.data('id');

        this.element.editLoading.style.display = 'block';

        let data = {
            action      : 'SliderItemAdminAjax::info',
            id 	        : this.id,
            sliderType  : this.sliderType,
        };

        request.post(ajax, data).then(function( response ) {

            this.element.editLoading.style.display = 'none';

            if(response.status === 'success') {

                this.element.editBox.innerHTML = response.data;

                if(this.sliderType == 'slider1')
                {
                    SliderReview.captionSlider1()
                }

                if(this.sliderType == 'slider3')
                {
                    SliderReview.captionSlider3()
                }

                sliderCaption.init(this.id, this.sliderType);

                sliderTransition.init(this.id, this.sliderType);

                FormHelper.reset();
            }
            else
            {
                SkilldoMessage.response(response);
            }
        }.bind(this));

        return false;
    }

    save(form)
    {
        let loading = SkilldoUtil.buttonLoading(form.find('button[type="submit"]'));

        let data = form.serializeJSON();

        data.action = 'SliderItemAdminAjax::save';

        data.id = this.id;

        data.type = this.sliderType;

        loading.start();

        request.post(ajax, data).then(function( response )
        {
            loading.stop();
            SkilldoMessage.response(response);
        });

        return false;
    }

    sort(element)
    {
        let data = $(':input', this.element.list).serializeJSON();

        data.action = 'SliderItemAdminAjax::sort';

        request.post(ajax, data).then(function( response ) {
            SkilldoMessage.response(response);
        });

        return false;
    }

    deleteSuccess(response, button)
    {
        $(button.button).closest('.js_slider_item').remove();
    }

    event()
    {
        let self = this;

        $(document)
            .on('click','#js_slider_item__add', function () {
                self.add($(this));
                return false;
            })
            .on('click','.js_slider_item_inner', function () {
                self.edit($(this));
                return false;
            })
            .on('submit','#js_slider_item_edit_form', function () {
                self.save($(this));
                return false;
            });
    }
}

const sliderDetail = new SliderDetail()