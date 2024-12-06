<style>
    .sliderNoTitle .owl-carousel {
        display: none;
    }
    .sliderNoTitle .owl-carousel.slick-slider {
        display: block;
    }
    .sliderNoTitle .slider_list_item .sliderItem img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    body .sliderNoTitle .arrow {
        font-size: 30px;
        background-color:transparent!important;
        box-shadow: none;
    }
    body .sliderNoTitle .arrow i {
        text-shadow: 0 0 5px #fff;
    }
    body .sliderNoTitle .arrow:hover {
        background-color:transparent!important;
    }
    .sliderNoTitle .slick-dots {
        position: absolute;
        bottom: 25px;
        list-style: none;
        display: block;
        text-align: center;
        padding: 0;
        margin: 0;
        width: 100%;
    }
    .sliderNoTitle .slick-dots li {
        position: relative;
        display: inline-block;
        margin: 0 5px;
        padding: 0;
        cursor: pointer;
        height: 3px;
        width: 50px;
    }
    .sliderNoTitle .slick-dots li button {
        border: 0;
        display: block;
        outline: none;
        line-height: 0px;
        font-size: 0px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        background-color: white;
        opacity: 0.25;
        width: 50px;
        height: 3px;
        padding: 0;
    }
    .sliderNoTitle .slick-dots li button:before {
        display: none;
    }
    .sliderNoTitle .slick-dots li button:hover,
    .sliderNoTitle .slick-dots li button:focus {
        outline: none;opacity: 1;
    }
    .sliderNoTitle .slick-dots li.slick-active button {
        background-color: white;
        opacity: 0.75;
    }
    .sliderNoTitle .slick-dots li.slick-active button:hover,
    .sliderNoTitle .slick-dots li.slick-active button:focus {
        opacity: 1;
    }
    .sliderNoTitle .slick-track {
        display: flex;
        align-items: stretch;
    }
    .sliderNoTitle .slick-slide > div {
        height: 100%;
    }
    .sliderNoTitle .sliderItem {
        height: 100%;
        display: block!important;
    }
    .sliderNoTitle .sliderItem .sliderItemCaption {
        position: absolute;
        z-index: 99;
        width: 49%; height:50%;
        display:flex;
    }
    .sliderNoTitle .sliderItem .sliderItemCaption.positionY--center {
        left:0;
        width: 100%;
        justify-content: center;
        text-align: center;
    }
    .sliderNoTitle .sliderItem .sliderItemCaption.positionY--left {
        left: 100px; text-align: left;
    }
    .sliderNoTitle .sliderItem .sliderItemCaption.positionY--right {
        right: 100px; text-align: right;
    }
    .sliderNoTitle .sliderItem .sliderItemCaption.positionX--center {
        top:0;
        height: 100%;
        align-items: center;
    }
    .sliderNoTitle .sliderItem .sliderItemCaption.positionX--top {
        top: 10%;
    }
    .sliderNoTitle .sliderItem .sliderItemCaption.positionX--bottom {
        bottom: 10%; align-items: flex-end;
    }

    .sliderNoTitle .sliderItem .sliderItemCaption .sliderItemCaption-title {
        position: relative;
        color: #fff;
        font-family: var(--font-header);
        font-weight: bold;
        font-size: 24px;
        line-height: 30px;
        opacity: 0;
        visibility: hidden;
        -webkit-transition: all 500ms ease;
        -o-transition: all 500ms ease;
        transition: all 500ms ease;
        -webkit-transform: translateY(-20px);
        -ms-transform: translateY(-20px);
        transform: translateY(-20px);
        text-transform: capitalize;
    }
    .sliderNoTitle .sliderItem .sliderItemCaption .sliderItemCaption-detail {
        letter-spacing: 0.04em;
        margin-top: 40px;
        /* padding-right: 15%; */
        opacity: 0;
        visibility: hidden;
        -webkit-transition: all 500ms ease;
        -o-transition: all 500ms ease;
        transition: all 500ms ease;
        -webkit-transform: translateX(-50px);
        -ms-transform: translateX(-50px);
        transform: translateX(-50px);
        color: #fff;
        font-family: var(--font-family);
        font-weight: bold;
        font-size: 18px;
        line-height: 25px;
    }
    .sliderNoTitle .slick-current .sliderItem .sliderItemCaption .sliderItemCaption-title {
        opacity: 1;
        visibility: visible;
        -webkit-transition-delay: .3s;
        -o-transition-delay: .3s;
        transition-delay: .3s;
        -webkit-transform: translateY(0px);
        -ms-transform: translateY(0px);
        transform: translateY(0px);
    }
    .sliderNoTitle .slick-current .sliderItem .sliderItemCaption .sliderItemCaption-detail {
        opacity: 1;
        visibility: visible;
        -webkit-transition-delay: .5s;
        -o-transition-delay: .5s;
        transition-delay: .5s;
        -webkit-transform: translateX(0px);
        -ms-transform: translateX(0px);
        transform: translateX(0px);
    }
    @media(max-width:600px) {
        .sliderNoTitle .sliderItem .sliderItemCaption .sliderItemCaption-title {
            color: #fff;
            font-size: 18px;
        }
        .sliderNoTitle .sliderItem .sliderItemCaption .sliderItemCaption-detail {
            color: #fff;
            font-size: 14px;
        }
    }
</style>