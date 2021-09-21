<script>
    //var title = document.title;
    var page_timer, modal_timer = null;
    $(document).ready(function () {
        /**
         * Session/Page Timer
         * 1 second * 60 = 60 seconds (i.e. 1 minute)
         * 1 * lifetime = counter
         * Modal Timer: Reset if aJax is completed
         */
        resetPageTimer();
        resetModalTimer();
        $(document).ajaxComplete(function (event, xhr, settings) {
            resetPageTimer();
            resetModalTimer();
        });
        /*
         * Modal Timer based on client activity
         */
        $(document).on('mousemove', function () {
            if ($("#session-modal").is(':visible') == false) {
                resetModalTimer();
            }
        });
    });

    /**
     * 
     * @returns {undefined}
     */
    function checkSession() {
        $.ajax({
            url: '/session/check',
            type: "GET",
            data: {'session-activity': true}
        }).done(function (data, textStatus, xhr) {
            /**
             * If something is returned..the session is good and the modal must be displayed to say they will be logged out soon!
             * Else, the session has already timed out, and the user must be displayed with a message that their session has expired!
             * 
             * Also check if they have near a minute left! else might as well just time them out automatically (TODO-Leo)
             */
            if (xhr.status == 200 && data['minutes'] > 0) { // && time is greater than 60 seconds!                
                resetPageTimer();
                resetModalTimer();
            } else {
                idleWarning();
            }
        });
    }

    /**
     * Counts down from 60 seconds,
     * once at 0 seconds, the user is logged out
     * 
     * @returns {undefined}
     */
    function idleChecker(start) {
        if (start) {
            var countdown = 60;            
            $('#clock-display').css("display", "block");
            $('#clock-controls').css("display", "block");
            modal_session();
        } else {
            var countdown = $('#clock-value').html() - 1;
        }
        if ($("#session-modal").is(':visible')) { //If the modal is still open!
            if (countdown > 0) {
                $('#clock-value').empty().html(((countdown < 10) ? "0" + countdown : countdown));
                setTimeout(idleChecker.bind(this, false), 1000);
            } else {
                $('#clock-value').empty().html("00");
                $('#clock-controls').css("display", "none");
                idleWarning();                
                //Submit form 
                setTimeout(sesssionLogout, 5000);
            }
        } else {
            //Reset the clock, by hiding the clock-display 
            $('#clock-display').css("display", "none");
            $('#clock-controls').css("display", "none");
        }
    }

    /**
     * 
     * @returns {undefined}
     */
    function idleWarning() {
        $('#error-display').css("display", "block");
        $('#error-controls').css("display", "block");
    }

    /**
     * 
     * @returns {undefined}
     */
    function refreshSession() {
        $('#overlay-container').hide(); //overlay-container > feedback
        $.ajax({
            url: '/session/refresh',
            type: "GET"
        }).done(function (return_data, textStatus, xhr) {
            /**
             * Retrieve the CSFR code, and refresh the code client side!
             * var csrf_token = $('meta[name="csrf-token"]').attr('content', return_data['token']);
             */
            if (xhr.status == 200) {
                resetPageTimer();
                resetModalTimer();
            } else {
                flash_message('Failed to refresh the session. You will be logged out in 5 seconds.', 'alert-danger');
                setTimeout(sesssionLogout, 5000);
            }
        });
    }

    function sesssionLogout() {
        //$('#logout-form').submit();
        $('#expire-form').submit();
    }

    function resetPageTimer() {
        if (page_timer) {
            clearTimeout(page_timer);
        }
        page_timer = setTimeout(checkSession, "{{Config::get('session.lifetime')}}" * 60 * 1000);
    }

    function resetModalTimer() {
        if (modal_timer) {
            clearTimeout(modal_timer);
        }
        @can('internal', Auth::user())        
            var time = 6;
        @else
            var time = 8;
        @endcan
        modal_timer = setTimeout(idleChecker.bind(this, true), ("{{Config::get('session.lifetime')}}" / time) * 60 * 1000);
    }

</script>