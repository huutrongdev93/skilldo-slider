<div class="box-header">
    {!! Admin::tabs([
        'background'    => ['label' => 'Background'],
    ], 'background') !!}
</div>
<div class="box-content">
    <div class="tab-content">
        <!-- Images -->
        <div role="tabpanel" class="tab-pane m-2 active" id="background">
            {!! $form->html() !!}
        </div>
    </div>
</div>

<div class="box-footer">
    <button class="btn btn-green" type="submit">{!! Admin::icon('save') !!} Lưu</button>
</div>
