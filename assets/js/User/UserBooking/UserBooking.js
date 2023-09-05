var calendarEl = document.getElementById('calendar');

var calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
        left: 'prevYear,prev,next,nextYear today',
        center: 'title',
        right: 'dayGridMonth,dayGridWeek,dayGridDay'
    },
    initialDate: '2023-01-12',
    navLinks: true, // can click day/week names to navigate views
    editable: false,
    locale: 'th',
    dayMaxEvents: true, // allow "more" link when too many events
    events: [{
            title: 'All Day Event',
            start: '2023-01-01'
        },
        {
            title: 'Long Event',
            start: '2023-01-07',
            end: '2023-01-07'
        }
    ]
});

calendar.render();