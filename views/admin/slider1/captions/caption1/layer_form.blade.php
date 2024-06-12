<h4>Caption 1</h4>
<div class="slider-layer-item">
    <h5>Layer 1</h5>
    <div class="p-2">
        {!! \SkillDo\Form\Form::render(['name' => 'caption[layer1][text]', 'type' => 'text', 'label' => 'Text layer 1'], $caption['layer1']['text']) !!}
        {!! \SkillDo\Form\Form::render(['name' => 'caption[layer1][color]', 'type' => 'color', 'label' => 'Color layer 2'], $caption['layer1']['color'])!!}
    </div>
</div>

<div class="slider-layer-item">
    <h5>Layer 2</h5>
    <div class="p-2">
        {!! \SkillDo\Form\Form::render(['name' => 'caption[layer2][color]', 'type' => 'color', 'label' => 'Color layer 2'], $caption['layer2']['color']); !!}
    </div>
</div>

<div class="slider-layer-item">
    <h5>Layer 3</h5>
    <div class="p-2">
        {!! \SkillDo\Form\Form::render(['name' => 'caption[layer3][text]', 'type' => 'text', 'label' => 'Text layer 1'], $caption['layer3']['text']); !!}
        {!! \SkillDo\Form\Form::render(['name' => 'caption[layer3][color]', 'type' => 'color', 'label' => 'Color layer 2'], $caption['layer3']['color']); !!}
    </div>
</div>
