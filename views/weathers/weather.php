<div class="container-xxl flex-grow-1 container-p-y">

  <div id="weatherapi-weather-widget-3">
  </div>
  <script type='text/javascript' src='https://www.weatherapi.com/weather/widget.ashx?loc=1318546&wid=3&tu=1&div=weatherapi-weather-widget-3' async>

  </script>
  <noscript>
    <a href="https://www.weatherapi.com/weather/q/phnum-penh-1318546" alt="Hour by hour Phnum Penh weather">10 day hour by hour Phnum Penh weather</a>
  </noscript>
</div>

<div class="container-xxl flex-grow-1 container-p-y">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <div class="container">
    <div class="container chart">
      <div class="chart-container">
        <h6>7-Day Weather Forecast</h6>
        <canvas id="weatherChart" width="550" height="400"></canvas>
      </div>
      <div class="chart-container">
        <h6>Ice Dessert Sales by Weather (kg)</h6>
        <canvas id="salesChart" width="550" height="400"></canvas>
      </div>
    </div>
    <div class="table-container p-3 bg-white mt-4">
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
    <div class="table-container p-3 bg-white mt-4">
      <table id="salesTable" border="1" class="table table-striped table-bordered table-hover text-center">
        <thead class="table-dark">
          <tr>
            <th>Weather</th>
            <th>Sales Category</th>
            <th>Amount to Sell</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>Sunny</td><td>High</td><td>5kg</td></tr>
          <tr><td>Cloudy</td><td>Medium</td><td>3kg</td></tr>
          <tr><td>Rainy</td><td>Low</td><td>1kg</td></tr>
          <tr><td>Stormy</td><td>Low</td><td>1kg</td></tr>
        </tbody>
      </table>
    </div>
  </div>
  <script>
    let weatherData = [], weatherLabels = [], temperatures = [], weatherColors = [], salesData = [], salesColors = [];
    const apiKey = 'fedd86317b25465cafa220110250403';
    const city = 'Phnom Penh';
    const telegramBotToken = '7712638261:AAHYtki-eOGTcD60HZVtgpJ6M6-POb1C5vk';
    const telegramChatId = '7160406338'; // Replace with your real chat ID!!!

    async function fetchWeatherForecast() {
      const forecastUrl = `https://api.weatherapi.com/v1/forecast.json?key=${apiKey}&q=${city}&days=7`;
      try {
        const response = await fetch(forecastUrl);
        if (!response.ok) throw new Error('Weather API request failed');
        const data = await response.json();
        if (data && data.forecast && data.forecast.forecastday) {
          const forecastDays = data.forecast.forecastday;
          weatherData = forecastDays.map(day => simplifyWeather(day.day.condition.text));
          weatherLabels = forecastDays.map(day => day.date);
          temperatures = forecastDays.map(day => day.day.avgtemp_c);
          salesData = weatherData.map(condition => getIceDessertSales(condition));

          weatherColors = weatherData.map(condition => getWeatherColor(condition));
          salesColors = salesData.map(sales => getSalesColor(sales));

          renderWeatherChart();
          renderSalesChart();
          renderWeatherTable(forecastDays);
          await sendTelegramNotifications(forecastDays);
        } else {
          console.error('Forecast data is unavailable');
        }
      } catch (error) {
        console.error('Error fetching weather forecast:', error);
      }
    }

    function renderWeatherChart() {
      const ctx = document.getElementById('weatherChart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: weatherLabels,
          datasets: [{
            label: 'Temperature (°C)',
            data: temperatures,
            backgroundColor: weatherColors,
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: { y: { beginAtZero: true } }
        }
      });
    }

    function renderSalesChart() {
      const ctx = document.getElementById('salesChart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: weatherLabels,
          datasets: [{
            label: 'Ice Dessert Sales (kg)',
            data: salesData,
            backgroundColor: salesColors,
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: { y: { beginAtZero: true, max: 6, title: { display: true, text: 'Kilograms (kg)' } } }
        }
      });
    }

    function renderWeatherTable(forecastDays) {
      const tableBody = document.querySelector('#weatherTable tbody');
      tableBody.innerHTML = '';
      forecastDays.forEach((day, index) => {
        const row = `<tr>
          <td>${day.date}</td>
          <td>${getDayOfWeek(day.date)}</td>
          <td>${simplifyWeather(day.day.condition.text)}</td>
          <td>${temperatures[index]}°C</td>
        </tr>`;
        tableBody.innerHTML += row;
      });
    }

    async function sendTelegramNotifications(forecastDays) {
      const today = new Date().toISOString().split('T')[0];
      let message = "🔔 7-Day Ice Dessert Sales Forecast for Phnom Penh 🔔\n\n";

      const todayForecast = forecastDays.find(day => day.date === today);
      if (todayForecast) {
        const weather = simplifyWeather(todayForecast.day.condition.text);
        const dayOfWeek = getDayOfWeek(todayForecast.date);
        const sales = getIceDessertSales(weather);
        const temp = todayForecast.day.avgtemp_c;

        message += `📅 Today (${dayOfWeek}, ${todayForecast.date}):\n`;
        message += `Weather: ${weather} | Temp: ${temp}°C\n`;
        if (weather === "Sunny") {
          message += "☀️ Hot day! Sell 5kg of ice dessert for HIGH sales!\n";
        } else if (weather === "Cloudy") {
          message += "☁️ Moderate day. Sell 3kg of ice dessert for MEDIUM sales.\n";
        } else if (weather === "Rainy" || weather === "Stormy") {
          message += "🌧️ Wet day. Sell 1kg of ice dessert for LOW sales.\n";
        } else {
          message += "🛒 Normal day. Sell 3kg of ice dessert.\n";
        }
        message += "\n";
      }

      message += "📋 7-Day Forecast:\n";
      forecastDays.forEach(day => {
        const weather = simplifyWeather(day.day.condition.text);
        const dayOfWeek = getDayOfWeek(day.date);
        const sales = getIceDessertSales(weather);
        message += `${dayOfWeek}, ${day.date}: ${weather} - Sell ${sales}kg\n`;
      });

      console.log('Sending Telegram message:', message);
      await sendToTelegram(message);
    }

    async function sendToTelegram(message) {
      const url = `https://api.telegram.org/bot${telegramBotToken}/sendMessage`;
      try {
        const response = await fetch(url, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            chat_id: telegramChatId,
            text: message
          })
        });
        const result = await response.json();
        if (!result.ok) console.error('Failed to send Telegram message:', result);
        else console.log('Telegram message sent successfully!');
      } catch (error) {
        console.error('Error sending to Telegram:', error);
      }
    }

    function getIceDessertSales(condition) {
      const salesMapping = {
        "Sunny": 5,
        "Cloudy": 3,
        "Rainy": 1,
        "Stormy": 1
      };
      return salesMapping[condition] || 3;
    }

    function getSalesColor(sales) {
      if (sales >= 5) return "#28a745";
      if (sales >= 3) return "#ff9800";
      return "#dc3545";
    }

    function getWeatherColor(condition) {
      const colorMapping = {
        "Sunny": "#FFD700",
        "Cloudy": "#B0C4DE",
        "Rainy": "#4682B4",
        "Stormy": "#708090"
      };
      return colorMapping[condition] || "#D3D3D3";
    }

    function simplifyWeather(condition) {
      if (condition.includes("Sunny") || condition.includes("Clear")) return "Sunny";
      if (condition.includes("Cloudy") || condition.includes("Overcast")) return "Cloudy";
      if (condition.includes("Rain") || condition.includes("Shower")) return "Rainy";
      if (condition.includes("Storm") || condition.includes("Thunder")) return "Stormy";
      return condition;
    }

    function getDayOfWeek(dateString) {
      const date = new Date(dateString);
      return ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][date.getDay()];
    }

    window.onload = fetchWeatherForecast;
  </script>
</div>