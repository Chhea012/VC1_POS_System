<div class="container-xxl flex-grow-1 container-p-y">
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


<script>

    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    
    // Load events from localStorage
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
        events: storedEvents
    });
    calendar.render();

    // Handle event filtering
    document.querySelectorAll('.dropdown-menu .dropdown-item').forEach(item => {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            let selectedCategory = this.getAttribute('data-filter');
            document.getElementById('eventFilter').innerText = this.innerText;

            let filteredEvents = selectedCategory === 'all' 
                ? storedEvents 
                : storedEvents.filter(event => event.category === selectedCategory);
            
            calendar.removeAllEvents();
            calendar.addEventSource(filteredEvents);
        });
    });

    // Handle form submission to add new event
    document.getElementById("eventForm").addEventListener("submit", function(event) {
        event.preventDefault();

        // Get form values
        let title = document.getElementById("eventTitle").value;
        let date = document.getElementById("eventDate").value;
        let category = document.getElementById("eventCategory").value;
        let description = document.getElementById("eventDescription").value;
        let color = category === "personal" ? "#9370DB" : category === "business" ? "#87CEEB" : "#90EE90";

        let newEvent = { title, start: date, color, category, description };

        // Add event to calendar
        calendar.addEvent(newEvent);

        // Save to localStorage
        storedEvents.push(newEvent);
        localStorage.setItem('events', JSON.stringify(storedEvents));

        // Reset form & close modal
        document.getElementById("eventForm").reset();
        var modal = bootstrap.Modal.getInstance(document.getElementById("addEventModal"));
        modal.hide();
    });
});
</script>
    

 
   