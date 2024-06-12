<h4>Caption 4</h4>
<div class="slider-layer-item">
    <h5>Layer 1</h5>
    <div class="p-2">
        {!! \SkillDo\Form\Form::render(['name' => 'caption[layer1][text]', 'type' => 'text', 'label' => 'Text layer 1'], $caption['layer1']['text']) !!}
        {!! \SkillDo\Form\Form::render(['name' => 'caption[layer1][color]', 'type' => 'color', 'label' => 'Color layer 1'], $caption['layer1']['color']) !!}
    </div>
</div>

<div class="slider-layer-item">
    <h5>Layer 2</h5>
    <div class="p-2">
        {!! \SkillDo\Form\Form::render(['name' => 'caption[layer2][text]', 'type' => 'text', 'label' => 'Text layer 2'], $caption['layer2']['text']) !!}
        {!! \SkillDo\Form\Form::render(['name' => 'caption[layer2][color]', 'type' => 'color', 'label' => 'Color layer 2'], $caption['layer2']['color']) !!}
    </div>
</div>

<div class="slider-layer-item">
    <h5>Layer 3</h5>
    <div class="p-2">
        {!! \SkillDo\Form\Form::render(['name' => 'caption[layer3][text]', 'type' => 'text', 'label' => 'Text layer 3'], $caption['layer3']['text']) !!}
        {!! \SkillDo\Form\Form::render(['name' => 'caption[layer3][color]', 'type' => 'color', 'label' => 'Color layer 3'], $caption['layer3']['color']) !!}
    </div>
</div>

<div class="slider-layer-item">
    <h5>Layer 4</h5>
    <div class="p-2">
        {!! \SkillDo\Form\Form::render(['name' => 'caption[layer4][text]', 'type' => 'text', 'label' => 'Text layer 4'], $caption['layer4']['text']) !!}
        {!! \SkillDo\Form\Form::render(['name' => 'caption[layer4][color]', 'type' => 'color', 'label' => 'Color layer 4'], $caption['layer4']['color']) !!}
        {!! \SkillDo\Form\Form::render(['name' => 'caption[layer4][bg]', 'type' => 'color', 'label' => 'Color layer 4'], $caption['layer4']['bg']) !!}
    </div>
</div>