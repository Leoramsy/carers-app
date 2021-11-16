<script type="text/javascript">
    $(document).ready(function () {
        let calender_element = document.getElementById('calender-div');
        let calendar = new FullCalendar.Calendar(calender_element, {
            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
            timeZone: 'Africa/Johannesburg',
            themeSystem: 'bootstrap',
            initialView: 'resourceTimelineDay',
            aspectRatio: 1.5,
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth'
            },
            editable: true,
            resourceAreaHeaderContent: 'Carer Name',
            resources: {!! $carers !!},
            events: {
                url: '/schedules/visits',
                method: 'GET',
                failure: function () {
                    flash_message('There was an error while fetching events!', 'error');
                }
                //'https://fullcalendar.io/demo-events.json?single-day&for-resource-timeline'
            }
        });
        calendar.render();
    });

</script>



