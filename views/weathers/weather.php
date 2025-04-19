<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>

<div id="notification-container"></div>

<!-- Bootstrap Modal for Weather Change Alerts -->
<div class="modal fade" id="weatherChangeModal" tabindex="-1" aria-labelledby="weatherChangeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="weatherChangeModalLabel">Weather Change Alert</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="weatherChangeModalBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- WeatherAPI Widget -->
    <div id="weatherapi-weather-widget-3"></div>
    <script async src='https://www.weatherapi.com/weather/widget.ashx?loc=1318546&wid=3&tu=1&div=weatherapi-weather-widget-3'></script>
    <noscript>
        <a href="https://www.weatherapi.com/weather/q/phnum-penh-1318546" alt="Hour by hour Phnum Penh weather">10 days hour by hour Phnum Penh weather</a>
    </noscript>

    <!-- Temperature Chart -->
    <h6 style="color: #444;" class="mt-5">Today’s Temperature Trend</h6>
    <div class="chart-container two" style="background-color: #1a2a44; padding: 20px; border-radius: 10px; margin-top: 20px;">
        <canvas id="temperatureChart" width="600" height="400"></canvas>
    </div>
</div>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="container chart">
        <div class="chart-container one d-flex justify-content-around">
            <div class="chart-container-1">
                <h6>7-Day Weather Forecast</h6>
                <canvas id="weatherChart" width="550" height="400"></canvas>
            </div>
            <div class="chart-container-1">
                <h6>Ice Dessert Sales by Weather (kg)</h6>
                <canvas id="salesChart" width="550" height="400"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="table-container p-3 bg-white">
        <table id="weatherTable" border="1" class="table table-striped table-bordered table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th style="color: white;">Date</th>
                    <th style="color: white;">Day</th>
                    <th style="color: white;">Weather</th>
                    <th style="color: white;">Temperature (°C)</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="table-container p-3 bg-white">
        <h6>Sales Forecast</h6>
        <table id="salesTable" border="1" class="table table-striped table-bordered table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th style="color: white;">Weather</th>
                    <th style="color: white;">Sales Category</th>
                    <th style="color: white;">Amount to Sell (kg)</th>
                </tr>
            </thead>
            <tbody id="salesTableBody"></tbody>
        </table>
        <button id="updateSalesBtn" class="btn btn-primary mt-3">Update Amount to Sell</button>
    </div>
</div>

<!-- Bootstrap JS and Chart.js -->
<script>
// Configuration
const CONFIG = {
    API_KEY: 'fedd86317b25465cafa220110250403',
    CITY: 'Tuek Thla, Phnom Penh, Cambodia',
    TELEGRAM: {
        BOT_TOKEN: '7712638261:AAHYtki-eOGTcD60HZVtgpJ6M6-POb1C5vk',
        CHAT_ID: '7160406338'
    },
    WEATHER_IMAGES: {
        Sunny: 'https://openweathermap.org/img/wn/01d@2x.png',
        Cloudy: 'https://openweathermap.org/img/wn/03d@2x.png',
        Rainy: 'https://openweathermap.org/img/wn/10d@2x.png',
        Stormy: 'https://openweathermap.org/img/wn/11d@2x.png'
    }
};

// State
const state = {
    weatherData: [],
    weatherLabels: [],
    temperatures: [],
    weatherColors: [],
    salesData: [],
    salesColors: [],
    hourlyData: [],
    sunriseTime: '',
    sunsetTime: '',
    salesAmounts: JSON.parse(localStorage.getItem('salesAmounts')) || {
        Sunny: 5,
        Cloudy: 3,
        Rainy: 1,
        Stormy: 1
    },
    previousWeatherData: JSON.parse(localStorage.getItem('previousWeatherData')) || []
};

