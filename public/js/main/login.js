$(document).ready(function () {
    $('#indicator_2').hide();
    $('#indicator_3').hide();
    SliderEffect(0);
});

function SliderEffect(intcount) {

    if (intcount == 0)
    {
        $('#indicator_1').slideUp("slow");
        $('#indicator_2').slideDown("slow");
        intcount += 1;
    } else if (intcount == 1) {
        $('#indicator_2').slideUp("slow");
        $('#indicator_3').slideDown("slow");
        intcount += 1;
    } else {
        $('#indicator_3').slideUp("slow");
        $('#indicator_1').slideDown("slow");
        intcount = 0;
    }

    setTimeout(function () {
        SliderEffect(intcount);
    }, 4000);

}
