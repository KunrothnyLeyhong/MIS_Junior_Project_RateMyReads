@extends('layout.master')
@section('content')
<title>Dashboard</title>
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<main class="flex-1 p-10 bg-[#B5E2FF] min-h-screen">
    <h1 class="text-3xl font-extrabold mb-6 text-gray-800">📊 Admin Dashboard</h1>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
            <div class="text-4xl mb-2 text-blue-500">📚</div>
            <h2 class="font-semibold text-lg">Total Books</h2>
            <p class="text-3xl font-bold text-gray-700 mt-1">{{ $totalBooks }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
            <div class="text-4xl mb-2 text-yellow-500">⏳</div>
            <h2 class="font-semibold text-lg">Pending Books</h2>
            <p class="text-3xl font-bold text-gray-700 mt-1">{{ $pendingBooks }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
            <div class="text-4xl mb-2 text-green-500">✅</div>
            <h2 class="font-semibold text-lg">Approved Books</h2>
            <p class="text-3xl font-bold text-gray-700 mt-1">{{ $approvedBooks }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
            <div class="text-4xl mb-2 text-purple-500">👥</div>
            <h2 class="font-semibold text-lg">Total Users</h2>
            <p class="text-3xl font-bold text-gray-700 mt-1">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
            <div class="text-4xl mb-2 text-red-500">📝</div>
            <h2 class="font-semibold text-lg">Reported Comments</h2>
            <p class="text-3xl font-bold text-gray-700 mt-1">{{ $totalReportsComment }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
            <div class="text-4xl mb-2 text-red-400">📝</div>
            <h2 class="font-semibold text-lg">Reported Reviews</h2>
            <p class="text-3xl font-bold text-gray-700 mt-1">{{ $totalReportsReview }}</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Bar Chart -->
        <div class="bg-white p-6 rounded-2xl shadow-lg flex flex-col items-center justify-center">
            <h3 class="font-semibold text-xl mb-4 text-gray-700 flex items-center">
                📚 <span class="ml-2">Book Stats</span>
            </h3>
            <div class="w-[660px] h-[470px]">
                <canvas id="bookChart" width="660" height="470"></canvas>
            </div>
        </div>

        <!-- Doughnut Chart -->
        <div class="bg-white p-6 rounded-2xl shadow-lg flex flex-col items-center justify-center">
            <h3 class="font-semibold text-xl mb-4 text-gray-700 flex items-center">
                ⚠️ <span class="ml-2">Reports</span>
            </h3>
            <div class="w-[660px] h-[470px]">
                <canvas id="reportChart" width="660" height="470"></canvas>
            </div>
        </div>
    </div>
</main>
<!-- Chart.js Script -->
<script>
    // Bar Chart - Book Stats
    const bookCtx = document.getElementById('bookChart').getContext('2d');
    new Chart(bookCtx, {
        type: 'bar',
        data: {
            labels: ['Total', 'Pending', 'Approved'],
            datasets: [{
                label: 'Books',
                data: [{{ $totalBooks }}, {{ $pendingBooks }}, {{ $approvedBooks }}],
                backgroundColor: ['#3B82F6', '#FBBF24', '#10B981'],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: 10
            },
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Doughnut Chart - Reports
    const reportCtx = document.getElementById('reportChart').getContext('2d');
    new Chart(reportCtx, {
        type: 'doughnut',
        data: {
            labels: ['Reported Comments', 'Reported Reviews'],
            datasets: [{
                data: [{{ $totalReportsComment }}, {{ $totalReportsReview }}],
                backgroundColor: ['#65D5FF', '#296d98'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    top: 20,
                    bottom: 20,
                    left: 20,
                    right: 20
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });
</script>
@endsection