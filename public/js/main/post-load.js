/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Add a CSRF token to any form being submitted 
 * 
 * @type type
 */
$(document).on('submit', 'form', function (e) {
    $(this).append($('<input>', {
        'name': '_token',
        'value': $('meta[name="csrf-token"]').attr('content'),
        'type': 'hidden'
    }));
});
