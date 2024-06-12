<div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist">
        <li><a href="#bg" class="active" role="tab" data-bs-toggle="tab">Background</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active m-2" id="bg">
            <div id="bg_type_image">
                {!! $form->html() !!}
            </div>
        </div>
        <div class="button text-right">
            <button class="btn btn-green">{!! Admin::icon('save') !!} Lưu</button>
        </div>
    </div>
</div>
<style>
    .slider-layer-demo {
        float: left;
        width: 50%;
        position: relative;
    }
    .slider-layer-list {
        float: left;
        width: 35%;
        background: #fff;
        border: 5px solid #ccc;
        padding:5px;
        height: 420px;
        overflow-y: auto;
    }
    .slider-layer-list h4 {
        cursor: default;
        font-size: 14px;
        color: #888;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 14px;
        padding: 0;
        background: transparent;
    }
    .slider-layer-item h5 {
        padding: 10px 10px; color:#000; font-weight: bold;
        border-bottom: 1px dashed #888;
    }
    .slider-layer-item {
        overflow: hidden;
        background-color: var(--content-bg);
        margin-bottom: 10px;
    }
</style>

