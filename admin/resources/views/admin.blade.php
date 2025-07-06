@extends('layout.master')
@section('content')
<title>Admin</title>
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
<script src="https://cdn.tailwindcss.com"></script>

<main class="flex-1 bg-[#B5E2FF] p-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">List of Admins</h2>
            <form action="{{ route('admin') }}" method="GET" class="w-1/3">
                <input type="text" name="search" placeholder="Search by first name or last name or email"
                    value="{{ request('search') }}"
                    class="border rounded px-3 py-1 w-full" />
            </form>
        </div>
        <table class="min-w-full bg-white shadow-md rounded">
            <thead class="bg-[#D9D9D9] text-gray-600 uppercase text-sm">
                <tr>
                    <th class="py-3 px-6 text-left">No</th>
                    <th class="py-3 px-6 text-left">First Name</th>
                    <th class="py-3 px-6 text-left">Last Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @foreach ($admins as $index => $admin)
                <tr class="border-b hover:bg-gray-100">
                    <td class="py-3 px-6">{{ $index + 1 }}</td>
                    <td class="py-3 px-6">{{ $admin->firstname }}</td>
                    <td class="py-3 px-6">{{ $admin->lastname }}</td>
                    <td class="py-3 px-6">{{ $admin->email }}</td>
                    <td class="py-3 px-6">
                        <label class="switch">
                            <input type="checkbox"
                                class="status-toggle"
                                data-id="{{ $admin->id }}"
                                {{ $admin->status ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <button onclick="openModal({{ $admin->id }})" class="bg-red-500 text-white rounded px-4 py-2">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.status-toggle').forEach(toggle => {
            toggle.addEventListener('change', function () {
                const adminId = this.dataset.id;
                fetch(`/admin/${adminId}/toggle-status`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        alert('Failed to update');
                        this.checked = !this.checked;
                    }
                })
                .catch(err => {
                    alert('Request error');
                    this.checked = !this.checked;
                    console.error(err);
                });
            });
        });
    });
</script>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
        <p class="mb-4">Are you sure you want to delete this admin?</p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(adminId) {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteForm').action = '/admin/' + adminId;
    }

    function closeModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>


@endsection
