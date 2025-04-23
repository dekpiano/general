
fetch('../Repair/DB/StatisticsCaselist')
.then(response => response.json())
.then(data => {
    console.log(data.Bar); // Log the data to check its structure
    
    const BarCategories = data.Bar.map(item => item.repair_caselist);
    const BarSeriesData = data.Bar.map(item => parseInt(item.total));

    const PieCategories = data.Pie.map(item => item.repair_status);
    const PieSeriesData = data.Pie.map(item => parseInt(item.total));
   
    var optionsBar = { // Renamed to optionsBar
        chart: { type: 'bar' },
        series: [{
            name: 'จำนวนงาน',
            data: BarSeriesData
        }],
        xaxis: {
            categories: BarCategories
        },
        title: { text: 'จำนวนงานซ่อมแต่ละประเภท' }
    };
  
    new ApexCharts(document.querySelector("#chart-type"), optionsBar).render();

    var optionsDonut = { // Renamed to optionsDonut
    chart: { type: 'donut' },
    series: PieSeriesData,
    labels: PieCategories,
    title: { text: 'สถานะงานซ่อม' }
    };

    new ApexCharts(document.querySelector("#chart-status"), optionsDonut).render();
})
.catch(error => console.error('Error loading chart data:', error));

