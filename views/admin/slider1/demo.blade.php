<article class="spectaculus">
    <!-- START REVOLUTION SLIDER 3.1 rev5 fullwidth mode -->
    <div class="fullwidthbanner-container roundedcorners">
        <div class="fullwidthbanner" >
            <ul>
                <li data-transition="fade" data-slotamount="5" data-masterspeed="700" >
                    <img src="{!! $path !!}images-demo/bg1.jpg"   alt="slidebg1"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">
                </li>
                <li data-transition="fade" data-slotamount="5" data-masterspeed="700" >
                    <img src="{!! $path !!}images-demo/bg2.jpg"   alt="slidebg1"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">
                </li>
                <li data-transition="fade" data-slotamount="5" data-masterspeed="700" >
                    <img src="{!! $path !!}images-demo/bg3.jpg"  alt="slidebg1"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">
                </li>
                <li data-transition="fade" data-slotamount="5" data-masterspeed="700" >
                    <img src="{!! $path !!}images-demo/bg4.jpg"  alt="slidebg1"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">
                </li>
            </ul>
            <div class="tp-bannertimer"></div>
        </div>
    </div>
    <script type="text/javascript">
		var revApi;
		$(document).ready(function() {
			revApi = $('.fullwidthbanner').revolution({
				delay:15000,
				startwidth:1170,
				startheight:500,
				height:500,
				hideThumbs:10,

				thumbWidth:100,
				thumbHeight:50,
				thumbAmount:5,

				navigationType:"both",
				navigationArrows:"solo",
				navigationStyle:"round",

				touchenabled:"on",
				onHoverStop:"on",

				navigationHAlign:"center",
				navigationVAlign:"bottom",
				navigationHOffset:0,
				navigationVOffset:0,

				soloArrowLeftHalign:"left",
				soloArrowLeftValign:"center",
				soloArrowLeftHOffset:20,
				soloArrowLeftVOffset:0,

				soloArrowRightHalign:"right",
				soloArrowRightValign:"center",
				soloArrowRightHOffset:20,
				soloArrowRightVOffset:0,

				shadow:0,
				fullWidth:"on",
				fullScreen:"off",

				stopLoop:"on",
				stopAfterLoops:0,
				stopAtSlide:1,


				shuffle:"off",

				autoHeight:"off",
				forceFullWidth:"off",

				hideThumbsOnMobile:"off",
				hideBulletsOnMobile:"on",
				hideArrowsOnMobile:"on",
				hideThumbsUnderResolution:0,

				hideSliderAtLimit:0,
				hideCaptionAtLimit:768,
				hideAllCaptionAtLilmit:0,
				startWithSlide:0,
				videoJsPath:"plugins/revslider/rs-plugin/videojs/",
				fullScreenOffsetContainer: ""
			});
		});	//ready
    </script>
    <!-- END REVOLUTION SLIDER -->
    <!-- Content End -->
</article> <!-- END OF SPECTACULUS -->
<article class="toolpad">
    <section class="tool">
        <div data-val="<?= $masterspeed;?>" id="mrtime" class="tooltext">Time: <?= $masterspeed/1000;?>s</div>
        <div class="toolcontrols">
            <div id="dectime" class="toolcontroll withspace"><i class="icon-minus"></i></div>
            <div id="inctime" class="toolcontroll withspace2"><i class="icon-plus"></i></div>
        </div>
        <div class="clear"></div>
    </section>

    <section class="tool last">
        <div data-val="<?= $slotamount;?>" class="tooltext" id="mrslot">Slots: <?= $slotamount;?></div>
        <div class="toolcontrols">
            <div id="decslot" class="toolcontroll withspace"><i class="icon-minus"></i></div>
            <div id="incslot" class="toolcontroll withspace2"><i class="icon-plus"></i></div>
        </div>
        <div class="clear"></div>
    </section>
    <div class="clear"></div>
</article>