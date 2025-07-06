@extends('layout.master')

@section('content')
<title>Reported Review List</title>
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
<script src="https://cdn.tailwindcss.com"></script>

<main class="flex-1 bg-[#B5E2FF] p-6">

    <!-- Tabs -->
    <div class="flex gap-4 mb-6">
        <a href="{{ route('report.reportcomment') }}"
            class="bg-gray-300 text-gray-700 p-4 rounded w-1/4 flex items-center justify-center font-semibold hover:text-blue-500">
            <span>❗ Reported Comments</span>
        </a>
        <a href="{{ route('report.reportreview') }}"
            class="p-4 rounded w-1/4 flex items-center justify-center font-semibold bg-blue-500 text-white">
            <span>❗ Reported Reviews</span>
        </a>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div class="bg-blue-200 text-blue-800 p-3 rounded mb-4 text-center">
            {{ session('info') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-center font-bold text-lg mb-4">Reported Reviews</h2>
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-[#D9D9D9]">
                <tr>
                    <th class="py-2 px-4">No</th>
                    <th class="py-2 px-4">First Name</th>
                    <th class="py-2 px-4">Last Name</th>
                    <th class="py-2 px-4">Email</th>
                    <th class="py-2 px-4">Reason Report</th>
                    <th class="py-2 px-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @forelse ($reports as $index => $report)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $index + 1 }}</td>
                        <td class="py-3 px-6">{{ $report->user->first_name ?? '-' }}</td>
                        <td class="py-3 px-6">{{ $report->user->last_name ?? '-' }}</td>
                        <td class="py-3 px-6">{{ $report->user->email ?? '-' }}</td>
                        <td class="py-3 px-6">
                            <p class="text-gray-600">{{ \Illuminate\Support\Str::words($report->reason, 10, '...') }}</p>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('report.reportreviewdetail', $report->id) }}"
                                class="bg-green-500 text-white rounded px-4 py-2 inline-block mb-1">Detail</a>

                            <button type="button"
                                onclick="openModal('approve', {{ $report->id }})"
                                class="bg-blue-500 text-white rounded px-4 py-2 mb-1">Approve</button>

                            <button type="button"
                                onclick="openModal('reject', {{ $report->id }})"
                                class="bg-red-500 text-white rounded px-4 py-2">Reject</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">No reported reviews found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
         <!-- Pagination Links -->
        <div class="mt-6">
            {{ $reports->links('pagination::tailwind') }}
        </div>
    </div>
</main>

<!-- Modal -->
<div id="actionModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-40">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 space-y-4">
        <h3 class="text-xl font-bold text-center" id="modalTitle">Confirm Action</h3>
        <p class="text-gray-700 text-center" id="modalMessage">Are you sure you want to proceed?</p>

        <form method="POST" id="modalForm" class="flex justify-center space-x-4">
            @csrf
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Yes</button>
            <button type="button" onclick="closeModal()" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
        </form>
    </div>
</div>

<!-- Modal Script -->
<script>
    function openModal(action, id) {
        const modal = document.getElementById('actionModal');
        const form = document.getElementById('modalForm');
        const title = document.getElementById('modalTitle');
        const message = document.getElementById('modalMessage');

        if (action === 'approve') {
            form.action = `/report/reportreview/${id}/approve`;
            title.textContent = 'Approve Review';
            message.textContent = 'Are you sure you want to approve this review?';
        } else if (action === 'reject') {
            form.action = `/report/reportreview/${id}/reject`;
            title.textContent = 'Reject Review';
            message.textContent = 'Are you sure you want to reject this review?';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('actionModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>
@endsection
