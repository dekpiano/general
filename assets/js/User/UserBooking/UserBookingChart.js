let pieChart, barChart, lineChart, PieApprove;

function renderCharts() {
    const chartHeight = 200;

    const pieOptions = {
        chart: { type: 'pie',height: chartHeight },
        series: [],
        labels: [],
        responsive: [{
            breakpoint: 480,
            options: {
              chart: {
                width: 400
              },
              legend: {
                position: 'bottom'
              }
            }
          }]
    };
    pieChart = new ApexCharts(document.querySelector("#pie-chart"), pieOptions);
    pieChart.render();

    const barOptions = {
        chart: { type: 'bar' ,height: chartHeight},
        series: [{
            name: 'จำนวนครั้งที่จอง',
            data: []
        }],
        xaxis: {
            categories: []
        }
    };
    barChart = new ApexCharts(document.querySelector("#bar-chart"), barOptions);
    barChart.render();

    const PieOptApprove = {
        chart: { type: 'donut',height: chartHeight },
        series: [],
        labels: []
    };
    PieApprove = new ApexCharts(document.querySelector("#chart-Approve"), PieOptApprove);
    PieApprove.render();

    updateCharts();
}

function updateCharts() {
    fetch(`${BASE_URL}Booking/DB/BookingChart`)
        .then(res => res.json())
        .then(data => {
            console.log(data);

            pieChart.updateOptions({
                labels: data.pie.labels,
                series: data.pie.series
            });

            barChart.updateOptions({
                xaxis: { categories: data.bar.categories },
                series: [{ name: 'จำนวนครั้งที่จอง', data: data.bar.series }]
            });

            PieApprove.updateOptions({
                labels: data.Approve.labels,
                series: data.Approve.series
            });
        })
        .catch(error => console.error('Error loading chart data:', error));
}

renderCharts();

