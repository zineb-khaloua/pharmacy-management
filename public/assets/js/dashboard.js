
function fetchLowStockMedicaments() {
    $.ajax({
        url: baseUrl + '/low-stock-medicaments', 
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            const notificationContainer = $('#low-stock-notification');
            notificationContainer.empty(); 
            
            if (data.length > 0) {
                let notificationHTML = `
                    <div class="alert alert-warning">
                        <strong>Warning ! </strong> Some medications have low stock:
                        <ul>`;
                       
                data.forEach(function(medicament) {
                    notificationHTML += `<li>${medicament.name} - Only  <strong> ${medicament.quantity_in_stock} </strong> left in stock </li>`;
                });

                notificationHTML += `</ul></div>`;
                notificationContainer.html(notificationHTML);
            }
        },
        error: function() {
            console.error("Erreur lors de la récupération des stocks faibles.");
        }
    });
}


setInterval(fetchLowStockMedicaments, 1000); 
fetchLowStockMedicaments(); 

//****************************/


document.addEventListener("DOMContentLoaded", function () {
let selectedDate = document.getElementById('datePicker'); 
let selectedYear= document.getElementById('yearContainer');
let selectedPeriod = 'day';
let selectedCurrentDate = selectedDate.value || new Date().toISOString().split('T')[0];

updateChart(selectedPeriod, selectedCurrentDate);



document.getElementById('datePicker').addEventListener('change', function () {
    selectedDate = this.value;
    updateChart(selectedPeriod, selectedDate);
});

document.getElementById('periodSelector').addEventListener('change', function () {
    selectedPeriod = this.value;
    let selectedYear = document.getElementById("yearContainer");
    let selectedMonth = document.getElementById("monthContainer");
    let selectedWeek = document.getElementById("weekContainer");
    let selectedDay = document.getElementById("dayContainer");

 

    selectedYear.style.display='none';
    selectedMonth.style.display='none';
    selectedWeek.style.display='none';
    selectedDay.style.display='none';

    if (selectedPeriod === "year") {
    
      selectedYear.style.display='block';

      selectedYear.innerHTML = `
            <select class="form-control mt-4" id="yearInput">
                ${generateYearOptions()}
            </select>`;
      
      document.getElementById('yearInput').addEventListener('change', function () {
            selectedDate = this.value; 
            updateChart(selectedPeriod, selectedDate);
      });
    } else if (selectedPeriod === "month") {
       selectedMonth.style.display='block';
      selectedMonth.innerHTML = `
          <input type="date" value="<?= date('Y-m-d') ?>" class="form-control mt-4" id="monthInput">`
          ;
      document.getElementById('monthInput').addEventListener('change', function () {
            selectedDate = this.value;
            updateChart(selectedPeriod, selectedDate);
        });
  }

  else if (selectedPeriod === "week") {
    selectedWeek.style.display='block';
    selectedWeek.innerHTML = `
          <input type="date"  value="<?= date('Y-m-d') ?>" class="form-control mt-4" id="weekInput">`
          ;
       
   document.getElementById('weekInput').addEventListener('change', function () {

   let selectedDate = this.value; 
    updateChart(selectedPeriod, selectedDate);
        });
  }
 else if (selectedPeriod === "day") {
  selectedDay.style.display='block';
  selectedDay.innerHTML = `
          <input type="date"  value="<?= date('Y-m-d') ?>" class="form-control mt-4" id="dayInput">`
          ;
      document.getElementById('dayInput').addEventListener('change', function () {
            selectedDate = this.value; 
            updateChart(selectedPeriod, selectedDate);
        });
  }

});
});

function updateChart(selectedPeriod, selectedDate) {
var ctx = document.getElementById('salesChart').getContext('2d');

fetch(`${baseUrl}/statisticsSale/${selectedPeriod}/${selectedDate}`)
    .then(response => response.json())
    .then(data => {
        console.log("Fetched Data:", data);

        if (!Array.isArray(data)) {
            data = [data]; 
        }

        let labels = [];
        let salesData = [];
        let revenueData = [];

        if (selectedPeriod === "year") {
            labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            salesData = new Array(12).fill(0);
            revenueData = new Array(12).fill(0);

            data.forEach(item => {
                let monthIndex = item.month - 1;
                salesData[monthIndex] = item.total_sales;
                revenueData[monthIndex] = item.total_revenue;
            });

        } else if (selectedPeriod === "month") {
            let daysInMonth = new Date(selectedDate.split('-')[0], selectedDate.split('-')[1], 0).getDate();
            labels = Array.from({ length: daysInMonth }, (_, i) => (i + 1).toString());
            salesData = new Array(daysInMonth).fill(0);
            revenueData = new Array(daysInMonth).fill(0);

            data.forEach(item => {
                let dayIndex = item.day - 1;
                salesData[dayIndex] = item.total_sales;
                revenueData[dayIndex] = item.total_revenue;
            });

        } else if (selectedPeriod === "week") {
            labels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            salesData = new Array(7).fill(0);
            revenueData = new Array(7).fill(0);

            data.forEach(item => {
                let dayIndex = item.week_day - 1; 
                salesData[dayIndex] = item.total_sales;
                revenueData[dayIndex] = item.total_revenue;
            });

        } else if (selectedPeriod === "day") {
            
            labels = Array.from({ length: 24 }, (_, i) => `${String(i).padStart(2, '0')}:00`);
            salesData = new Array(24).fill(0);
            revenueData = new Array(24).fill(0);

            data.forEach(item => {
                let hourIndex = item.hour;
                salesData[hourIndex] = item.total_sales;
                revenueData[hourIndex] = item.total_revenue;
            });
        }

         if (window.salesChart && typeof window.salesChart.destroy === 'function') {
            window.salesChart.destroy();
        }

      
        window.salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Sales',
                        data: salesData,
                        borderColor: 'blue',
                        fill: false
                    },
                    {
                        label: 'Revenue',
                        data: revenueData,
                        borderColor: 'green',
                        fill: false
                    }
                ]
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
    })
    .catch(error => console.error('Error fetching data:', error));
}


function generateYearOptions() {
  let currentYear = new Date().getFullYear();
  let options = '';
  for (let i = currentYear - 5; i <= currentYear; i++) {
      options += `<option value="${i}">${i}</option>`;
  }
  return options;
}

function generateMonthOptions() {
  const months = ["January", "February", "March", "April", "May", "June", 
                  "July", "August", "September", "October", "November", "December"];
  return months.map((month, index) => `<option value="${index + 1}">${month}</option>`).join('');
}