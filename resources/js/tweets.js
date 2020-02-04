$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('body').delegate("[data-role='btn-tweet-action']", 'click', function(event){
    event.preventDefault();

    let id = uuidv4();
    let btn = $(this);

    let container = $(this).attr('data-container');
    let message = $(this).attr('data-message');
    let related = $($(this).attr('data-toggle-btn'));
    let okCriteria = $(this).attr('data-field-ok');
    let method = $(this).attr('data-method');

    $.ajax({
        type: method,
        dataType: 'json',
        url: $(this).attr('data-resource'),
        data: {
            tweet_id: $(this).attr('data-id')
        },
        beforeSend: function ()
        {
            let html = '<div class="processing-action" id="' + id + '">\
                <div class="spinner-border text-primary" role="status">\
                    <span class="sr-only">Loading...</span>\
                </div>\
            </div>';

            $(container).prepend(html);
        },
        success: function(response)
        {
            if (response[okCriteria]) {
                notify('success', message);
                btn.attr('disabled', 'disabled');
                related.removeAttr('disabled');
            } else {
                notify('error', 'Error processing request');
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            notify('error', 'System failure');
        },
        complete: function()
        {
            $("#" + id).fadeOut(1000);

            setTimeout(function(){
                $("#" + id).remove();
            }, 1000);
        }
    });
});

function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

function notify(type, message)
{
    new PNotify({
        target: document.body,
        data: {
            text: message,
            type: type
        }
    });
}
