function updateEditorSelect2List(url, data = {}) {
    var ajax = $.ajax({
        url: url,
        type: "GET",
        data: data
    }).done(function (return_data) {
        let $table = $('#' + return_data['selector']).DataTable();
        let $editor = $table.editor();
        if ('error' in return_data) {
            $editor.error(return_data['error']);
        } else if ('fieldErrors' in return_data) {
            for (var i = 0; i < return_data['fieldErrors'].length; i++) {
                $editor.field(return_data['fieldErrors'][i]['name']).error(return_data['fieldErrors'][i]['status']);
            }
        } else {
            for (var i = 0; i < return_data['select_lists'].length; i++) {
                let selected = ('selected' in return_data['select_lists'][i] ? return_data['select_lists'][i]['selected'] : 0);
                $editor.field(return_data['select_lists'][i]['field']).message('');
                switch (return_data['select_lists'][i]['type']) {
                    case 'normal':
                        editorNormalSelect2List($editor, return_data['select_lists'][i], selected);
                        break;
                    case 'group':
                        editorGroupSelect2List($editor, return_data['select_lists'][i]);
                        break;
                    default:
                        editorNormalSelect2List($editor, return_data['select_lists'][i]);
                        break;
                }
            }
        }
    });
    return ajax;
}

function editorNormalSelect2List($editor, select_list, selected) {
    //let original_val = $editor.field(select_list['field']).val();
    $editor.field(select_list['field']).update(select_list['options']); //.change();
    $editor.field(select_list['field']).val(selected);
    /*
     if (original_val != null && selected != original_val && original_val != $editor.field(select_list['field']).def()) {
     console.log("Scenario 1: " + select_list['field']);
     //console.log("Original: " + original_val);
     //console.log("Selected: " + selected);
     $editor.field(select_list['field']).val(original_val);
     } else {
     console.log("Scenario 2: " + select_list['field']);
     $editor.field(select_list['field']).val(selected);
     }
     */
    /*
     else if (selected == original_val && selected != $editor.field(select_list['field']).def()) {
     //console.log("Scenario 2: " + select_list['field']);
     //console.log("Original: " + original_val);
     //console.log("Selected: " + selected);
     $editor.field(select_list['field']).val(selected);
     } else if (selected != original_val && original_val == $editor.field(select_list['field']).def()) {
     //console.log("Scenario 3: " + select_list['field']);
     //console.log("Original: " + original_val);
     //console.log("Selected: " + selected);
     $editor.field(select_list['field']).val(selected);
     } else if (original_val == null && selected != $editor.field(select_list['field']).def()) {
     //console.log("Scenario 4: " + select_list['field']);
     //console.log("Original: " + original_val);
     //console.log("Selected: " + selected);
     $editor.field(select_list['field']).val(selected);
     }
     else if (original_val == null && selected == $editor.field(select_list['field']).def()) {
     //console.log("Scenario 4: " + select_list['field']);
     //console.log("Original: " + original_val);
     //console.log("Selected: " + selected);
     $editor.field(select_list['field']).val(selected);
     }
     */
    //console.log("Scenario 5: " + select_list['field']);
    //console.log("Original: " + original_val);
    //console.log("Selected: " + selected);
}

function editorGroupSelect2List($editor, select_list) {
    $editor.field(select_list['field']).update([]);
    $editor.field(select_list['field']).inst().select2({
        data: select_list['options']
    }).change();
}