function Buttons(){
    inputs = document.getElementsByTagName('input');
    for(i = 0; i < inputs.length; i++){
        if(inputs[i].type != 'image')
            inputs[i].className='input';
        if(inputs[i].type == 'submit')
            inputs[i].className='button';
    }
}
function Init(){
    Buttons();
}

function imageScale(sender, max_size) {
    p=0;
    if (sender.width > max_size) {
        p = (max_size / sender.width);
    }
    else {
        if (sender.height > max_size) {
            p = (max_size / sender.height);
        }
    }
    if(p > 0) {
        sender.width = p * sender.width;
    }
}
