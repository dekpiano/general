(function() {
    let pieChart, barChart, lineChart, PieApprove;

    function renderCharts() {
        const pieEl = document.querySelector("#pie-chart");
        const barEl = document.querySelector("#bar-chart");
        const approveEl = document.querySelector("#chart-Approve");

        if (!pieEl && !barEl && !approveEl) return;

        const chartHeight = 200;

        if (pieEl) {
            const pieOptions = {
                chart: { type: 'pie', height: chartHeight },
                series: [],
                labels: [],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: { width: 400 },
                        legend: { position: 'bottom' }
                    }
                }]
            };
            pieChart = new ApexCharts(pieEl, pieOptions);
            pieChart.render();
        }

        if (barEl) {
            const barOptions = {
                chart: { type: 'bar', height: chartHeight },
                series: [{
                    name: 'จำนวนครั้งที่จอง',
                    data: []
                }],
                xaxis: { categories: [] }
            };
            barChart = new ApexCharts(barEl, barOptions);
            barChart.render();
        }

        if (approveEl) {
            const PieOptApprove = {
                chart: { type: 'donut', height: chartHeight },
                series: [],
                labels: []
            };
            PieApprove = new ApexCharts(approveEl, PieOptApprove);
            PieApprove.render();
        }

        updateCharts();
    }

    function updateCharts() {
        fetch(`${BASE_URL}Booking/DB/BookingChart`)
            .then(res => res.json())
            .then(data => {
                if (pieChart && data.pie) {
                    pieChart.updateOptions({
                        labels: data.pie.labels,
                        series: data.pie.series
                    });
                }

                if (barChart && data.bar) {
                    barChart.updateOptions({
                        xaxis: { categories: data.bar.categories },
                        series: [{ name: 'จำนวนครั้งที่จอง', data: data.bar.series }]
                    });
                }

                if (PieApprove && data.Approve) {
                    PieApprove.updateOptions({
                        labels: data.Approve.labels,
                        series: data.Approve.series
                    });
                }
            })
            .catch(error => {
                if (pieChart || barChart || PieApprove) {
                    console.error('Error loading chart data:', error);
                }
            });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', renderCharts);
    } else {
        renderCharts();
    }
})();
