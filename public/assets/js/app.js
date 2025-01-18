$('.dropify').dropify();

tinymce.init({
    selector: '.textarea',
    height: 400,
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

$(document).on('click', '.delete-item', function () {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: $(this).data('url'),
                type: 'GET',
                success: function (response) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your item has been deleted.",
                        icon: "success"
                    });

                    Swal.fire({
                        title: "Done",
                        text: "Item has been deleted",
                        icon: "warning",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Ok"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: "Error!",
                        text: "Something went wrong.",
                        icon: "error"
                    });
                }
            });
        }
    });
});

$('.show-sidebar').on('click', function () {
   $('#sidebar').addClass('active');
});

$('.select2').select2();
