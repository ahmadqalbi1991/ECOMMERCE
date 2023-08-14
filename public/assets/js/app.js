$('.dropify').dropify();

tinymce.init({
    selector: '.textarea',
    height: 200,
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
});

function handleScreen () {
    let screen_width = window.screen.width;
    if (screen_width < 1200) {
        $('#sidebar').removeClass('active');
    }

    if (screen_width > 1199) {
        $('#sidebar').addClass('active')
    }
}

handleScreen();

$(window).resize(function() {
    handleScreen();
});

$('.sidebar-hide').on('click', function () {
   $('#sidebar').removeClass('active');
});

$('.show-sidebar').on('click', function () {
   $('#sidebar').addClass('active');
});

$('.select2').select2();
