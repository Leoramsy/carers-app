<script type="text/javascript">
    $(document).ready(function () {
        //var editor_create = null;
        $("#details-save-btn").click(function (e) {
            clients_editor.submit();
        });
        $('body').popover({
            html: true,
            selector: '[data-toggle="popover"]'
        });
    });
    function tabError(selector, clear) {
        $("ul.nav-tabs > li").has("a[href='" + selector + "']").removeClass('error');
        $("ul.nav-tabs > li > a[href='" + selector + "']").removeClass('alert alert-danger');
        if ($(selector + ' .has-error').length > 0 && clear === false) {
            $("ul.nav-tabs > li").has("a[href='" + selector + "']").addClass('error');
            $("ul.nav-tabs > li > a[href='" + selector + "']").addClass('alert alert-danger');
        }
    }
</script>



