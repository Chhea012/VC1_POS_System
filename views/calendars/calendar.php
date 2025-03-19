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
                <button class="btn btn-warning " id="editEventBtn">Edit Event</button>
                <button class="btn btn-danger" id="deleteEventBtn">Delete Event</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");

    let storedEvents = JSON.parse(localStorage.getItem("events")) || [];
    storedEvents = storedEvents.map((event, index) => ({
        id: event.id || index.toString(),
        ...event,
    }));
    localStorage.setItem("events", JSON.stringify(storedEvents));

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
    },
    events: storedEvents.map(event => ({
        ...event,
        backgroundColor: event.category === "stock" ? "orange" :
                         event.category === "personal" ? "lightgreen" :
                         event.category === "business" ? "lightblue" : "blue",
        borderColor: event.category === "stock" ? "white" :
                     event.category === "personal" ? "white" :
                     event.category === "business" ? "white" : "white",
    })),

        eventClick: function (info) {
            document.getElementById("detailTitle").innerText = info.event.title;
            document.getElementById("detailDate").innerText = info.event.startStr;
            document.getElementById("detailCategory").innerText = info.event.extendedProps.category;
            document.getElementById("detailDescription").innerText = info.event.extendedProps.description;

            document.getElementById("editEventBtn").setAttribute("data-event-id", info.event.id);
            document.getElementById("deleteEventBtn").setAttribute("data-event-id", info.event.id);

            var modal = new bootstrap.Modal(document.getElementById("eventDetailModal"));
            modal.show();
        },
    });

    calendar.render();

    // ✅ Handle category filter selection (Fix: Hide/Show Events Properly)
    document.querySelectorAll(".dropdown-item").forEach((item) => {
    item.addEventListener("click", function (e) {
        e.preventDefault();
        let filterCategory = this.getAttribute("data-filter");

        document.getElementById("eventFilter").innerText = this.innerText;
        document.getElementById("eventFilter").setAttribute("data-selected", filterCategory);

        // 🔹 Remove all events before adding the filtered ones
        calendar.removeAllEvents();

        let filteredEvents = storedEvents;

        if (filterCategory !== "all") {
            filteredEvents = storedEvents.filter(event => event.category === filterCategory);
        }

        // 🔹 Ensure colors are applied again
        filteredEvents = filteredEvents.map(event => ({
            ...event,
            backgroundColor: event.category === "stock" ? "orange" :
                             event.category === "personal" ? "lightgreen" :
                             event.category === "business" ? "lightblue" : "blue",
            borderColor: event.category === "stock" ? "white" :
                         event.category === "personal" ? "white" :
                         event.category === "business" ? "white" : "white",
        }));

        calendar.addEventSource(filteredEvents);
    });
});


    // ✅ ADD EVENT FUNCTION
    document.getElementById("eventForm").addEventListener("submit", function (e) {
        e.preventDefault();

        let title = document.getElementById("eventTitle").value;
        let date = document.getElementById("eventDate").value;
        let category = document.getElementById("eventCategory").value;
        let description = document.getElementById("eventDescription").value;

        if (!title || !date) {
            alert("Please fill in all fields");
            return;
        }

        let eventId = new Date().getTime().toString();

        let newEvent = {
            id: eventId,
            title: title,
            start: date,
            category: category,
            description: description,
        };

        storedEvents.push(newEvent);
        localStorage.setItem("events", JSON.stringify(storedEvents));

        calendar.addEvent(newEvent);

        var addEventModal = bootstrap.Modal.getInstance(document.getElementById("addEventModal"));
        addEventModal.hide();
        document.getElementById("eventForm").reset();
    });

    // ✅ DELETE EVENT FUNCTION
    document.getElementById("deleteEventBtn").addEventListener("click", function () {
        let eventId = this.getAttribute("data-event-id");

        let event = calendar.getEventById(eventId);
        if (event) {
            event.remove();
        }

        storedEvents = storedEvents.filter((event) => event.id !== eventId);
        localStorage.setItem("events", JSON.stringify(storedEvents));

        var eventDetailModal = bootstrap.Modal.getInstance(document.getElementById("eventDetailModal"));
        eventDetailModal.hide();
    });

    // ✅ EDIT EVENT FUNCTION
    document.getElementById("editEventBtn").addEventListener("click", function () {
        let eventId = this.getAttribute("data-event-id");
        let event = storedEvents.find((event) => event.id === eventId);

        if (event) {
            document.getElementById("eventTitle").value = event.title;
            document.getElementById("eventDate").value = event.start;
            document.getElementById("eventCategory").value = event.category;
            document.getElementById("eventDescription").value = event.description;

            var eventDetailModal = bootstrap.Modal.getInstance(document.getElementById("eventDetailModal"));
            eventDetailModal.hide();

            var addEventModal = new bootstrap.Modal(document.getElementById("addEventModal"));
            addEventModal.show();

            document.getElementById("eventForm").onsubmit = function (e) {
                e.preventDefault();

                let calendarEvent = calendar.getEventById(eventId);
                if (calendarEvent) {
                    calendarEvent.remove();
                }

                storedEvents = storedEvents.filter((event) => event.id !== eventId);

                let updatedEvent = {
                    id: eventId,
                    title: document.getElementById("eventTitle").value,
                    start: document.getElementById("eventDate").value,
                    category: document.getElementById("eventCategory").value,
                    description: document.getElementById("eventDescription").value,
                };

                storedEvents.push(updatedEvent);
                localStorage.setItem("events", JSON.stringify(storedEvents));

                calendar.addEvent(updatedEvent);

                addEventModal.hide();
                document.getElementById("eventForm").reset();
                document.getElementById("eventForm").onsubmit = null;
            };
        }
    });
});


</script>
