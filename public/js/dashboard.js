document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('upcomingCalendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          themeSystem: 'bootstrap',
          headerToolbar: {
            left: 'dayGridMonth,timeGridWeek,timeGridDay',
            center: 'title',
            right: 'prevYear,prev,next,nextYear'
            },
          footerToolbar: {
            center: '',
            right: 'prev,next'
          }

        });
        calendar.render();
});
