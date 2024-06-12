<style>
    .sliderWidthTitle .slider_list_item .item {
        display:block!important;
    }
    .sliderWidthTitle .slider_list_item .item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .sliderWidthTitle .slider_list_thumb {
        background-color: var(--slider-thumb-bg);
    }
    .sliderWidthTitle .slider_list_thumb .item {
        width: 100%;
        cursor: pointer;
        padding: 10px 10px;
        outline: none;
    }
    .sliderWidthTitle .slider_list_thumb .item .heading {
        font-size: var(--slider-thumb-font-size); line-height: calc(var(--slider-thumb-font-size) + var(--slider-thumb-font-size)*0.5);
        text-align: center;
        margin: 0;
        height: calc((var(--slider-thumb-font-size) + var(--slider-thumb-font-size)*0.5)*2); overflow: hidden;
        color: var(--slider-thumb-color, #fff);
        display: flex; align-items: center;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* number of lines to show */
        line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .sliderWidthTitle .slider_list_thumb .slick-current .item {
        background-color:var(--slider-thumb-bg-active);
    }
    .sliderWidthTitle .slider_list_thumb .slick-current .item .heading {
        color:var(--slider-thumb-color-active);
    }
    .sliderWidthTitle .slider_list_thumb .item {
        margin-right: 1px;
    }
    .sliderWidthTitle.in-slider .slider_list_thumb {
        position: absolute; bottom: 0; left: 0; width: 100%;
    }
    .sliderWidthTitle .thumb-hidden .slider_list_thumb {
        display: none;
    }
</style>