// Utility Functions
const utils = {
    getDayOfWeek(dateString) {
        const date = new Date(dateString);
        return ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][date.getDay()];
    },

    simplifyWeather(condition) {
        condition = condition.toLowerCase();
        if (["sunny", "clear"].some(w => condition.includes(w))) return "Sunny";
        if (["cloudy", "overcast"].some(w => condition.includes(w))) return "Cloudy";
        if (["rain", "shower"].some(w => condition.includes(w))) return "Rainy";
        if (["storm", "thunder"].some(w => condition.includes(w))) return "Stormy";
        return condition.charAt(0).toUpperCase() + condition.slice(1);
    },

    getWeatherColor(condition) {
        const colors = {
            Sunny: "#FFD700",
            Cloudy: "#B0C4DE",
            Rainy: "#4682B4",
            Stormy: "#708090"
        };
        return colors[condition] || "#D3D3D3";
    },

    getSalesColor(sales) {
        return sales >= 5 ? "#28a745" : sales >= 3 ? "#ff9800" : "#dc3545";
    },

    getIceDessertSales(condition) {
        return state.salesAmounts[condition] || 3;
    },

    showNotification(message) {
        const container = document.getElementById('notification-container');
        if (!container) return console.error('Notification container not found');
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.style.cssText = 'position: fixed; top: 10px; right: 10px; background-color: #333; color: white; padding: 10px; border-radius: 5px; z-index: 1000;';
        notification.textContent = message;
        container.appendChild(notification);
        setTimeout(() => notification.remove(), 5000);
    },

    showWeatherChangeModal(content) {
        const modalBody = document.getElementById('weatherChangeModalBody');
        if (!modalBody) return console.error('Weather change modal body not found');
        modalBody.innerHTML = content;
        const modal = new bootstrap.Modal(document.getElementById('weatherChangeModal'));
        modal.show();
    },

    canSendNotificationForSlot(slot) {
        const today = new Date().toISOString().split('T')[0];
        const key = `notificationSent_${slot}_${today}`;
        if (localStorage.getItem(key)) {
            return false;
        }
        localStorage.setItem(key, 'true');
        return true;
    },

    isScheduledTime() {
        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const isAM = hours === 5 && minutes >= 0 && minutes < 5; // 5:00–5:05 AM
        const isPM = hours === 17 && minutes >= 0 && minutes < 5; // 5:00–5:05 PM
        return { isAM, isPM };
    },

    hasWeatherForecastChanged(newForecastDays) {
        const newWeatherData = newForecastDays.map(day => ({
            date: day.date,
            weather: utils.simplifyWeather(day.day.condition.text)
        }));

        if (!state.previousWeatherData.length) {
            localStorage.setItem('previousWeatherData', JSON.stringify(newWeatherData));
            state.previousWeatherData = newWeatherData;
            return false; // No previous data, so no change
        }

        let hasChanges = false;
        for (let i = 0; i < newWeatherData.length; i++) {
            if (i >= state.previousWeatherData.length || 
                newWeatherData[i].weather !== state.previousWeatherData[i].weather || 
                newWeatherData[i].date !== state.previousWeatherData[i].date) {
                hasChanges = true;
                break;
            }
        }

        if (hasChanges) {
            localStorage.setItem('previousWeatherData', JSON.stringify(newWeatherData));
            state.previousWeatherData = newWeatherData;
        }

        return hasChanges;
    }
};

