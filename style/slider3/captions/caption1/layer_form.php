<h4>Cấu hình caption 1</h4>
<hr />
<div class="slider-layer-item">
    <div class="row">
        <?php
            echo FormBuilder::render(['start' => 6, 'field' => 'caption[position][x]', 'type' => 'tab', 'label' => 'Canh lề dọc', 'options' => ['top' => 'Trên', 'center' => 'Giữa', 'bottom' => 'Dưới']], $caption['position']['x']);
            echo FormBuilder::render(['start' => 6, 'field' => 'caption[position][y]', 'type' => 'tab','label' => 'Canh lề ngang', 'options' => ['left' => 'Trái', 'center' => 'Giữa', 'right' => 'Phải']], $caption['position']['y']);
        ?>
    </div>
</div>
<hr />
<div class="slider-layer-item">
    <div class="row">
        <?php echo FormBuilder::render(['start' => 8, 'field' => 'caption[heading]', 'type' => 'textBuilding', 'label' => 'Tiêu đề'], $caption['heading']);?>
        <?php echo FormBuilder::render(['start' => 4, 'field' => 'caption[headingMobile]', 'type' => 'textBuilding', 'txtInput' => false, 'label' => '(mobile)'], $caption['headingMobile']);?>
    </div>
</div>
<hr />
<div class="slider-layer-item">
    <div class="row">
        <?php echo FormBuilder::render(['start' => 8, 'field' => 'caption[description]', 'type' => 'textBuilding', 'label' => 'Mô tả'], $caption['description']);?>
        <?php echo FormBuilder::render(['start' => 4, 'field' => 'caption[descriptionMobile]', 'type' => 'textBuilding', 'txtInput' => false, 'label' => '(mobile)'], $caption['descriptionMobile']);?>
    </div>
</div>

