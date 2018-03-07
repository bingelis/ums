$(document).ready(function () {
    $("a[data-method]").click(function (event) {
        event.preventDefault();

        const target = $(event.currentTarget);
        const action = target.attr('href');
        const _method = target.attr('data-method');
        const _token = target.attr('data-token');

        $.ajax({
            type: 'POST',
            url: action,
            data: {
                _method: _method,
                _token: _token
            },
            success: function (response) {
                target.closest('tr').remove();
            },
            error: function (response, desc){
                if (response.responseJSON && response.responseJSON.message) {
                    $('#myModal .modal-body').text(response.responseJSON.message);
                    $('#myModal').modal();
                } else {
                    alert(desc);
                }
            }
        });
    });
});
