<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h2 class="mb-3">Calendar</h2>
    <div class="mb-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="d-flex gap-2 flex-wrap">
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#manageCategoriesOffcanvas" onclick="toggleCollapse('addEventCollapse')">
                <i class="bi bi-plus-circle me-1"></i> Add Event
            </button>
            <button class="btn btn-outline-primary" data-bs-toggle="offcanvas" data-bs-target="#manageCategoriesOffcanvas" onclick="toggleCollapse('addCategoryCollapse')">
                <i class="bi bi-tags me-1"></i> Manage Categories
            </button>
            <!-- <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" id="eventFilter" data-selected="all" type="button" data-bs-toggle="dropdown">All</button>
                <ul class="dropdown-menu" id="categoryFilterMenu">
                    <li><a class="dropdown-item" data-filter="all">All</a></li>
                </ul>
            </div> -->
        </div>
        <span id="notification-count" class="badge bg-danger" style="display: none;"></span>
    </div>
    <div id='calendar'></div>
</div>

<!-- Manage Categories Offcanvas -->
<div class="offcanvas offcanvas-end" id="manageCategoriesOffcanvas" tabindex="-1" aria-labelledby="manageCategoriesOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="manageCategoriesOffcanvasLabel">Manage Events & Categories</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="accordion" id="offcanvasAccordion">
            <!-- Add Event Form -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="addEventHeading">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#addEventCollapse" aria-expanded="true" aria-controls="addEventCollapse">
                        Add New Event
                    </button>
                </h2>
                <div id="addEventCollapse" class="accordion-collapse collapse show" aria-labelledby="addEventHeading" 
                     data-bs-parent="#offcanvasAccordion">
                    <div class="accordion-body">
                        <form id="eventForm" class="mb-4">
                            <div class="mb-3">
                                <label class="form-label">Event Title</label>
                                <input type="text" class="form-control" id="eventTitle" placeholder="Enter event title" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Event Date</label>
                                <input type="date" class="form-control" id="eventDate" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-control" id="eventCategory" required>
                                    <!-- Categories will be dynamically populated here -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" id="eventDescription" placeholder="Enter description" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" id="saveEventBtn">
                                <span id="saveEventText">Save Event</span>
                                <span id="saveEventSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Add Category Form -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="addCategoryHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#addCategoryCollapse" aria-expanded="false" aria-controls="addCategoryCollapse">
                        Add New Category
                    </button>
                </h2>
                <div id="addCategoryCollapse" class="accordion-collapse collapse" aria-labelledby="addCategoryHeading" 
                     data-bs-parent="#offcanvasAccordion">
                    <div class="accordion-body">
                        <form id="addCategoryForm" class="mb-4">
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="categoryName" placeholder="Enter category name" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoryColor" class="form-label">Category Color</label>
                                <input type="color" class="form-control form-control-color" id="categoryColor" value="#563d7c" title="Choose category color">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Add Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" id="categorySearch" placeholder="Search categories...">
        </div>
        <h6>Existing Categories</h6>
        <div id="categoryList" class="mt-3 accordion" role="list" aria-label="Category list">
            <!-- Categories will be dynamically populated here -->
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm">
                    <input type="hidden" id="editCategoryId">
                    <div class="mb-3">
                        <label for="editCategoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="editCategoryName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCategoryColor" class="form-label">Category Color</label>
                        <input type="color" class="form-control form-control-color" id="editCategoryColor">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the category "<span id="deleteCategoryName"></span>"?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteCategory">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Event Detail Modal -->
