<div id="notification-container"></div>

  <!-- Bootstrap Modal for Weather Change Alerts -->
  <div class="modal fade" id="weatherChangeModal" tabindex="-1" aria-labelledby="weatherChangeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="weatherChangeModalLabel">Weather Change Alerts</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="weatherChangeModalBody">
          <!-- Weather change messages will be inserted here -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- WeatherAPI Widget -->
    <div id="weatherapi-weather-widget-3"></div>
    <script type='text/javascript' src='https://www.weatherapi.com/weather/widget.ashx?loc=1318546&wid=3&tu=1&div=weatherapi-weather-widget-3' async></script>
    <noscript>
      <a href="https://www.weatherapi.com/weather/q/phnum-penh-1318546" alt="Hour by hour Phnum Penh weather">10 day hour by hour Phnum Penh weather</a>
    </noscript>

    <!-- Temperature Chart -->
    <h6 style="color: #444;" class="mt-5 ">Today’s Temperature Trend</h6>
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
            <th>Date</th>
            <th>Day</th>
            <th>Weather</th>
            <th>Temperature (°C)</th>
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
            <th>Weather</th>
            <th>Sales Category</th>
            <th>Amount to Sell (kg)</th>
          </tr>
        </thead>
        <tbody id="salesTableBody"></tbody>
      </table>
      <button id="updateSalesBtn" class="btn btn-primary mt-3">Update Amount to Sell</button>
    </div>
  </div>

  <!-- Bootstrap JS and Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Global variables
    let weatherData = [],
      weatherLabels = [],
      temperatures = [],
      weatherColors = [],
      salesData = [],
      salesColors = [],
      hourlyData = [],
      sunriseTime = '',
      sunsetTime = '';
    let salesAmounts = JSON.parse(localStorage.getItem('salesAmounts')) || {
      "Sunny": 5,
      "Cloudy": 3,
      "Rainy": 1,
      "Stormy": 1
    };


    // Constants
    const API_KEY = 'fedd86317b25465cafa220110250403';
    const CITY = 'Tuek Thla, Phnom Penh, Cambodia';
    const TELEGRAM_BOT_TOKEN = '7712638261:AAHYtki-eOGTcD60HZVtgpJ6M6-POb1C5vk';
    const TELEGRAM_CHAT_ID = '7160406338';

    // Weather image mapping
    const weatherImages = {
      'Sunny': 'https://openweathermap.org/img/wn/01d@2x.png',
      'Cloudy': 'https://openweathermap.org/img/wn/03d@2x.png',
      'Rainy': 'https://openweathermap.org/img/wn/10d@2x.png',
      'Stormy': 'https://openweathermap.org/img/wn/11d@2x.png'
    };

    // Fetch 7-day weather forecast from WeatherAPI
    async function fetchWeatherForecast() {
      const forecastUrl = `https://api.weatherapi.com/v1/forecast.json?key=${API_KEY}&q=${encodeURIComponent(CITY)}&days=7`;
      try {
        const response = await fetch(forecastUrl);
        if (!response.ok) throw new Error(`Weather API request failed: ${response.statusText}`);
        const data = await response.json();

        if (!data?.forecast?.forecastday) {
          throw new Error('Invalid or missing forecast data');
        }

        const forecastDays = data.forecast.forecastday;
        weatherData = forecastDays.map(day => simplifyWeather(day.day.condition.text));
        weatherLabels = forecastDays.map(day => getDayOfWeek(day.date));
        temperatures = forecastDays.map(day => day.day.avgtemp_c);
        salesData = weatherData.map(condition => getIceDessertSales(condition));
        weatherColors = weatherData.map(condition => getWeatherColor(condition));
        salesColors = salesData.map(sales => getSalesColor(sales));

        const today = forecastDays[0];
        hourlyData = today.hour.map(hour => ({
          time: new Date(hour.time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true }),
          weather: simplifyWeather(hour.condition.text),
          temp: hour.temp_c,
          rainChance: hour.chance_of_rain
        }));
        sunriseTime = new Date(today.astro.sunrise).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });
        sunsetTime = new Date(today.astro.sunset).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });

        renderWeatherChart();
        renderSalesChart();
        renderTemperatureChart();
        renderWeatherTable(forecastDays);
        renderSalesTable();
        await sendTelegramNotifications(forecastDays);
        await sendWeatherChangeAlerts(forecastDays);
      } catch (error) {
        console.error('Error fetching weather forecast:', error.message);
        alert('Failed to load weather data. Please try again later.');
      }
    }

    // Render 7-day weather chart
    function renderWeatherChart() {
      const ctx = document.getElementById('weatherChart')?.getContext('2d');
      if (!ctx) return console.error('Weather chart canvas not found');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: weatherLabels,
          datasets: [{ label: 'Temperature (°C)', data: temperatures, backgroundColor: weatherColors, borderWidth: 1 }]
        },
        options: {
          responsive: true,
          scales: {
            y: { beginAtZero: true, title: { display: true, text: 'Temperature (°C)' } },
            x: { title: { display: true, text: 'Day of Week' } }
          }
        }
      });
    }

    // Render sales chart
    function renderSalesChart() {
      const ctx = document.getElementById('salesChart')?.getContext('2d');
      if (!ctx) return console.error('Sales chart canvas not found');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: weatherLabels,
          datasets: [{ label: 'Ice Dessert Sales (kg)', data: salesData, backgroundColor: salesColors, borderWidth: 1 }]
        },
        options: {
          responsive: true,
          scales: {
            y: { beginAtZero: true, max: 10, title: { display: true, text: 'Kilograms (kg)' } },
            x: { title: { display: true, text: 'Day of Week' } }
          }
        }
      });
    }


    // Render temperature chart
    function renderTemperatureChart() {
      const ctx = document.getElementById('temperatureChart')?.getContext('2d');
      if (!ctx) return console.error('Temperature chart canvas not found');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: hourlyData.map(h => h.time),
          datasets: [{
            label: 'Temperature (°C)',
            data: hourlyData.map(h => h.temp),
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
                { type: 'line', xMin: sunriseTime, xMax: sunriseTime, borderColor: 'rgba(255, 255, 0, 0.7)', borderWidth: 2, label: { content: 'Sunrise', enabled: true, position: 'top', color: '#fff' } },
                { type: 'line', xMin: sunsetTime, xMax: sunsetTime, borderColor: 'rgba(255, 165, 0, 0.7)', borderWidth: 2, label: { content: 'Sunset', enabled: true, position: 'top', color: '#fff' } }
              ]
            },
            tooltip: {
              callbacks: {
                label: context => `${context.dataset.label}: ${context.raw}°C`,
                afterLabel: context => `Weather: ${hourlyData[context.dataIndex].weather}\nRain Chance: ${hourlyData[context.dataIndex].rainChance}%`
              }
            }
          }
        }
      });
    }

    // Render daily weather table
    function renderWeatherTable(forecastDays) {
      const tableBody = document.querySelector('#weatherTable tbody');
      if (!tableBody) return console.error('Weather table body not found');
      tableBody.innerHTML = forecastDays.map((day, index) => `
        <tr>
          <td>${day.date}</td>
          <td>${getDayOfWeek(day.date)}</td>
          <td><img src="${weatherImages[weatherData[index]] || 'https://openweathermap.org/img/wn/02d@2x.png'}" alt="${weatherData[index]}" style="width: 30px; height: 30px; vertical-align: middle;"> ${weatherData[index]}</td>
          <td>${temperatures[index]}°C</td>
        </tr>
      `).join('');
    }

    // Render sales table with editable inputs
    function renderSalesTable() {
      const tableBody = document.querySelector('#salesTableBody');
      if (!tableBody) return console.error('Sales table body not found');
      tableBody.innerHTML = `
        <tr><td>Sunny</td><td>High</td><td><input type="number" class="editable-input" data-weather="Sunny" value="${salesAmounts.Sunny}"></td></tr>
        <tr><td>Cloudy</td><td>Medium</td><td><input type="number" class="editable-input" data-weather="Cloudy" value="${salesAmounts.Cloudy}"></td></tr>
        <tr><td>Rainy</td><td>Low</td><td><input type="number" class="editable-input" data-weather="Rainy" value="${salesAmounts.Rainy}"></td></tr>
        <tr><td>Stormy</td><td>Low</td><td><input type="number" class="editable-input" data-weather="Stormy" value="${salesAmounts.Stormy}"></td></tr>
      `;
    }


    // Update sales amounts on button click
    document.getElementById('updateSalesBtn').addEventListener('click', () => {
      const inputs = document.querySelectorAll('.editable-input');
      inputs.forEach(input => {
        const weather = input.getAttribute('data-weather');
        const newValue = parseFloat(input.value) || 0;
        salesAmounts[weather] = newValue;
      });
      localStorage.setItem('salesAmounts', JSON.stringify(salesAmounts));
      salesData = weatherData.map(condition => getIceDessertSales(condition));
      salesColors = salesData.map(sales => getSalesColor(sales));
      renderSalesChart();
      alert('Sales amounts updated successfully!');
    });

    // Send Telegram notifications for sales forecast
    async function sendTelegramNotifications(forecastDays) {
      const today = new Date().toISOString().split('T')[0];
      let message = "🔔 7-Day Ice Dessert Sales Forecast for Tuek Thla, Phnom Penh 🔔\n\n";

      const todayForecast = forecastDays.find(day => day.date === today);
      if (todayForecast) {
        const weather = simplifyWeather(todayForecast.day.condition.text);
        const dayOfWeek = getDayOfWeek(todayForecast.date);
        const sales = getIceDessertSales(weather);
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
        const weather = simplifyWeather(day.day.condition.text);
        const dayOfWeek = getDayOfWeek(day.date);
        const sales = getIceDessertSales(weather);
        return `${dayOfWeek}, ${day.date}: ${weather} - Sell ${sales}kg`;
      }).join('\n');

      console.log('Sending Telegram sales forecast:', message);
      await sendToTelegram(message);
    }

    // Send weather change alerts (Telegram, Bootstrap modal, and in-app notification)
    async function sendWeatherChangeAlerts(forecastDays) {
      let telegramMessage = "🌦 Weather Change Alerts for Tuek Thla, Phnom Penh 🌦\n\n";
      let modalContent = "";
      let hasChanges = false;

      for (let i = 1; i < forecastDays.length; i++) {
        const prevWeather = simplifyWeather(forecastDays[i - 1].day.condition.text);
        const currWeather = simplifyWeather(forecastDays[i].day.condition.text);
        if (prevWeather !== currWeather) {
          const prevDay = getDayOfWeek(forecastDays[i - 1].date);
          const currDay = getDayOfWeek(forecastDays[i].date);
          const changeText = `${prevDay}, ${forecastDays[i - 1].date}: ${prevWeather} ➡️ ${currDay}, ${forecastDays[i].date}: ${currWeather}`;
          
          // Telegram message
          telegramMessage += `⚠️ Weather change detected:\n${changeText}\n`;
          
          // Modal content
          modalContent += `<p>${changeText}</p>`;
          
          // In-app notification
          showInAppNotification(`Weather Change: ${changeText}`);
          
          hasChanges = true;
        }
      }

      if (hasChanges) {
        // Send Telegram alert
        console.log('Sending Telegram weather change alerts:', telegramMessage);
        await sendToTelegram(telegramMessage);

        // Show Bootstrap modal
        showWeatherChangeModal(modalContent);
      } else {
        console.log('No weather changes detected.');
        showInAppNotification('No weather changes detected in the next 7 days.');
        showWeatherChangeModal('<p>No weather changes detected in the next 7 days.</p>');
      }
    }
    // Send message to Telegram
    async function sendToTelegram(message) {
      const url = `https://api.telegram.org/bot${TELEGRAM_BOT_TOKEN}/sendMessage`;
      try {
        const response = await fetch(url, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ chat_id: TELEGRAM_CHAT_ID, text: message })
        });
        const result = await response.json();
        if (!result.ok) throw new Error(`Telegram API error: ${result.description}`);
        console.log('Telegram message sent successfully!');
      } catch (error) {
        console.error('Error sending to Telegram:', error.message);
      }
    }

    // Show in-app notification
    function showInAppNotification(message) {
      const container = document.getElementById('notification-container');
      const notification = document.createElement('div');
      notification.className = 'notification';
      notification.textContent = message;
      container.appendChild(notification);
      setTimeout(() => notification.remove(), 5000);
    }

    // Show Bootstrap modal with weather change content
    function showWeatherChangeModal(content) {
      const modalBody = document.getElementById('weatherChangeModalBody');
      modalBody.innerHTML = content;
      const modal = new bootstrap.Modal(document.getElementById('weatherChangeModal'), {});
      modal.show();
    }

    // Map weather condition to sales amount
    function getIceDessertSales(condition) {
      return salesAmounts[condition] || 3;
    }
    // Get color for sales bars
    function getSalesColor(sales) {
      return sales >= 5 ? "#28a745" : sales >= 3 ? "#ff9800" : "#dc3545";
    }

    // Get color for weather bars
    function getWeatherColor(condition) {
      return { "Sunny": "#FFD700", "Cloudy": "#B0C4DE", "Rainy": "#4682B4", "Stormy": "#708090" }[condition] || "#D3D3D3";
    }

    // Simplify weather condition text
    function simplifyWeather(condition) {
      condition = condition.toLowerCase();
      if (["sunny", "clear"].some(w => condition.includes(w))) return "Sunny";
      if (["cloudy", "overcast"].some(w => condition.includes(w))) return "Cloudy";
      if (["rain", "shower"].some(w => condition.includes(w))) return "Rainy";
      if (["storm", "thunder"].some(w => condition.includes(w))) return "Stormy";
      return condition.charAt(0).toUpperCase() + condition.slice(1);
    }

    // Get day of week from date string
    function getDayOfWeek(dateString) {
      const date = new Date(dateString);
      return ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][date.getDay()];
    }
    // Initialize on page load
    window.onload = fetchWeatherForecast;
  </script>

