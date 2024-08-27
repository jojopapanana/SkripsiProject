<x-layout title="Dashboard">
    <h1 class="fw-bold">DASHBOARD</h1>

    <div class="d-flex gap-4">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-top">
                <div>
                    <h4 class="fw-bold">Keuntunganmu bulan ini</h4>
                    <h4 class="fw-bold" style="color: rgba(14, 70, 163, 1)">Rp. 100.000</h4>
                </div>
                
                <i class="bi bi-file-bar-graph-fill fs-1"></i>
            </div>
        </div>
    
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-top">
                <div>
                    <h4 class="fw-bold">Kasmu bulan ini</h4>
                    <h4 class="fw-bold" style="color: rgba(14, 70, 163, 1)">Rp. 2.000.000</h4>
                </div>
                
                <i class="bi bi-cash fs-1"></i>
            </div>
        </div>
    </div>

    <div class="dashboard-trenkeuntungan">
        <h3 class="fw-bold">Tren Keuntungan-mu!</h3>
        <canvas id="myChart" style="width: 70vw; height: 40vh"></canvas>
    </div>

    
    

    <div class="d-flex gap-4">
        <button class="btn p-2 fw-semibold fs-5" style="border: none; border-radius: 10px" id="dashboard-button-full">
            + Tambah Pemasukan        
        </button>
    
        <button class="btn p-2 fw-semibold fs-5" style="border: 2px solid ; border-radius: 10px" id="dashboard-button-outline">
            - Tambah Pengeluaran
        </button>
    </div>
    
    <script type="module">
    const data = {
        labels: @json($data->map(fn ($data) => $data->date)),
        datasets: [{
            label: 'Registered users in the last 30 days',
            backgroundColor: 'red',
            borderColor: 'rgb(255, 99, 132)',
            data: @json($data->map(fn ($data) => $data->aggregate)),
        }]
    };

    console.log(data);

    const config = {
        type: 'bar',
        data: data
    };
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
    </script>
</x-layout>