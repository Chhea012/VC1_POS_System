<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>
<div class="container-xxl flex-grow-1 container-p-y ">
    <h2 class="mb-3">Calendar</h2>
    <div class="mb-3 d-flex justify-content-between">
    <div class="dropdown">
    <button class="btn btn-light dropdown-toggle" type="button" id="eventFilter" data-bs-toggle="dropdown" aria-expanded="false">
        View All
    </button>
    <ul class="dropdown-menu" aria-labelledby="eventFilter">
        <li><a class="dropdown-item" href="#" data-filter="all"><i class="bi bi-funnel"></i> View All</a></li>
        <li><a class="dropdown-item" href="#" data-filter="personal"><i class="bi bi-person-circle"></i> Personal</a></li>
        <li><a class="dropdown-item" href="#" data-filter="business"><i class="bi bi-briefcase"></i> Business</a></li>
        <li><a class="dropdown-item" href="#" data-filter="stock"><i class="bi bi-box-seam"></i> Stock</a></li>
    </ul>
        </div>
        <button class="btn btn-primary">+ Add Event</button>
    </div>
    <div id='calendar'></div>
</div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            events: [
                { title: 'New Product', start: '2025-02-17', color: '#87CEEB', category: 'business' },
                { title: 'Meeting with Client', start: '2025-02-17', color: '#9370DB', category: 'personal' },
                { title: 'New Stock', start: '2025-02-19', color: '#90EE90', category: 'stock' },
            ]
        });
        calendar.render();

        // Handle dropdown selection
        document.querySelectorAll('.dropdown-menu .dropdown-item').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                let selectedCategory = this.getAttribute('data-filter');
                document.getElementById('eventFilter').innerText = this.innerText;

                // Filter events
                let allEvents = [
                    { title: 'New Product', start: '2025-02-17', color: '#87CEEB', category: 'business' },
                    { title: 'Meeting with Client', start: '2025-02-17', color: '#9370DB', category: 'personal' },
                    { title: 'New Stock', start: '2025-02-19', color: '#90EE90', category: 'stock' },
                ];
                
                let filteredEvents = selectedCategory === 'all' 
                    ? allEvents 
                    : allEvents.filter(event => event.category === selectedCategory);
                
                calendar.removeAllEvents();
                calendar.addEventSource(filteredEvents);
            });
        });
    });
</script>
    

 
   