<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="eventDetailModalLabel">
                    <i class="bi bi-calendar-event me-2 text-white"></i> Event Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-start">
                    <div class="p-2 bg-primary rounded-circle text-white text-center me-3" style="width: 50px; height: 50px;">
                        <i class="bi bi-bookmark-fill fs-3" id="categoryIcon"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h4 class="fw-bold mb-3" id="detailTitle"></h4>
                        <p class="mb-2"><i class="bi bi-calendar3 text-primary me-2"></i><strong>Date:</strong> <span id="detailDate"></span></p>
                        <p class="mb-2"><i class="bi bi-tag-fill text-primary me-2"></i><strong>Category:</strong> <span id="detailCategory"></span></p>
                        <p class="mb-0"><i class="bi bi-chat-square-text text-primary me-2"></i><strong>Description:</strong> <span id="detailDescription"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button class="btn btn-outline-primary" id="editEventBtn">
                    <i class="bi bi-pencil-square me-2"></i>Edit Event
                </button>
                <button class="btn btn-outline-danger" id="deleteEventBtn">
                    <i class="bi bi-trash-fill me-2"></i>Delete Event
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");

    // Telegram Bot Configuration
    const TELEGRAM_BOT_TOKEN = '7856175412:AAHKHXSM2w4JyR8beML6M46aSsAEMHQJQXI';
    const TELEGRAM_CHAT_ID = '7160406338';

    // Initialize categories and events
    let storedCategories = JSON.parse(localStorage.getItem("categories")) || [
        { id: "1", name: "personal", color: "#90EE90" },
        { id: "2", name: "business", color: "#ADD8E6" },
        { id: "3", name: "other", color: "#1E90FF" }
    ];
    let storedEvents = JSON.parse(localStorage.getItem("events")) || [];
    storedEvents = storedEvents.map((event, index) => ({
        id: event.id || index.toString(),
        ...event,
        isRead: event.isRead || false,
        isNotified: event.isNotified || false,
        timestamp: event.timestamp || new Date().toISOString()
    }));
    localStorage.setItem("events", JSON.stringify(storedEvents));
    localStorage.setItem("categories", JSON.stringify(storedCategories));

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
        },
        events: storedEvents.map(event => ({
            ...event,
            backgroundColor: getCategoryColor(event.category),
            borderColor: "#FFFFFF"
        })),
        eventClick: function (info) {
            document.getElementById("detailTitle").innerText = info.event.title;
            document.getElementById("detailDate").innerText = info.event.startStr;
            document.getElementById("detailCategory").innerText = info.event.extendedProps.category || "N/A";
            document.getElementById("detailDescription").innerText = info.event.extendedProps.description || "No description";

            document.getElementById("editEventBtn").setAttribute("data-event-id", info.event.id);
            document.getElementById("deleteEventBtn").setAttribute("data-event-id", info.event.id);

            if (info.event.extendedProps.description && info.event.extendedProps.description.toLowerCase().includes("low stock")) {
                document.getElementById("editEventBtn").style.display = "none";
            } else {
                document.getElementById("editEventBtn").style.display = "inline-block";
            }

            var modal = new bootstrap.Modal(document.getElementById("eventDetailModal"));
            modal.show();

            storedEvents = storedEvents.map(event => 
                event.id === info.event.id ? { ...event, isRead: true } : event
            );
            localStorage.setItem("events", JSON.stringify(storedEvents));
            updateNotificationBadge();
        },
    });

    calendar.render();
    updateNotificationBadge();
    populateCategorySelect();
    populateCategoryFilter();
    populateCategoryList();

    // Responsive calendar view
    if (window.innerWidth < 768) {
        calendar.changeView("listWeek");
    }

    window.addEventListener("resize", () => {
        if (window.innerWidth < 768 && calendar.view.type !== "listWeek") {
            calendar.changeView("listWeek");
        } else if (window.innerWidth >= 768 && calendar.view.type !== "dayGridMonth") {
            calendar.changeView("dayGridMonth");
        }
    });

    // Toggle collapse sections
    window.toggleCollapse = function (targetId) {
        const targetCollapse = document.getElementById(targetId);
        const otherCollapses = document.querySelectorAll(`#offcanvasAccordion .accordion-collapse:not(#${targetId})`);
        if (!targetCollapse.classList.contains("show")) {
            otherCollapses.forEach(collapse => {
                bootstrap.Collapse.getInstance(collapse)?.hide();
            });
            new bootstrap.Collapse(targetCollapse, { toggle: true });
        }
    };

    // Helper function to get category color
    function getCategoryColor(categoryName) {
        const category = storedCategories.find(cat => cat.name === categoryName);
        return category ? category.color : "#1E90FF";
    }

    // Populate category select in event form
    function populateCategorySelect() {
        const select = document.getElementById("eventCategory");
        const selectedValue = select.value;
        select.innerHTML = "";
        storedCategories.forEach(category => {
            const option = document.createElement("option");
            option.value = category.name;
            option.textContent = category.name;
            select.appendChild(option);
        });
        if (storedCategories.some(cat => cat.name === selectedValue)) {
            select.value = selectedValue;
        }
    }

    // Populate category filter dropdown
    function populateCategoryFilter() {
        const menu = document.getElementById("categoryFilterMenu");
        const selectedFilter = document.getElementById("eventFilter").getAttribute("data-selected");
        menu.innerHTML = '<li><a class="dropdown-item" data-filter="all">All</a></li>';
        storedCategories.forEach(category => {
            const li = document.createElement("li");
            const a = document.createElement("a");
            a.className = "dropdown-item";
            a.setAttribute("data-filter", category.name);
            a.textContent = category.name;
            li.appendChild(a);
            menu.appendChild(li);
        });

        document.querySelectorAll(".dropdown-item").forEach((item) => {
            item.addEventListener("click", function (e) {
                e.preventDefault();
                let filterCategory = this.getAttribute("data-filter");

                document.getElementById("eventFilter").innerText = this.innerText;
                document.getElementById("eventFilter").setAttribute("data-selected", filterCategory);

                calendar.removeAllEvents();

                let filteredEvents = storedEvents;
                if (filterCategory !== "all") {
                    filteredEvents = storedEvents.filter(event => event.category === filterCategory);
                }

                filteredEvents = filteredEvents.map(event => ({
                    ...event,
                    backgroundColor: getCategoryColor(event.category),
                    borderColor: "#FFFFFF"
                }));

                calendar.addEventSource(filteredEvents);
            });
        });

        if (storedCategories.some(cat => cat.name === selectedFilter) || selectedFilter === "all") {
            document.getElementById("eventFilter").innerText = selectedFilter === "all" ? "All" : selectedFilter;
            document.getElementById("eventFilter").setAttribute("data-selected", selectedFilter);
        }
    }

    // Debounce function for search
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Populate category list in offcanvas
    function populateCategoryList(filter = "") {
        const categoryList = document.getElementById("categoryList");
        categoryList.innerHTML = storedCategories.length === 0 
            ? '<p class="text-muted">No categories found.</p>'
            : '';
        let filteredCategories = storedCategories;
        if (filter) {
            filteredCategories = storedCategories.filter(cat => 
                cat.name.toLowerCase().includes(filter.toLowerCase())
            );
        }
        filteredCategories.forEach((category, index) => {
            const eventCount = storedEvents.filter(event => event.category === category.name).length;
            const card = document.createElement("div");
            card.className = `accordion-item category-card animate__animated animate__fadeIn`;
            card.setAttribute("data-id", category.id);
            card.setAttribute("role", "listitem");
            card.innerHTML = `
                <h2 class="accordion-header" id="categoryHeading${index}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#categoryCollapse${index}" aria-expanded="false" 
                            aria-controls="categoryCollapse${index}">
                        <div class="d-flex align-items-center w-100">
                            <span class="badge me-2 color-swatch" style="background-color: ${category.color}; width: 24px; height: 24px;" 
                                  data-bs-toggle="tooltip" title="Category color"></span>
                            <i class="bi bi-tag me-2 text-muted"></i>
                            <span class="category-name">${category.name}</span>
                            <span class="badge bg-secondary ms-auto">${eventCount} events</span>
                        </div>
                    </button>
                </h2>
                <div id="categoryCollapse${index}" class="accordion-collapse collapse" 
                     aria-labelledby="categoryHeading${index}" data-bs-parent="#categoryList">
                    <div class="accordion-body d-flex justify-content-between">
                        <button class="btn btn-sm btn-outline-primary edit-category" data-id="${category.id}" 
                                data-bs-toggle="tooltip" title="Edit Category" aria-label="Edit Category">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger delete-category" data-id="${category.id}" 
                                data-bs-toggle="tooltip" title="Delete Category" aria-label="Delete Category">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                </div>
            `;
            categoryList.appendChild(card);
        });

        // Initialize tooltips
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        [...tooltipTriggerList].forEach(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        // Color swatch hover effect
        document.querySelectorAll(".color-swatch").forEach(swatch => {
            swatch.addEventListener("mouseenter", () => {
                const card = swatch.closest(".category-card");
                card.style.background = `linear-gradient(145deg, ${swatch.style.backgroundColor}22, #ffffff)`;
            });
            swatch.addEventListener("mouseleave", () => {
                const card = swatch.closest(".category-card");
                card.style.background = "linear-gradient(145deg, #ffffff, #f0f0f0)";
            });
        });

        // Initialize SortableJS for drag-and-drop
        new Sortable(categoryList, {
            animation: 150,
            handle: ".accordion-button",
            onEnd: (evt) => {
                const movedCategory = storedCategories.splice(evt.oldIndex, 1)[0];
                storedCategories.splice(evt.newIndex, 0, movedCategory);
                localStorage.setItem("categories", JSON.stringify(storedCategories));
                populateCategorySelect();
                populateCategoryFilter();
            }
        });

        // Edit category
        document.querySelectorAll(".edit-category").forEach(button => {
            button.addEventListener("click", () => {
                const categoryId = button.getAttribute("data-id");
                const category = storedCategories.find(cat => cat.id === categoryId);
                if (category) {
                    document.getElementById("editCategoryId").value = categoryId;
                    document.getElementById("editCategoryName").value = category.name;
                    document.getElementById("editCategoryColor").value = category.color;
                    new bootstrap.Modal(document.getElementById("editCategoryModal")).show();
                }
            });
        });

        // Delete category
        document.querySelectorAll(".delete-category").forEach(button => {
            button.addEventListener("click", () => {
                const categoryId = button.getAttribute("data-id");
                const category = storedCategories.find(cat => cat.id === categoryId);
                if (category) {
                    if (storedEvents.some(event => event.category === category.name)) {
                        alert("Cannot delete category because it is used by one or more events.");
                        return;
                    }
                    document.getElementById("deleteCategoryName").textContent = category.name;
                    document.getElementById("confirmDeleteCategory").setAttribute("data-id", categoryId);
                    new bootstrap.Modal(document.getElementById("deleteCategoryModal")).show();
                }
            });
        });
    }

    // Confirm category deletion
    document.getElementById("confirmDeleteCategory").addEventListener("click", () => {
        const categoryId = document.getElementById("confirmDeleteCategory").getAttribute("data-id");
        storedCategories = storedCategories.filter(cat => cat.id !== categoryId);
        localStorage.setItem("categories", JSON.stringify(storedCategories));
        populateCategorySelect();
        populateCategoryFilter();
        populateCategoryList();
        bootstrap.Modal.getInstance(document.getElementById("deleteCategoryModal")).hide();
    });

    // Handle edit category form submission
    document.getElementById("editCategoryForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const categoryId = document.getElementById("editCategoryId").value;
        const newName = document.getElementById("editCategoryName").value.trim();
        const newColor = document.getElementById("editCategoryColor").value;

        if (!newName) {
            alert("Category name cannot be empty.");
            return;
        }
        if (newName !== storedCategories.find(cat => cat.id === categoryId).name && 
            storedCategories.some(cat => cat.name === newName)) {
            alert("Category name already exists.");
            return;
        }

        const oldName = storedCategories.find(cat => cat.id === categoryId).name;
        storedCategories = storedCategories.map(cat => 
            cat.id === categoryId ? { ...cat, name: newName, color: newColor } : cat
        );
        storedEvents = storedEvents.map(event => 
            event.category === oldName ? { ...event, category: newName } : event
        );
        localStorage.setItem("categories", JSON.stringify(storedCategories));
        localStorage.setItem("events", JSON.stringify(storedEvents));
        populateCategorySelect();
        populateCategoryFilter();
        populateCategoryList();
        refreshCalendar();
        bootstrap.Modal.getInstance(document.getElementById("editCategoryModal")).hide();
    });

    // Handle add category form submission
    document.getElementById("addCategoryForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const categoryName = document.getElementById("categoryName").value.trim();
        const categoryColor = document.getElementById("categoryColor").value;

        if (!categoryName) {
            alert("Category name cannot be empty.");
            return;
        }
        if (storedCategories.some(cat => cat.name === categoryName)) {
            alert("Category name already exists.");
            return;
        }
        const newCategory = {
            id: new Date().getTime().toString(),
            name: categoryName,
            color: categoryColor
        };
        storedCategories.push(newCategory);
        localStorage.setItem("categories", JSON.stringify(storedCategories));
        populateCategorySelect();
        populateCategoryFilter();
        populateCategoryList();
        document.getElementById("addCategoryForm").reset();
        document.getElementById("eventCategory").value = newCategory.name; // Auto-select new category
        toggleCollapse("addEventCollapse"); // Switch to event form
    });

    // Search categories with debounce
    document.getElementById("categorySearch").addEventListener("input", debounce(function () {
        populateCategoryList(this.value);
    }, 300));

    // Refresh calendar events
    function refreshCalendar() {
        calendar.removeAllEvents();
        const filterCategory = document.getElementById("eventFilter").getAttribute("data-selected");
        let filteredEvents = storedEvents;
        if (filterCategory !== "all") {
            filteredEvents = storedEvents.filter(event => event.category === filterCategory);
        }
        filteredEvents = filteredEvents.map(event => ({
            ...event,
            backgroundColor: getCategoryColor(event.category),
            borderColor: "#FFFFFF"
        }));
        calendar.addEventSource(filteredEvents);
    }

    // Format date for Telegram message and alerts
    function formatDate(dateStr) {
        const date = new Date(dateStr);
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    }

    // Check if date is today
    function isToday(dateStr) {
        const eventDate = new Date(dateStr);
        const currentDate = new Date();
        currentDate.setHours(0, 0, 0, 0);
        eventDate.setHours(0, 0, 0, 0);
        return eventDate.getTime() === currentDate.getTime();
    }

    // Generate Telegram message
    function generateTelegramMessage(event, isUpdate = false) {
        const { title, start, category, description } = event;
        const action = isUpdate ? "updated" : "added";
        const formattedDate = formatDate(start);
        let header = '';
        let emoji = '';
        switch (category) {
            case 'personal':
                header = `🎉 *TODAY'S THE DAY!* 🎈\nYour personal event is ${action} and ready to shine! 🥳`;
                emoji = '🏠';
                break;
            case 'business':
                header = `💼 *TODAY'S BIG!* 📊\nYour business event is ${action} for action! 🚀`;
                emoji = '🏢';
                break;
            default:
                header = `🌟 *TODAY'S SPECIAL!* ✨\nYour event is ${action} and set to sparkle! 📅`;
                emoji = '🌈';
                break;
        }
        return `${header}\n\n` +
               `📋 *Event Details* 📋\n` +
               `| **Detail**    | **Info**                  |\n` +
               `|---------------|---------------------------|\n` +
               `| Title         | ${title}                  |\n` +
               `| Date          | ${formattedDate}          |\n` +
               `| Category      | ${category}               |\n` +
               `| Description   | ${description}            |\n\n` +
               `➡️ *Get ready for an awesome ${category} day!* ${emoji}`;
    }

    // Send Telegram notification
    async function sendTelegramNotification(message, retries = 2) {
        const url = `https://api.telegram.org/bot${TELEGRAM_BOT_TOKEN}/sendMessage`;
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    chat_id: TELEGRAM_CHAT_ID,
                    text: message,
                    parse_mode: 'Markdown',
                }),
            });
            const responseData = await response.json();
            if (!response.ok) {
                let errorMessage = 'Failed to send Telegram notification.';
                if (response.status === 401) {
                    errorMessage = 'Invalid Telegram bot token.';
                } else if (response.status === 400) {
                    errorMessage = 'Invalid Telegram chat ID or message format.';
                } else if (response.status === 429) {
                    errorMessage = 'Too many Telegram requests.';
                } else {
                    errorMessage = `Telegram error: ${responseData.description || 'Unknown error'}`;
                }
                if (retries > 0) {
                    await new Promise(resolve => setTimeout(resolve, 1000));
                    return sendTelegramNotification(message, retries - 1);
                }
                throw new Error(errorMessage);
            }
        } catch (error) {
            if (retries > 0) {
                await new Promise(resolve => setTimeout(resolve, 1000));
                return sendTelegramNotification(message, retries - 1);
            }
            throw error;
        }
    }

    // Check and notify today's events
    function checkAndNotifyTodayEvents() {
        storedEvents = JSON.parse(localStorage.getItem("events")) || [];
        const todayEvents = storedEvents.filter(event => isToday(event.start) && !event.isNotified);
        
        todayEvents.forEach(async (event) => {
            try {
                const message = generateTelegramMessage(event);
                await sendTelegramNotification(message);
                storedEvents = storedEvents.map(e => 
                    e.id === event.id ? { ...e, isNotified: true } : e
                );
                localStorage.setItem("events", JSON.stringify(storedEvents));
            } catch (error) {
                console.error('Failed to send notification for event:', event.id, error);
            }
        });
    }

    checkAndNotifyTodayEvents();

    // Schedule daily check
    function scheduleDailyCheck() {
        const now = new Date();
        const midnight = new Date(now);
        midnight.setHours(24, 0, 0, 0);
        const timeToMidnight = midnight.getTime() - now.getTime();
        
        setTimeout(() => {
            checkAndNotifyTodayEvents();
            setInterval(checkAndNotifyTodayEvents, 24 * 60 * 60 * 1000);
        }, timeToMidnight);
    }
    scheduleDailyCheck();

    // Add event
    document.getElementById("eventForm").addEventListener("submit", async function (e) {
        e.preventDefault();

        const saveBtn = document.getElementById("saveEventBtn");
        const saveText = document.getElementById("saveEventText");
        const saveSpinner = document.getElementById("saveEventSpinner");

        // Show loading state
        saveBtn.disabled = true;
        saveText.classList.add("d-none");
        saveSpinner.classList.remove("d-none");

        try {
            let title = document.getElementById("eventTitle").value.trim();
            let date = document.getElementById("eventDate").value;
            let category = document.getElementById("eventCategory").value;
            let description = document.getElementById("eventDescription").value.trim();

            if (!title || !date || !category || !description) {
                alert("Please fill in all fields.");
                throw new Error("Missing fields");
            }

            const eventDate = new Date(date);
            const currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0);
            if (eventDate < currentDate) {
                alert(`Event date must be today or in the future. Selected: ${formatDate(date)}`);
                throw new Error("Invalid date");
            }

            let eventId = new Date().getTime().toString();

            let newEvent = {
                id: eventId,
                title: title,
                start: date,
                category: category,
                description: description,
                isRead: false,
                isNotified: false,
                timestamp: new Date().toISOString()
            };

            storedEvents.push(newEvent);
            localStorage.setItem("events", JSON.stringify(storedEvents));

            calendar.addEvent({
                ...newEvent,
                backgroundColor: getCategoryColor(newEvent.category),
                borderColor: "#FFFFFF"
            });

            if (isToday(date)) {
                const message = generateTelegramMessage(newEvent);
                await sendTelegramNotification(message);
                storedEvents = storedEvents.map(e => 
                    e.id === newEvent.id ? { ...e, isNotified: true } : e
                );
                localStorage.setItem("events", JSON.stringify(storedEvents));
            }

            // Update UI
            populateCategoryList(); // Refresh category list to update event count
            updateNotificationBadge();

            var offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById("manageCategoriesOffcanvas"));
            offcanvas.hide();
            document.getElementById("eventForm").reset();
        } catch (error) {
            console.error("Error adding event:", error);
            alert(error.message || "An error occurred while adding the event.");
        } finally {
            // Reset loading state
            saveBtn.disabled = false;
            saveText.classList.remove("d-none");
            saveSpinner.classList.add("d-none");
        }
    });

    // Delete event
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
        updateNotificationBadge();
        populateCategoryList(); // Update event count in category list
    });

    // Edit event
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

            var offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById("manageCategoriesOffcanvas")) || 
                            new bootstrap.Offcanvas(document.getElementById("manageCategoriesOffcanvas"));
            offcanvas.show();
            toggleCollapse("addEventCollapse");

            document.getElementById("eventForm").onsubmit = async function (e) {
                e.preventDefault();

                const saveBtn = document.getElementById("saveEventBtn");
                const saveText = document.getElementById("saveEventText");
                const saveSpinner = document.getElementById("saveEventSpinner");

                saveBtn.disabled = true;
                saveText.classList.add("d-none");
                saveSpinner.classList.remove("d-none");

                try {
                    let calendarEvent = calendar.getEventById(eventId);
                    if (calendarEvent) {
                        calendarEvent.remove();
                    }

                    storedEvents = storedEvents.filter((event) => event.id !== eventId);

                    let updatedEvent = {
                        id: eventId,
                        title: document.getElementById("eventTitle").value.trim(),
                        start: document.getElementById("eventDate").value,
                        category: document.getElementById("eventCategory").value,
                        description: document.getElementById("eventDescription").value.trim(),
                        isRead: event.isRead,
                        isNotified: event.isNotified,
                        timestamp: event.timestamp
                    };

                    const eventDate = new Date(updatedEvent.start);
                    const currentDate = new Date();
                    currentDate.setHours(0, 0, 0, 0);
                    if (eventDate < currentDate) {
                        alert(`Event date must be today or in the future. Selected: ${formatDate(updatedEvent.start)}`);
                        throw new Error("Invalid date");
                    }

                    if (!updatedEvent.title || !updatedEvent.start || !updatedEvent.category || !updatedEvent.description) {
                        alert("Please fill in all fields.");
                        throw new Error("Missing fields");
                    }

                    storedEvents.push(updatedEvent);
                    localStorage.setItem("events", JSON.stringify(storedEvents));

                    calendar.addEvent({
                        ...updatedEvent,
                        backgroundColor: getCategoryColor(updatedEvent.category),
                        borderColor: "#FFFFFF"
                    });

                    if (isToday(updatedEvent.start) && !updatedEvent.isNotified) {
                        const message = generateTelegramMessage(updatedEvent, true);
                        await sendTelegramNotification(message);
                        storedEvents = storedEvents.map(e => 
                            e.id === updatedEvent.id ? { ...e, isNotified: true } : e
                        );
                        localStorage.setItem("events", JSON.stringify(storedEvents));
                    }

                    offcanvas.hide();
                    document.getElementById("eventForm").reset();
                    document.getElementById("eventForm").onsubmit = null;
                    updateNotificationBadge();
                    populateCategoryList(); // Update event count
                } catch (error) {
                    console.error("Error editing event:", error);
                    alert(error.message || "An error occurred while editing the event.");
                } finally {
                    saveBtn.disabled = false;
                    saveText.classList.remove("d-none");
                    saveSpinner.classList.add("d-none");
                }
            };
        }
    });

    // Update notification badge
    function updateNotificationBadge() {
        let events = JSON.parse(localStorage.getItem("events")) || [];
        let unreadCount = events.filter(event => !event.isRead).length;
        let badge = document.getElementById("notification-count");

        if (badge) {
            if (unreadCount > 0) {
                badge.textContent = unreadCount;
                badge.style.display = "inline-block";
            } else {
                badge.style.display = "none";
            }
        }
    }
});
</script>
