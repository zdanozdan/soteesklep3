<script>
<?php global $lang; ?>
function SetBarWidth(bar, length){
    bar.width = length;
}

function Stretch(sender){
    if(sender.mode == null)
        sender.mode = 'rozstrzel';

    bars = document.getElementsByName('bar_' + sender.name);
    if(sender.mode == 'rozstrzel'){
        for(i = 0; i < bars.length; i++){
            SetBarWidth(bars[i], bars[i].parentNode.childNodes[2].value);
        }
        sender.mode = 'proporcje';
        sender.innerHTML = '<?php echo $lang->real_propor; ?>';
    }
    else{
        for(i = 0; i < bars.length; i++){
            SetBarWidth(bars[i], bars[i].parentNode.childNodes[1].value);
        }
        sender.mode = 'rozstrzel';
        sender.innerHTML = '<?php echo $lang->underline_diff; ?>';
    }
}
</script>