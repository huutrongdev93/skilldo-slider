<?php
$caption['heading'] = array_merge([
    'txt'           => 'Jungle Safari Resort',
    'color'         => '#fff',
    'fontWeight'    => 'bold',
    'fontSize'      => 30,
    'fontFamily'    => 0,
    'lineHeight'    => 40,
], $caption['heading']);
$caption['description'] = array_merge([
    'txt'           => 'Food indulgence in mind, come next door and sate your desires with our ever changing internationally and seasonally.',
    'color'         => '#fff',
    'fontWeight'    => '400',
    'fontSize'      => 20,
    'fontFamily'    => 0,
    'lineHeight'    => 30,
], $caption['description']);
$caption['headingMobile'] = array_merge([
    'color'         => '#fff',
    'fontWeight'    => 'bold',
    'fontSize'      => 20,
    'fontFamily'    => 0,
    'lineHeight'    => 20,
], $caption['headingMobile']);
$caption['descriptionMobile'] = array_merge([
    'color'         => '#fff',
    'fontWeight'    => '400',
    'fontSize'      => 14,
    'fontFamily'    => 0,
    'lineHeight'    => 20,
], $caption['descriptionMobile']);
?>
<div class="sliderItemCaption positionX--<?php echo $caption['position']['x'];?> positionY--<?php echo $caption['position']['y'];?>" style="--slider-caption1-heading-color: <?php echo $caption['heading']['color'];?>;
        --slider-caption1-heading-font: <?php echo $caption['heading']['fontFamily'];?>;
        --slider-caption1-heading-size: <?php echo $caption['heading']['fontSize'];?>px;
        --slider-caption1-heading-weight: <?php echo $caption['heading']['fontWeight'];?>;
        --slider-caption1-heading-height: <?php echo $caption['heading']['lineHeight'];?>px;
        --slider-caption1-headingM-color: <?php echo $caption['headingMobile']['color'];?>;
        --slider-caption1-headingM-font: <?php echo $caption['headingMobile']['fontFamily'];?>;
        --slider-caption1-headingM-size: <?php echo $caption['headingMobile']['fontSize'];?>px;
        --slider-caption1-headingM-weight: <?php echo $caption['headingMobile']['fontWeight'];?>;
        --slider-caption1-headingM-height: <?php echo $caption['headingMobile']['lineHeight'];?>px;
        --slider-caption1-des-color: <?php echo $caption['description']['color'];?>;
        --slider-caption1-des-font: <?php echo $caption['description']['fontFamily'];?>;
        --slider-caption1-des-size: <?php echo $caption['description']['fontSize'];?>px;
        --slider-caption1-des-weight: <?php echo $caption['description']['fontWeight'];?>;
        --slider-caption1-des-height: <?php echo $caption['description']['lineHeight'];?>px;
        --slider-caption1-desM-color: <?php echo $caption['descriptionMobile']['color'];?>;
        --slider-caption1-desM-font: <?php echo $caption['descriptionMobile']['fontFamily'];?>;
        --slider-caption1-desM-size: <?php echo $caption['descriptionMobile']['fontSize'];?>px;
        --slider-caption1-desM-weight: <?php echo $caption['descriptionMobile']['fontWeight'];?>;
        --slider-caption1-desM-height: <?php echo $caption['descriptionMobile']['lineHeight'];?>px;">
    <div class="sliderItemCaption-wrapper">
        <?php if(!empty($caption['heading']['txt'])) { ?><div class="sliderItemCaption-title"><?php echo $caption['heading']['txt'];?></div><?php } ;?>
        <?php if(!empty($caption['description']['txt'])) { ?><div class="sliderItemCaption-detail"><?php echo $caption['description']['txt'];?></div><?php } ;?>
    </div>
</div>