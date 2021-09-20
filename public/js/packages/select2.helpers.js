function updateSelect2List(url, data = {}) {
    $.ajax({
        url: url,
        type: "GET",
        data: data
    }).done(function (return_data) {
        if ('error' in return_data) {
            console.log(return_data['error']);
        } else {
            for (var i = 0; i < return_data['select_lists'].length; i++) {
                refreshSelectTwo($("#" + return_data['select_lists'][i]['selector']), return_data['select_lists'][i]['options']);
            }
        }
    });
}

function refreshSelectTwo($input, data) {
    var first = null;
    for (var key in data) {
        var $option = $('<option />').prop('value', data[key]['id']).text(data[key]['text']); //TODO: .data('attribute', data[key]['data-attribute']);
        $input.append($option);
        if (first === null) {
            first = data[key]['id'];
        }
    }
    $input.val(first).trigger('change');
}