@extends('layout.master')
@section('content')
<title>Books Listed</title>
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

<main class="flex-1 bg-[#B5E2FF] p-6 min-h-screen">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-4">Books Listed</h2>

        <table class="min-w-full text-left border border-blue-200 rounded">
            <thead class="bg-gray-300 text-gray-800 font-semibold">
                <tr>
                    <th class="py-3 px-4">No</th>
                    <th class="py-3 px-4">Title</th>
                    <th class="py-3 px-4">Genre</th>
                    <th class="py-3 px-4">Author</th>
                    <th class="py-3 px-4">Published Date</th>
                </tr>
            </thead>
            <tbody class="bg-white text-black">
                @forelse ($user->books as $book)
                    <tr class="border border-blue-200">
                        <td class="py-3 px-4">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4">{{ $book->title }}</td>
                        <td class="py-3 px-4">{{ $book->genre }}</td>
                        <td class="py-3 px-4">{{ $book->author }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($book->published_date)->format('F j, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-600">No books found for this user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
