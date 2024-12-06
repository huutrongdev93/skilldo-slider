{!! $form !!}

<article class="tool-pad">
    <section class="tool">
        <input type="hidden" id="transition_speed" name="transition[speed]" value="{!! $config['speed'] !!}">
        <div id="mrTime" class="tool-text">Time: {!! $config['speed']/1000 !!}s</div>
        <div class="tool-controls">
            <div id="decTime" class="tool-control with-space"><i class="fa-light fa-minus"></i></div>
            <div id="incTime" class="tool-control with-space2"><i class="fa-light fa-plus"></i></div>
        </div>
        <div class="clear"></div>
    </section>
    <section class="tool last">
        <input type="hidden" id="transition_slot" name="transition[slot]" value="{!! $config['slot'] !!}">
        <div id="mrSlot" class="tool-text">Slots: {!! $config['slot'] !!}</div>
        <div class="tool-controls">
            <div id="decSlot" class="tool-control with-space"><i class="fa-light fa-minus"></i></div>
            <div id="incSlot" class="tool-control with-space2"><i class="fa-light fa-plus"></i></div>
        </div>
        <div class="clear"></div>
    </section>
</article>

<style>
    .tool-pad {
        padding: 10px;
        border: none;
        overflow: hidden;
        position: relative;
    }
    .tool {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap:10px;
        margin-bottom: 5px;
    }
    .tool-text {
        font-size: 12px;
        font-weight: 700;
        color: #777;
        border-radius: 5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        background-color: #f5f5f5;
        border: 1px solid #eee;
        padding: 10px 5px;
        float: left;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        display: table-cell;
        width: 100%;
    }
    .tool-controls {
        vertical-align: top;
        display: flex;
        gap:5px;
    }
    .tool-control {
        width: 34px;
        height: 40px;
        background: #eee;
        color: #cccccc;
        line-height: 40px;
        text-align: center;
        border-radius: 5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        cursor: pointer;

    }
    .tool:hover .tool-text {
        color: #fff;
        background-color: #e33a0c;
        border-color: #e33a0c;
    }
    .tool:hover .tool-control {
        color: #fff;
        background: #aa2b09;
    }
</style>