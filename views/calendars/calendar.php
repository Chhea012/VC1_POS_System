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
                <li><a class="dropdown-item" href="#" data-filter="all">View All</a></li>
                <li><a class="dropdown-item" href="#" data-filter="personal">Personal</a></li>
                <li><a class="dropdown-item" href="#" data-filter="business">Business</a></li>
                <li><a class="dropdown-item" href="#" data-filter="stock">Stock</a></li>
            </ul>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">+ Add Event</button>
    </div>
    <div id='calendar'></div>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    <div class="mb-3">
                        <label class="form-label">Event Title</label>
                        <input type="text" class="form-control" id="eventTitle" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Event Date</label>
                        <input type="date" class="form-control" id="eventDate" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-control" id="eventCategory">
                            <option value="personal">Personal</option>
                            <option value="business">Business</option>
                            <option value="stock">Stock</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" id="eventDescription" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Event</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Event Detail Modal -->
<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Title:</strong> <span id="detailTitle"></span></p>
                <p><strong>Date:</strong> <span id="detailDate"></span></p>
                <p><strong>Category:</strong> <span id="detailCategory"></span></p>
                <p><strong>Description:</strong> <span id="detailDescription"></span></p>
                <button class="btn btn-danger" id="deleteEventBtn">Delete Event</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    
    let storedEvents = JSON.parse(localStorage.getItem('events')) || [
        { title: 'New Product', start: '2025-02-17', color: '#00000', category: 'business', description: 'Launch new product' },
        { title: 'Meeting with Client', start: '2025-02-17', color: '#9370DB', category: 'personal', description: 'Discuss project' },
        { title: 'New Stock', start: '2025-02-19', color: '#90EE90', category: 'stock', description: 'Restock inventory' },
    ];

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: storedEvents,
        eventClick: function(info) {
            document.getElementById("detailTitle").innerText = info.event.title;
            document.getElementById("detailDate").innerText = info.event.startStr;
            document.getElementById("detailCategory").innerText = info.event.extendedProps.category;
            document.getElementById("detailDescription").innerText = info.event.extendedProps.description;
            document.getElementById("deleteEventBtn").setAttribute("data-event-id", info.event.id);
            
            var modal = new bootstrap.Modal(document.getElementById("eventDetailModal"));
            modal.show();
        }
    });
    calendar.render();

    document.getElementById("deleteEventBtn").addEventListener("click", function() {
        let eventId = this.getAttribute("data-event-id");
        let updatedEvents = storedEvents.filter(event => event.id !== eventId);
        localStorage.setItem('events', JSON.stringify(updatedEvents));
        location.reload();
    });
});
</script>