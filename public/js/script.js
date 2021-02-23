$('#is_copyright').css('display', $('#limitrights').prop('checked') ? 'block' : 'none');

$('#limitrights').on('change', () => {
    let isChecked = $('#limitrights').prop('checked');
    $('#is_copyright').css('display', isChecked ? 'block' : 'none');
});

function onImageClicked(event) {
    $('#picture_full').attr('src', event.target.src);
    $('.fullscreen_picture').css('display', 'flex');
}

$(".fullscreen_picture").on('click', () => {
    $('.fullscreen_picture').css('display', 'none');
});