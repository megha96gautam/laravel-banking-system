

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="container">
    <h2>All User Accounts</h2>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.accounts') }}" class="mb-4">
        <input type="text" name="search" placeholder="Search by First Name, Last Name, Date of Birth, or Account #" 
               value="{{ request('search') }}" class="form-control mb-2">
        <input type="text" name="min_balance" placeholder="Min Balance" 
               value="{{ request('min_balance') }}" class="form-control mb-2">
        <input type="text" name="max_balance" placeholder="Max Balance" 
               value="{{ request('max_balance') }}" class="form-control mb-2">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <!-- Accounts Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date Of Birth</th>
                <th>Account Number</th>
                <th>Balance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->date_of_birth }}</td>
                    <td>{{ $user->account_number }}</td>
                    <td>${{ number_format($user->balance, 2) }}</td>
                    <td>
                        <a href="#" class="btn btn-info btn-sm">View</a>
                        <a href="#" class="btn btn-warning btn-sm">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $users->links() }}
</div>
            </div>
        </div>
    </div>
</x-app-layout>
