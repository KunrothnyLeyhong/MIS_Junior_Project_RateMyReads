@extends('layout.master')
@section('content')
<title>Book List</title>
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
<script src="https://cdn.tailwindcss.com"></script>

<main class="flex-1 bg-[#B5E2FF] p-6 min-h-screen">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Listed Books</h2>
            <form action="{{ route('book.listbooks') }}" method="GET" class="w-1/3">
                <input type="text" name="search" placeholder="Search by title, genre, author"
                    value="{{ request('search') }}"
                    class="border rounded px-3 py-1 w-full" />
            </form>
        </div>
        <table class="min-w-full bg-white shadow-md rounded">
            <thead class="bg-[#D9D9D9] text-gray-600 uppercase text-sm">
                <tr>
                    <th class="py-3 px-6 text-left">No</th>
                    <th class="py-3 px-6 text-left">Title</th>
                    <th class="py-3 px-6 text-left">Genre</th>
                    <th class="py-3 px-6 text-left">Author</th>
                    <th class="py-3 px-6 text-left">Published Date</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @foreach ($books as $index => $book)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $index + 1 }}</td>
                        <td class="py-3 px-6">{{ $book->title }}</td>
                        <td class="py-3 px-6">{{ $book->genre }}</td>
                        <td class="py-3 px-6">{{ $book->author }}</td>
                        <td class="py-3 px-6">{{ \Carbon\Carbon::parse($book->published_date)->format('d-m-Y') }}</td>
                       <td class="py-3 px-6">
                            <span class="
                                px-2 py-1 rounded font-semibold 
                                {{ $book->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($book->status) }}
                            </span>
                        </td>
                        <td   class="px-6 py-4 flex items-center space-x-2 whitespace-nowrap">
                            <a href="{{ route('book.detailbooks', $book->id) }}"
                               class="bg-blue-500 text-white rounded px-4 py-2">Detail</a>
                            <form action="{{ route('book.listbooks.approve', $book->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white rounded px-4 py-2">Approve</button>
                            </form>
                            <button onclick="openModal({{ $book->id }})"
                                class="bg-red-500 text-white rounded px-4 py-2">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

<!-- Modal Background -->
<div id="deleteModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-semibold mb-4">Confirm Deletion</h2>
        <p class="mb-6">Are you sure you want to delete this book?</p>
        <div class="flex justify-end space-x-4">
            <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded">Cancel</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Delete</button>
            </form>
        </div>
    </div>
</div>
<!-- Modal Section as you already have it... -->

<script>
    function openModal(bookId) {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteForm').action = '/book/listbooks/' + bookId;
    }

    function closeModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>

@endsection
