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
        <h6>Ice Dessert Sales by Weather</h6>
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
          </tr>
        </thead>
        <tbody>
          <tr><td>Sunny</td><td>High</td></tr>
          <tr><td>Cloudy</td><td>Medium</td></tr>
          <tr><td>Rainy</td><td>Low</td></tr>
          <tr><td>Stormy</td><td>Low</td></tr>
        </tbody>
      </table>
    </div>
  </div>
  <script>
    let weatherData = [], weatherLabels = [], temperatures = [], weatherColors = [], salesData = [], salesColors = [];
    
    async function fetchWeatherForecast() {
      const apiKey = 'fedd86317b25465cafa220110250403';
      const city = 'Phnom Penh';
      const forecastUrl = `https://api.weatherapi.com/v1/forecast.json?key=${apiKey}&q=${city}&days=7`;
      
      try {
        const response = await fetch(forecastUrl);
        const data = await response.json();
        if (data && data.forecast && data.forecast.forecastday) {
          const forecastDays = data.forecast.forecastday;
          weatherData = forecastDays.map(day => day.day.condition.text);
          weatherLabels = forecastDays.map(day => day.date);
          temperatures = forecastDays.map(day => day.day.avgtemp_c);
          salesData = weatherData.map(condition => getIceDessertSales(condition));
          
          weatherColors = weatherData.map(condition => getWeatherColor(condition));
          salesColors = salesData.map(sales => getSalesColor(sales));

          renderWeatherChart();
          renderSalesChart();
          renderWeatherTable(forecastDays);
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
          scales: {
            y: {
              beginAtZero: true
            }
          }
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
            label: 'Ice Dessert Sales',
            data: salesData,
            backgroundColor: salesColors,
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
    
    function renderWeatherTable(forecastDays) {
      const tableBody = document.querySelector('#weatherTable tbody');
      tableBody.innerHTML = '';
      forecastDays.forEach((day, index) => {
        const row = `<tr>
          <td>${day.date}</td>
          <td>${getDayOfWeek(day.date)}</td>
          <td>${day.day.condition.text}</td>
          <td>${temperatures[index]}°C</td>
        </tr>`;
        tableBody.innerHTML += row;
      });
    }
    
    function getIceDessertSales(condition) {
      const salesMapping = {
        "Sunny": 800,
        "Cloudy": 600,
        "Rainy": 300,
        "Stormy": 200
      };
      return salesMapping[condition] || 500;
    }

    function getSalesColor(sales) {
      if (sales >= 700) return "#28a745"; // Green for high sales
      if (sales >= 500) return "#ff9800"; // Orange for medium sales
      return "#dc3545"; // Red for low sales
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
    
    function getDayOfWeek(dateString) {
      const date = new Date(dateString);
      return ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][date.getDay()];
    }
    window.onload = fetchWeatherForecast;
  </script>
</div>
