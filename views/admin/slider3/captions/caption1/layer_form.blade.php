<div class="box">
    <div class="box-header">
        <h4 class="box-title">Cấu hình caption 1</h4>
    </div>
    <div class="box-content">
        <div class="slider-layer-item">
            <div class="row">
                {!! \SkillDo\Form\Form::render(['start' => 6, 'field' => 'caption[position][x]', 'type' => 'tab', 'label' => 'Canh lề dọc', 'options' => ['top' => 'Trên', 'center' => 'Giữa', 'bottom' => 'Dưới']], $caption['position']['x']); !!}
                {!! \SkillDo\Form\Form::render(['start' => 6, 'field' => 'caption[position][y]', 'type' => 'tab','label' => 'Canh lề ngang', 'options' => ['left' => 'Trái', 'center' => 'Giữa', 'right' => 'Phải']], $caption['position']['y']); !!}
            </div>
        </div>
        <hr />
        <div class="slider-layer-item">
            <div class="row">
                {!! \SkillDo\Form\Form::render(['start' => 8, 'field' => 'caption[heading]', 'type' => 'text-building', 'label' => 'Tiêu đề'], $caption['heading'] ?? []) !!}
                {!! \SkillDo\Form\Form::render(['start' => 4, 'field' => 'caption[headingMobile]', 'type' => 'text-building', 'txtInput' => false, 'label' => '(mobile)'], $caption['headingMobile'] ?? []) !!}
            </div>
        </div>
        <hr />
        <div class="slider-layer-item">
            <div class="row">
                {!! \SkillDo\Form\Form::render(['start' => 8, 'field' => 'caption[description]', 'type' => 'text-building', 'label' => 'Mô tả'], $caption['description'] ?? []) !!}
                {!! \SkillDo\Form\Form::render(['start' => 4, 'field' => 'caption[descriptionMobile]', 'type' => 'text-building', 'txtInput' => false, 'label' => '(mobile)'], $caption['descriptionMobile'] ?? []) !!}
            </div>
        </div>
    </div>
</div>