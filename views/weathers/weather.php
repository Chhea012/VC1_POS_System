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

<!-- Weather Forecast and Sales Dashboard -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@2.2.1/dist/chartjs-plugin-annotation.min.js"></script>
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="container chart">
    <div class="chart-container one">
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
  <div class="table-container p-3 bg-white ">
    <h6>Today's Hourly Weather Forecast</h6>
    <table id="hourlyWeatherTable" border="1" class="table table-striped table-bordered table-hover text-center">
      <thead class="table-dark">
        <tr>
          <th>Time (Local)</th>
          <th>Weather</th>
          <th>Temperature (°C)</th>
          <th>Chance of Rain (%)</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="table-container p-3 bg-white ">
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
  <div class="table-container p-3 bg-white ">
    <table id="salesTable" border="1" class="table table-striped table-bordered table-hover text-center">
      <thead class="table-dark">
        <tr>
          <th>Weather</th>
          <th>Sales Category</th>
          <th>Amount to Sell</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Sunny</td>
          <td>High</td>
          <td>5kg</td>
        </tr>
        <tr>
          <td>Cloudy</td>
          <td>Medium</td>
          <td>3kg</td>
        </tr>
        <tr>
          <td>Rainy</td>
          <td>Low</td>
          <td>1kg</td>
        </tr>
        <tr>
          <td>Stormy</td>
          <td>Low</td>
          <td>1kg</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
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

  // Constants
  const API_KEY = 'fedd86317b25465cafa220110250403';
  const CITY = 'Tuek Thla, Phnom Penh, Cambodia';
  const TELEGRAM_BOT_TOKEN = '7712638261:AAHYtki-eOGTcD60HZVtgpJ6M6-POb1C5vk';
  const TELEGRAM_CHAT_ID = '7160406338'; // Replace with your real chat ID


  // Weather image mapping (using OpenWeatherMap icons)
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
      weatherLabels = forecastDays.map(day => day.date);
      temperatures = forecastDays.map(day => day.day.avgtemp_c);
      salesData = weatherData.map(condition => getIceDessertSales(condition));
      weatherColors = weatherData.map(condition => getWeatherColor(condition));
      salesColors = salesData.map(sales => getSalesColor(sales));

      // Extract today's hourly data and sunrise/sunset
      const today = forecastDays[0];
      hourlyData = today.hour.map(hour => ({
        time: new Date(hour.time).toLocaleTimeString([], {
          hour: '2-digit',
          minute: '2-digit',
          hour12: true
        }),
        weather: simplifyWeather(hour.condition.text),
        temp: hour.temp_c,
        rainChance: hour.chance_of_rain
      }));
      sunriseTime = new Date(today.astro.sunrise).toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
      });
      sunsetTime = new Date(today.astro.sunset).toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
      });

      renderWeatherChart();
      renderSalesChart();
      renderTemperatureChart();
      renderHourlyWeatherTable();
      renderWeatherTable(forecastDays);
      await sendTelegramNotifications(forecastDays);
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
        datasets: [{
          label: 'Temperature (°C)',
          data: temperatures,
          backgroundColor: weatherColors,
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
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
        datasets: [{
          label: 'Ice Dessert Sales (kg)',
          data: salesData,
          backgroundColor: salesColors,
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            max: 6,
            title: {
              display: true,
              text: 'Kilograms (kg)'
            }
          }
        }
      }
    });
  }

  // Render temperature chart with hourly data
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
          x: {
            title: {
              display: true,
              text: 'Time',
              color: '#fff'
            },
            ticks: {
              color: '#fff'
            }
          },
          y: {
            title: {
              display: true,
              text: 'Temperature (°C)',
              color: '#fff'
            },
            beginAtZero: false,
            ticks: {
              color: '#fff'
            }
          }
        },
        plugins: {
          legend: {
            labels: {
              color: '#fff'
            }
          },
          annotation: {
            annotations: [{
              type: 'line',
              xMin: sunriseTime,
              xMax: sunriseTime,
              borderColor: 'rgba(255, 255, 0, 0.7)',
              borderWidth: 2,
              label: {
                content: 'Sunrise',
                enabled: true,
                position: 'top',
                color: '#fff'
              }
            }, {
              type: 'line',
              xMin: sunsetTime,
              xMax: sunsetTime,
              borderColor: 'rgba(255, 165, 0, 0.7)',
              borderWidth: 2,
              label: {
                content: 'Sunset',
                enabled: true,
                position: 'top',
                color: '#fff'
              }
            }]
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                const index = context.dataIndex;
                return `${context.dataset.label}: ${context.raw}°C`;
              },
              afterLabel: function(context) {
                const index = context.dataIndex;
                return `Weather: ${hourlyData[index].weather}\nRain Chance: ${hourlyData[index].rainChance}%`;
              }
            }
          }
        }
      }
    });
  }

  // Render hourly weather table for today
  function renderHourlyWeatherTable() {
    const tableBody = document.querySelector('#hourlyWeatherTable tbody');
    if (!tableBody) return console.error('Hourly weather table body not found');
    tableBody.innerHTML = hourlyData.map(hour => `
        <tr>
          <td>${hour.time}</td>
          <td><img src="${weatherImages[hour.weather] || 'https://openweathermap.org/img/wn/02d@2x.png'}" alt="${hour.weather}" style="width: 30px; height: 30px; vertical-align: middle;"> ${hour.weather}</td>
          <td>${hour.temp}°C</td>
          <td>${hour.rainChance}%</td>
        </tr>
      `).join('');
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

  // Send Telegram notifications
  async function sendTelegramNotifications(forecastDays) {
    const today = new Date().toISOString().split('T')[0];
    let message = "🔔 7-Day Ice Dessert Sales Forecast for Tuek Thla, Phnum Penh 🔔\n\n";


    const todayForecast = forecastDays.find(day => day.date === today);
    if (todayForecast) {
      const weather = simplifyWeather(todayForecast.day.condition.text);
      const dayOfWeek = getDayOfWeek(todayForecast.date);
      const sales = getIceDessertSales(weather);
      const temp = todayForecast.day.avgtemp_c;

      message += `📅 Today (${dayOfWeek}, ${todayForecast.date}):\n`;
      message += `Weather: ${weather} | Temp: ${temp}°C\n`;
      message += weather === "Sunny" ? "☀️ Hot day! Sell 5kg of ice dessert for HIGH sales!\n" :
        weather === "Cloudy" ? "☁️ Moderate day. Sell 3kg of ice dessert for MEDIUM sales.\n" :
        (weather === "Rainy" || weather === "Stormy") ? "🌧 Wet day. Sell 1kg of ice dessert for LOW sales.\n" :
        "🛒 Normal day. Sell 3kg of ice dessert.\n";
      message += "\n";
    }

    message += "📋 7-Day Forecast:\n";
    message += forecastDays.map(day => {
      const weather = simplifyWeather(day.day.condition.text);
      const dayOfWeek = getDayOfWeek(day.date);
      const sales = getIceDessertSales(weather);
      return `${dayOfWeek}, ${day.date}: ${weather} - Sell ${sales}kg`;
    }).join('\n');

    console.log('Sending Telegram message:', message);
    await sendToTelegram(message);
  }

  // Send message to Telegram
  async function sendToTelegram(message) {
    const url = `https://api.telegram.org/bot${TELEGRAM_BOT_TOKEN}/sendMessage`;
    try {
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          chat_id: TELEGRAM_CHAT_ID,
          text: message
        })
      });
      const result = await response.json();
      if (!result.ok) throw new Error(`Telegram API error: ${result.description}`);
      console.log('Telegram message sent successfully!');
    } catch (error) {
      console.error('Error sending to Telegram:', error.message);
    }
  }

  // Map weather condition to sales amount
  function getIceDessertSales(condition) {
    return {
      "Sunny": 5,
      "Cloudy": 3,
      "Rainy": 1,
      "Stormy": 1
    } [condition] || 3;
  }

  // Get color for sales bars
  function getSalesColor(sales) {
    return sales >= 5 ? "#28a745" : sales >= 3 ? "#ff9800" : "#dc3545";
  }

  // Get color for weather bars
  function getWeatherColor(condition) {
    return {
      "Sunny": "#FFD700",
      "Cloudy": "#B0C4DE",
      "Rainy": "#4682B4",
      "Stormy": "#708090"
    } [condition] || "#D3D3D3";
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
</div>
