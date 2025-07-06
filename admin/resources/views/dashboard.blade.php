@extends('layout.master')
@section('content')
<title>Dashboard</title>
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<main class="flex-1 p-10 bg-[#B5E2FF] min-h-screen">
    <h1 class="text-3xl font-extrabold mb-6 text-gray-800">📊 Admin Dashboard</h1>

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

    <!-- Chart Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Bar Chart -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="font-semibold text-lg mb-2">📚 Book Stats</h3>
            <canvas id="bookChart"></canvas>
        </div>

        <!-- Doughnut Chart -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="font-semibold text-lg mb-2">⚠️ Reports</h3>
            <canvas id="reportChart"></canvas>
        </div>
    </div>
</main>

<script>
    // Bar chart: Books
    const bookCtx = document.getElementById('bookChart').getContext('2d');
    new Chart(bookCtx, {
        type: 'bar',
        data: {
            labels: ['Total', 'Pending', 'Approved'],
            datasets: [{
                label: 'Books',
                data: [{{ $totalBooks }}, {{ $pendingBooks }}, {{ $approvedBooks }}],
                backgroundColor: ['#3B82F6', '#FBBF24', '#10B981'],
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Doughnut chart: Reports
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
            responsive: true
        }
    });
</script>
@stop