// Data Fetching
const api = {
    async fetchWeatherForecast() {
        const url = `https://api.weatherapi.com/v1/forecast.json?key=${CONFIG.API_KEY}&q=${encodeURIComponent(CONFIG.CITY)}&days=7`;
        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error(`Weather API request failed: ${response.statusText}`);
            const data = await response.json();

            if (!data?.forecast?.forecastday) {
                throw new Error('Invalid or missing forecast data');
            }

            const forecastDays = data.forecast.forecastday;
            state.weatherData = forecastDays.map(day => utils.simplifyWeather(day.day.condition.text));
            state.weatherLabels = forecastDays.map(day => utils.getDayOfWeek(day.date));
            state.temperatures = forecastDays.map(day => day.day.avgtemp_c);
            state.weatherColors = state.weatherData.map(utils.getWeatherColor);
            state.salesData = state.weatherData.map(utils.getIceDessertSales);
            state.salesColors = state.salesData.map(utils.getSalesColor);

            const today = forecastDays[0];
            state.hourlyData = today.hour.map(hour => ({
                time: new Date(hour.time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true }),
                weather: utils.simplifyWeather(hour.condition.text),
                temp: hour.temp_c,
                rainChance: hour.chance_of_rain
            }));
            state.sunriseTime = new Date(today.astro.sunrise).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });
            state.sunsetTime = new Date(today.astro.sunset).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });

            return forecastDays;
        } catch (error) {
            console.error('Error fetching weather forecast:', error.message);
            utils.showNotification('Failed to load weather data. Please try again later.');
            throw error;
        }
    },

    async sendToTelegram(message) {
        const url = `https://api.telegram.org/bot${CONFIG.TELEGRAM.BOT_TOKEN}/sendMessage`;
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ chat_id: CONFIG.TELEGRAM.CHAT_ID, text: message })
            });
            const result = await response.json();
            if (!result.ok) throw new Error(`Telegram API error: ${result.description}`);
            console.log('Telegram message sent successfully!');
            utils.showNotification('Telegram notification sent successfully!');
        } catch (error) {
            console.error('Error sending to Telegram:', error.message);
            utils.showNotification('Failed to send Telegram message.');
        }
    }
};

// Chart Rendering
const charts = {
    renderWeatherChart() {
        const ctx = document.getElementById('weatherChart')?.getContext('2d');
        if (!ctx) return console.error('Weather chart canvas not found');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: state.weatherLabels,
                datasets: [{
                    label: 'Temperature (°C)',
                    data: state.temperatures,
                    backgroundColor: state.weatherColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Temperature (°C)' } },
                    x: { title: { display: true, text: 'Day of Week' } }
                }
            }
        });
    },

    renderSalesChart() {
        const ctx = document.getElementById('salesChart')?.getContext('2d');
        if (!ctx) return console.error('Sales chart canvas not found');
        if (window.salesChart instanceof Chart) window.salesChart.destroy();
        window.salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: state.weatherLabels,
                datasets: [{
                    label: 'Ice Dessert Sales (kg)',
                    data: state.salesData,
                    backgroundColor: state.salesColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true, max: 10, title: { display: true, text: 'Kilograms (kg)' } },
                    x: { title: { display: true, text: 'Day of Week' } }
                }
            }
        });
    },

    renderTemperatureChart() {
        const ctx = document.getElementById('temperatureChart')?.getContext('2d');
        if (!ctx) return console.error('Temperature chart canvas not found');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: state.hourlyData.map(h => h.time),
                datasets: [{
                    label: 'Temperature (°C)',
                    data: state.hourlyData.map(h => h.temp),
                    fill: true,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    borderWidth: 2,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgb(255, 99, 132)',
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { title: { display: true, text: 'Time', color: '#fff' }, ticks: { color: '#fff' } },
                    y: { title: { display: true, text: 'Temperature (°C)', color: '#fff' }, beginAtZero: false, ticks: { color: '#fff' } }
                },
                plugins: {
                    legend: { labels: { color: '#fff' } },
                    annotation: {
                        annotations: [
                            {
                                type: 'line',
                                xMin: state.sunriseTime,
                                xMax: state.sunriseTime,
                                borderColor: 'rgba(255, 255, 0, 0.7)',
                                borderWidth: 2,
                                label: { content: 'Sunrise', enabled: true, position: 'top', color: '#fff' }
                            },
                            {
                                type: 'line',
                                xMin: state.sunsetTime,
                                xMax: state.sunsetTime,
                                borderColor: 'rgba(255, 165, 0, 0.7)',
                                borderWidth: 2,
                                label: { content: 'Sunset', enabled: true, position: 'top', color: '#fff' }
                            }
                        ]
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `${context.dataset.label}: ${context.raw}°C`,
                            afterLabel: context => `Weather: ${state.hourlyData[context.dataIndex].weather}\nRain Chance: ${state.hourlyData[context.dataIndex].rainChance}%`
                        }
                    }
                }
            }
        });
    }
};

