

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
<br><br>
<div class="container">
    <h2>Saving Accounts</h2>
    <a href="{{ route('saving_accounts.create') }}" class="btn btn-primary">Create New Account</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Account Number</th>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Address</th>
                <th>Balance (USD)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $account)
                <tr>
                    <td>{{ $account->account_number }}</td>
                    <td>{{ $account->first_name }} {{ $account->last_name }}</td>
                    <td>{{ $account->date_of_birth }}</td>
                    <td>{{ $account->address }}</td>
                    <td>${{ number_format($account->balance, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>