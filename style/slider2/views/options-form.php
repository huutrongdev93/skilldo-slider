<?php
$Form = new FormBuilder();
$Form->add('sliderTxtType', 'select', ['label' => 'Kiểu tiêu đề slider', 'options' => ['out-slider' => 'Dưới slider', 'in-slider' => 'Trong slider']], (empty($options['sliderTxtType'])) ? 'in-slider' : $options['sliderTxtType']);
$Form->add('sliderTxtBg', 'color', ['label' => 'Màu nền thumb'], (empty($options['sliderTxtBg'])) ? '' : $options['sliderTxtBg']);
$Form->add('sliderTxtColor', 'color', ['label' => 'Màu chữ thumb'], (empty($options['sliderTxtColor'])) ? '' : $options['sliderTxtColor']);
$Form->add('sliderTxtActive', 'color', ['label' => 'Màu chữ thumb (active)'], (empty($options['sliderTxtActive'])) ? '' : $options['sliderTxtActive']);
$Form->html(false);