// Table Rendering
const tables = {
    renderWeatherTable(forecastDays) {
        const tableBody = document.querySelector('#weatherTable tbody');
        if (!tableBody) return console.error('Weather table body not found');
        tableBody.innerHTML = forecastDays.map((day, index) => `
            <tr>
                <td>${day.date}</td>
                <td>${utils.getDayOfWeek(day.date)}</td>
                <td><img src="${CONFIG.WEATHER_IMAGES[state.weatherData[index]] || 'https://openweathermap.org/img/wn/02d@2x.png'}" alt="${state.weatherData[index]}" style="width: 30px; height: 30px; vertical-align: middle;"> ${state.weatherData[index]}</td>
                <td>${state.temperatures[index]}°C</td>
            </tr>
        `).join('');
    },

    renderSalesTable() {
        const tableBody = document.querySelector('#salesTableBody');
        if (!tableBody) return console.error('Sales table body not found');
        tableBody.innerHTML = `
            <tr><td>Sunny</td><td>High</td><td><input type="number" class="editable-input" data-weather="Sunny" value="${state.salesAmounts.Sunny}" min="0" step="0.1"></td></tr>
            <tr><td>Cloudy</td><td>Medium</td><td><input type="number" class="editable-input" data-weather="Cloudy" value="${state.salesAmounts.Cloudy}" min="0" step="0.1"></td></tr>
            <tr><td>Rainy</td><td>Low</td><td><input type="number" class="editable-input" data-weather="Rainy" value="${state.salesAmounts.Rainy}" min="0" step="0.1"></td></tr>
            <tr><td>Stormy</td><td>Low</td><td><input type="number" class="editable-input" data-weather="Stormy" value="${state.salesAmounts.Stormy}" min="0" step="0.1"></td></tr>
        `;

        document.querySelectorAll('.editable-input').forEach(input => {
            input.addEventListener('input', (e) => {
                if (e.target.value < 0) {
                    e.target.value = 0;
                    utils.showNotification('Negative values are not allowed!');
                }
            });
        });
    }
};

