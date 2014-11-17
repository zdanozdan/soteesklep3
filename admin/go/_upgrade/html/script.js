function ToggleTextarea(sender) {
    oTextareaDiv = document.getElementById('d_textarea');
    oSubmitDiv = document.getElementById('d_submit');
    if(sender.checked) {
        oTextareaDiv.style.display = 'inline';
    }
    else {
        oTextareaDiv.style.display = 'none';
        oSubmitDiv.style.display = 'none';
    }
}

function ToggleSubmit(sender) {
    oSubmitDiv = document.getElementById('d_submit');
    if(sender.checked) {
        oSubmitDiv.style.display = 'inline';
    }
    else {
        oSubmitDiv.style.display = 'none';
    }
}