
// Fetch Chart Data
fetch(BASE_URL + 'Repair/DB/StatisticsCaselist')
.then(response => response.json())
.then(data => {
    // Bar Chart (By Case List)
    if (data.Bar && Array.isArray(data.Bar)) {
        const categories = data.Bar.map(item => item.repair_caselist);
        const seriesData = data.Bar.map(item => parseInt(item.total));
        
        var optionsBar = {
            chart: { 
                type: 'bar',
                height: 350,
                fontFamily: 'Prompt'
            },
            series: [{
                name: 'จำนวนงาน',
                data: seriesData
            }],
            xaxis: {
                categories: categories
            },
            colors: ['#696cff'],
            title: { 
                text: 'จำนวนงานซ่อมแต่ละประเภท',
                align: 'left',
                style: { fontSize: '16px', fontFamily: 'Prompt' }
            },
            plotOptions: {
                bar: { borderRadius: 4, horizontal: false, columnWidth: '55%' }
            }
        };
        new ApexCharts(document.querySelector("#chart-type"), optionsBar).render();
    }

    // Donut Chart (By Status)
    if (data.Pie && Array.isArray(data.Pie)) {
        const statuses = data.Pie.map(item => item.repair_status || 'ไม่ระบุ');
        const statusCounts = data.Pie.map(item => parseInt(item.total));
        
        var optionsPie = {
            chart: { 
                type: 'donut',
                height: 350,
                fontFamily: 'Prompt' 
            },
            series: statusCounts,
            labels: statuses,
            colors: ['#ffab00', '#03c3ec', '#71dd37', '#ff3e1d'], // Warning, Info, Success, Danger
            title: { 
                text: 'สถานะงานซ่อม',
                align: 'left',
                style: { fontSize: '16px', fontFamily: 'Prompt' }
            },
            plotOptions: {
                pie: { donut: { labels: { show: true, total: { show: true, label: 'ทั้งหมด', fontSize: '20px' } } } }
            }
        };
        new ApexCharts(document.querySelector("#chart-status"), optionsPie).render();
    }

})
.catch(error => console.error('Error loading chart data:', error));