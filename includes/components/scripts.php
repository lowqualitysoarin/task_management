<!-- ========= All Javascript files linkup ======== -->

<!-- TOASTR (MUST LOAD FIRST) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- TOASTR CONFIG (TOP CENTER) -->
<script>
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-center",
    timeOut: 3000
};
</script>

<!-- ========= Bootstrap Table ======== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.js"></script>

<!-- ========= CORE JS FILES ======== -->
<script src="../../assets/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/Chart.min.js"></script>
<script src="../../assets/js/dynamic-pie-chart.js"></script>
<script src="../../assets/js/moment.min.js"></script>
<script src="../../assets/js/fullcalendar.js"></script>
<script src="../../assets/js/jvectormap.min.js"></script>
<script src="../../assets/js/world-merc.js"></script>
<script src="../../assets/js/polyfill.js"></script>
<script src="../../assets/js/main.js"></script>

<!-- OPTIONAL: TRUE CENTER VISUAL ADJUSTMENT -->
<style>
#toast-container.toast-top-center {
    top: 20px;
}
</style>

<script>
    // ======== jvectormap activation
    var markers = [
        { name: "Egypt", coords: [26.8206, 30.8025] },
        { name: "Russia", coords: [61.524, 105.3188] },
        { name: "Canada", coords: [56.1304, -106.3468] },
        { name: "Greenland", coords: [71.7069, -42.6043] },
        { name: "Brazil", coords: [-14.235, -51.9253] },
    ];

    if (typeof jsVectorMap !== "undefined") {
        new jsVectorMap({
            map: "world_merc",
            selector: "#map",
            zoomButtons: true,
            regionStyle: {
                initial: { fill: "#d1d5db" }
            },
            markersSelectable: true,
            markers: markers,
            markerStyle: {
                initial: { fill: "#4A6CF5" },
                selected: { fill: "#ff5050" }
            }
        });
    }

    // ===== calendar
    document.addEventListener("DOMContentLoaded", function () {
        var calendarMiniEl = document.getElementById("calendar-mini");

        if (calendarMiniEl && typeof FullCalendar !== "undefined") {
            var calendarMini = new FullCalendar.Calendar(calendarMiniEl, {
                initialView: "dayGridMonth",
                headerToolbar: {
                    end: "today prev,next",
                },
            });
            calendarMini.render();
        }
    });

    // ===== CHART 1
    const ctx1 = document.getElementById("Chart1");
    if (ctx1) {
        new Chart(ctx1.getContext("2d"), {
            type: "line",
            data: {
                labels: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                datasets: [{
                    borderColor: "#365CF5",
                    data: [600,800,750,880,940,880,900,770,920,890,976,1100],
                    borderWidth: 3
                }]
            },
            options: { plugins: { legend: { display: false } } }
        });
    }

    // ===== CHART 2
    const ctx2 = document.getElementById("Chart2");
    if (ctx2) {
        new Chart(ctx2.getContext("2d"), {
            type: "bar",
            data: {
                labels: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                datasets: [{
                    backgroundColor: "#365CF5",
                    data: [600,700,1000,700,650,800,690,740,720,1120,876,900],
                }]
            },
            options: { plugins: { legend: { display: false } } }
        });
    }

    // ===== CHART 3
    const ctx3 = document.getElementById("Chart3");
    if (ctx3) {
        new Chart(ctx3.getContext("2d"), {
            type: "line",
            data: {
                labels: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                datasets: [
                    {
                        label: "Revenue",
                        borderColor: "#365CF5",
                        data: [80,120,110,100,130,150,115,145,140,130,160,210],
                        tension: 0.4
                    },
                    {
                        label: "Profit",
                        borderColor: "#9b51e0",
                        data: [120,160,150,140,165,210,135,155,170,140,130,200],
                        tension: 0.4
                    }
                ]
            },
            options: { plugins: { legend: { display: false } } }
        });
    }

    // ===== CHART 4
    const ctx4 = document.getElementById("Chart4");
    if (ctx4) {
        new Chart(ctx4.getContext("2d"), {
            type: "bar",
            data: {
                labels: ["Jan","Feb","Mar","Apr","May","Jun"],
                datasets: [
                    { backgroundColor: "#365CF5", data: [600,700,1000,700,650,800] },
                    { backgroundColor: "#d50100", data: [690,740,720,1120,876,900] }
                ]
            },
            options: { plugins: { legend: { display: false } } }
        });
    }
</script>