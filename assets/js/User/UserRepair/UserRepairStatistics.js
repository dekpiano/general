
fetch('../Repair/DB/StatisticsCaselist')
.then(response => response.json())
.then(data => {
    console.log(data);
    
  const categories = data.map(item => item.rep_type);
  const seriesData = data.map(item => parseInt(item.total));
var options = {
    chart: { type: 'bar' },
    series: [{
      name: 'จำนวนงาน',
      data: seriesData
    }],
    xaxis: {
      categories: categories
    },
    title: { text: 'จำนวนงานซ่อมแต่ละประเภท' }
  };
  
  new ApexCharts(document.querySelector("#chart-type"), options).render();
})
.catch(error => console.error('Error loading chart data:', error));

  var options = {
    chart: { type: 'donut' },
    series: [35, 20, 40, 5],
    labels: ['รอดำเนินการ', 'กำลังดำเนินการ', 'เสร็จแล้ว', 'ยกเลิก'],
    title: { text: 'สถานะงานซ่อม' }
  };
  
  new ApexCharts(document.querySelector("#chart-status"), options).render();