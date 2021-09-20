var now;
$(document).ready(function () {
    //now = moment();
    now = new Date();
    /**
     * Place the CSRF token as a header on all pages for access in AJAX requests
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /*
     * Select2 for the client select2 on the navbar..
     */
    $("#client-select").select2({
        theme: "bootstrap",
        escapeMarkup: function (markup) {
            return markup;
        },
        ajax: {
            url: '/search-client',
            minimumInputLength: 1,
            data: function (params) {
                var query = {search: params.term}
                return query;
            },
            transport: function (params, success, failure) {
                //var count = $("#client-select").select2('data').length
                let search = params.data.search;
                var count = $("#client-select").select2('data').length
                if ((count > 1 && search == undefined) || (count > 1 && search.trim().length < 1)) {
                    return null;
                }
                //the original function code:
                var $request = $.ajax(params);

                $request.then(success);
                $request.fail(failure);

                return $request;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.CLIENT_CODE + " - " + item.COMPANY_NAME,
                            balance: item.ACCOUNT_BALANCE,
                            id: item.CLIENT_CODE
                        }
                    })
                };
            }
        },
        templateResult: formatClient,
        templateSelection: formatClientSelection
    }).on('change', function () {
        // create form to send to srver side to update the active client for this user
        let selected_index = $(this)[0]['options']['selectedIndex'];
        let client_name = $(this)[0][selected_index]['dataset']['clientName'];
        $('<form>', {
            'method': 'get',
            'action': "/update-client"
        }).append($('<input>', {
            'name': 'client_code',
            'value': this.value,
            'type': 'hidden'
        })).append($('<input>', {
            'name': 'client_name',
            'value': client_name,
            'type': 'hidden'
        })).appendTo('body').submit();
    });
    
     $(".parent-version").click(function () {
        var $icon = $(this).find('i');
        if ($icon.hasClass('fa-minus-square-o')) {
            $icon.removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
        } else {
            $icon.removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
        }
    });

    $(".nav-tabs li a").click(function () {
        $(".nav-tabs li").removeClass("active");
        $(".nav-tabs li a").removeClass("in active");
        $(this).parent('li').addClass("active");
        $(this).addClass("in active");
        $(".tab-pane").removeClass("in active");
        $("" + $(this).attr('href') + "").addClass("in active");
    });
});

/**
 * Preparing serverside feedback if any
 */
function flash_package() {
    $('#flash-overlay-modal').modal();
    $('div.alert').not('.alert-important').not('.oilstar-alert').delay(6000).fadeOut(350); //Not .oilstar-hint
}

/**
 *  
 * Client side modal feedback
 * https://nakupanda.github.io/bootstrap3-dialog/
 */
function modal_session() {
     $('#session-modal').modal({
        backdrop: false
    });
    $('#overlay-container').show(); //overlay-container > feedback
}


/*
 * 
 */
function formatClient(client) {
    if (client.loading) {
        return client.text;
    }
    var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__name'><b>" + client.text + "</b></div>" +
            "<div class='small mt-1'>" +
            "<span>Last updated: " + moment(now).format('DD/MM/YYYY HH:mm') + "</span>" +
            "<span class='float-right'>Balance: R" + client.balance + "</span>" +
            "</div>" +
            "<div class='select2-result-repository__last_updated'></div>" +
            "<div class='select2-result-repository__statistics'>" +
            "</div>" +
            "</div>" +
            "</div>"
            );

    return $container;
}

/*
 * 
 */
function formatClientSelection(client) {
    var company = client.text || client.CLIENT_CODE + ' - ' + client.COMPANY_NAME;
    return '<b>' + company + '</b>' +
            '<div class="small mt-1">' +
            '<span>Last updated: ' + moment(now).format('DD/MM/YYYY HH:mm') + '</span>' +
            '<span class="float-right">Balance: R' + ('balance' in  client ? client.balance : client.element.dataset.balance) + '</span>' +
            '</div>';
}

(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

