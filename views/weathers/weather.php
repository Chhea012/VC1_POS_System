<div class="container-xxl flex-grow-1 container-p-y">
<h1>Welcome to weather </h1>

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
    <h1>Weather Forecast</h1>
    <canvas id="weatherChart" width="800" height="400"></canvas>
    <div id="hoverTitle"></div>
  </div>

  <script>
    // Global variables for weather data
    let temperatures = [];
    let dates = [];
    let weekdays = [];
    let colors = [];

    // Function to fetch weather forecast data from WeatherAPI
    async function fetchWeatherForecast() {
      const apiKey = 'fedd86317b25465cafa220110250403'; // Replace with your actual WeatherAPI key
      const city = 'Phnom Penh'; // City for which forecast is to be displayed
      const forecastUrl = `https://api.weatherapi.com/v1/forecast.json?key=${apiKey}&q=${city}&days=7`;  // Fetch 7 days forecast

      try {
        // Fetching forecast data from API
        const response = await fetch(forecastUrl);
        const data = await response.json();

        // Ensure the data contains forecast information
        if (data && data.forecast && data.forecast.forecastday) {
          const forecastDays = data.forecast.forecastday;
          temperatures = forecastDays.map(day => day.day.avgtemp_c);
          dates = forecastDays.map(day => day.date);

          // Get weekdays (Monday, Tuesday, etc.)
          weekdays = forecastDays.map(day => getDayOfWeek(day.date));

          // Assign colors based on temperature ranges
          colors = temperatures.map(temp => {
            if (temp > 30) return '#4CAF50';   // Green for hot temperatures
            if (temp < 15) return '#F44336';   // Red for cool temperatures
            return '#FF9800';                  // Orange for medium temperatures
          });

          // Call the function to render the graph with the fetched data
          renderWeatherChart();
        } else {
          console.error('Forecast data is unavailable');
        }
      } catch (error) {
        console.error('Error fetching weather forecast:', error);
      }
    }

    // Function to render the weather forecast chart using Chart.js
    function renderWeatherChart() {
      const ctx = document.getElementById('weatherChart').getContext('2d');

      // Create a new chart instance
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: weekdays, // Weekdays (e.g., Monday, Tuesday, etc.)
          datasets: [{
            label: 'Temperature (°C)',
            data: temperatures,
            backgroundColor: colors,
            borderColor: colors.map(color => darkenColor(color, 0.2)), // Darken the color for borders
            borderWidth: 1,
            hoverBackgroundColor: colors, // Hover effect with the same color
            hoverBorderColor: colors.map(color => darkenColor(color, 0.3)),
            barPercentage: 0.7
          }]
        },
        options: {
          responsive: true,
          plugins: {
            tooltip: {
              callbacks: {
                label: function(context) {
                  const salesCondition = getSalesCondition(colors[context.dataIndex]);
                  return `${salesCondition} - ${context.raw}°C`;
                }
              }
            }
          },
          scales: {
            x: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Days of the Week'
              }
            },
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Temperature (°C)'
              }
            }
          },
          animation: {
            duration: 1000, // 1 second animation
            easing: 'easeInOutQuart'
          }
        }
      });
    }

    // Function to determine the sales condition based on temperature color
    function getSalesCondition(color) {
      if (color === '#4CAF50') return 'Sell a lot';  // Green: Hot, sell a lot
      if (color === '#FF9800') return 'Sell medium';  // Orange: Medium, sell medium
      return 'Cannot sell';  // Red: Cool, cannot sell
    }

    // Function to get the day of the week from the date (e.g., Monday, Tuesday)
    function getDayOfWeek(dateString) {
      const date = new Date(dateString);
      const weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
      return weekdays[date.getDay()];
    }

    // Function to darken the color for borders and hover effect
    function darkenColor(hex, percent) {
      const color = hex.substring(1); // Remove '#' from color code
      const R = parseInt(color.substring(0, 2), 16);
      const G = parseInt(color.substring(2, 4), 16);
      const B = parseInt(color.substring(4, 6), 16);
      const t = percent < 0 ? 0 : 255;
      const p = percent < 0 ? percent * -1 : percent;
      return '#' + (0x1000000 + (Math.round((t - R) * p + R) << 16) + (Math.round((t - G) * p + G) << 8) + Math.round((t - B) * p + B)).toString(16).slice(1);
    }

    // Fetch and render the weather forecast data when the page loads
    window.onload = fetchWeatherForecast;
  </script>
</div>

