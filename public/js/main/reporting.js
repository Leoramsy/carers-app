$(document).ready(function () {
    
    //var show = ['live', 'excel', 'weekly', 'monthly'];
    //var hide = [];
    
    $("#debtor-select").select2({
        theme: "bootstrap"
    });
    $('#debtor-select').prop('disabled', true);

    /**
     * 
     * https://stackoverflow.com/questions/22708895/how-to-split-string-and-push-in-array-using-jquery/22708927
     * this = DOM element
     * event = jQuery event
     * state = true | false
     */
    $('input[name="filter-report"]').on('switchChange.bootstrapSwitch', function (event, state) {
        console.log(state); // 
        var val = $(this).val();
        if (state) {
            //$('.XYZ.ABC:NOT(.PLK.JHG).show();'
        } else {

        }
    });

    $(".btn-report").click(function () {
        var $report = $('input[type="radio"][name="report"]:checked');
        var type = $(this).data('report-type');
        var route = type + '/' + $report.val();
        $('#form-report').attr('action', route);
        $('#form-report').submit();
    });

    $('input[type="radio"][name="report"]').change(function () {
        if ($(this).is(':checked')) {
            var types = $(this).data('report-types');
            var arr_types = types.split(' ');
            $('.btn-report').addClass('disabled');
            for (i = 0; i < arr_types.length; i++) {
                $("#btn-" + arr_types[i] + "-report").removeClass('disabled');
            }
        }
    });

});
