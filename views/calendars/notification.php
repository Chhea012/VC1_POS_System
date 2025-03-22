<div class="container-xxl flex-grow-1 container-p-y ">
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>

<div class="container mt-4">
        <h2>Notifications</h2>
        <div id="notificationContainer">
            <!-- Notifications will be added here dynamically -->
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let storedEvents = JSON.parse(localStorage.getItem("events")) || [];

            let notificationContainer = document.getElementById("notificationContainer");

            if (storedEvents.length === 0) {
                notificationContainer.innerHTML = '<div class="alert alert-info">No upcoming events.</div>';
            } else {
                storedEvents.forEach(event => {
                    let alertDiv = document.createElement("div");
                    alertDiv.classList.add("alert", "alert-warning", "d-flex", "justify-content-between", "align-items-center");

                    alertDiv.innerHTML = `
                        <div>
                            <strong>${event.title}</strong> - ${event.start}
                            <br><small>Category: ${event.category}</small>
                        </div>
                        <button class="btn btn-sm btn-danger" onclick="removeNotification('${event.id}')">Dismiss</button>
                        
                    `;

                    notificationContainer.appendChild(alertDiv);
                });
            }
        });

        function removeNotification(eventId) {
            let storedEvents = JSON.parse(localStorage.getItem("events")) || [];
            storedEvents = storedEvents.filter(event => event.id !== eventId);
            localStorage.setItem("events", JSON.stringify(storedEvents));
            location.reload();
        }
    </script>
</div> 