// Notifications
const notifications = {
    async sendSalesForecastMessage(forecastDays) {
        const today = new Date().toISOString().split('T')[0];
        let message = "🔔 7-Day Ice Dessert Sales Forecast for Tuek Thla, Phnom Penh 🔔\n\n";

        const todayForecast = forecastDays.find(day => day.date === today);
        if (todayForecast) {
            const weather = utils.simplifyWeather(todayForecast.day.condition.text);
            const dayOfWeek = utils.getDayOfWeek(todayForecast.date);
            const sales = utils.getIceDessertSales(weather);
            const temp = todayForecast.day.avgtemp_c;
            message += `📅 Today (${dayOfWeek}, ${todayForecast.date}):\n`;
            message += `Weather: ${weather} | Temp: ${temp}°C\n`;
            message += weather === "Sunny" ? `☀️ Hot day! Sell ${sales}kg of ice dessert!\n` :
                weather === "Cloudy" ? `☁️ Moderate day. Sell ${sales}kg of ice dessert.\n` :
                (weather === "Rainy" || weather === "Stormy") ? `🌧 Wet day. Sell ${sales}kg of ice dessert.\n` :
                `🛒 Normal day. Sell ${sales}kg of ice dessert.\n`;
            message += "\n";
        }

        message += "📋 7-Day Forecast:\n";
        message += forecastDays.map(day => {
            const weather = utils.simplifyWeather(day.day.condition.text);
            const dayOfWeek = utils.getDayOfWeek(day.date);
            const sales = utils.getIceDessertSales(weather);
            return `${dayOfWeek}, ${day.date}: ${weather} - Sell ${sales}kg`;
        }).join('\n');

        await api.sendToTelegram(message);
    },

    async sendWeatherChangeMessage(forecastDays) {
        let message = "🌦 Weather Change Alerts for Tuek Thla, Phnom Penh 🌦\n\n";
        let hasChanges = false;

        for (let i = 1; i < forecastDays.length; i++) {
            const prevWeather = utils.simplifyWeather(forecastDays[i - 1].day.condition.text);
            const currWeather = utils.simplifyWeather(forecastDays[i].day.condition.text);
            if (prevWeather !== currWeather) {
                const prevDay = utils.getDayOfWeek(forecastDays[i - 1].date);
                const currDay = utils.getDayOfWeek(forecastDays[i].date);
                const changeText = `${prevDay}, ${forecastDays[i - 1].date}: ${prevWeather} ➡️ ${currDay}, ${forecastDays[i].date}: ${currWeather}`;
                message += `⚠️ Weather change detected:\n${changeText}\n`;
                hasChanges = true;
            }
        }

        if (!hasChanges) {
            message += "✅ No weather changes detected in the next 7 days.\n";
        }

        await api.sendToTelegram(message);
    },

    async sendWeatherChangeAlerts(forecastDays) {
        let modalContent = "";
        let hasChanges = false;

        for (let i = 1; i < forecastDays.length; i++) {
            const prevWeather = utils.simplifyWeather(forecastDays[i - 1].day.condition.text);
            const currWeather = utils.simplifyWeather(forecastDays[i].day.condition.text);
            if (prevWeather !== currWeather) {
                const prevDay = utils.getDayOfWeek(forecastDays[i - 1].date);
                const currDay = utils.getDayOfWeek(forecastDays[i].date);
                const changeText = `${prevDay}, ${forecastDays[i - 1].date}: ${prevWeather} ➡️ ${currDay}, ${forecastDays[i].date}: ${currWeather}`;
                modalContent += `<p>${changeText}</p>`;
                utils.showNotification(`Weather Change: ${changeText}`);
                hasChanges = true;
            }
        }

        if (hasChanges) {
            utils.showWeatherChangeModal(modalContent);
        } else {
            utils.showNotification('No weather changes detected in the next 7 days.');
            utils.showWeatherChangeModal('<p>No weather changes detected in the next 7 days.</p>');
        }
    },

    async handleNotifications(forecastDays) {
        const { isAM, isPM } = utils.isScheduledTime();
        const slot = isAM ? '5AM' : isPM ? '5PM' : null;
        const hasWeatherChanged = utils.hasWeatherForecastChanged(forecastDays);

        if (hasWeatherChanged) {
            console.log('New weather forecast changes detected. Sending immediate Telegram notifications.');
            await notifications.sendSalesForecastMessage(forecastDays);
            await notifications.sendWeatherChangeMessage(forecastDays);
            return;
        }

        if (slot && utils.canSendNotificationForSlot(slot)) {
            console.log(`Sending scheduled Telegram notifications for ${slot}`);
            await notifications.sendSalesForecastMessage(forecastDays);
            await notifications.sendWeatherChangeMessage(forecastDays);
        } else {
            console.log('Not within scheduled time or notifications already sent for this slot.');
        }
    }
};

// Event Handlers
const events = {
    handleSalesUpdate() {
        document.getElementById('updateSalesBtn').addEventListener('click', () => {
            document.querySelectorAll('.editable-input').forEach(input => {
                const weather = input.getAttribute('data-weather');
                state.salesAmounts[weather] = parseFloat(input.value) || 0;
            });
            localStorage.setItem('salesAmounts', JSON.stringify(state.salesAmounts));
            state.salesData = state.weatherData.map(utils.getIceDessertSales);
            state.salesColors = state.salesData.map(utils.getSalesColor);
            charts.renderSalesChart();
            utils.showNotification('Sales amounts updated successfully!');
        });
    }
};

// Initialization
async function init() {
    try {
        const forecastDays = await api.fetchWeatherForecast();
        charts.renderWeatherChart();
        charts.renderSalesChart();
        charts.renderTemperatureChart();
        tables.renderWeatherTable(forecastDays);
        tables.renderSalesTable();
        events.handleSalesUpdate();
        await notifications.handleNotifications(forecastDays);
        await notifications.sendWeatherChangeAlerts(forecastDays);
    } catch (error) {
        console.error('Initialization failed:', error);
        utils.showNotification('Failed to initialize application.');
    }
}

window.onload = init;
</script>