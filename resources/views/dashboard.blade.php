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
    <h2>Create Multiple Saving Accounts</h2>
    
    <form action="{{ route('saving_accounts.store') }}" method="POST">
        @csrf

        <div id="accounts-container">
            <div class="account-entry row g-3">
                <h4>Account 1</h4>
                
                <div class="col-md-2">
                    <label class="form-label">First Name</label>
                    <input type="text" name="accounts[0][first_name]" class="form-control" required>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="accounts[0][last_name]" class="form-control" required>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="accounts[0][date_of_birth]" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Address</label>
                    <input type="text" name="accounts[0][address]" class="form-control" required>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-account d-none">Remove</button>
                </div>

                <hr class="mt-3">
            </div>
        </div>

        <button type="button" id="add-account" class="btn btn-secondary">+ Add Another Account</button>
        <button type="submit" class="btn btn-success">Create Accounts</button>
    </form>
</div>

            </div>
        </div>
    </div>
</x-app-layout>


<script>
    let accountIndex = 1;

    document.getElementById('add-account').addEventListener('click', function () {
        let container = document.getElementById('accounts-container');
        let newEntry = document.createElement('div');
        newEntry.classList.add('account-entry', 'row', 'g-3');
        newEntry.innerHTML = `
            <h4>Account ${accountIndex + 1}</h4>

            <div class="col-md-2">
                <label class="form-label">First Name</label>
                <input type="text" name="accounts[${accountIndex}][first_name]" class="form-control" required>
            </div>

            <div class="col-md-2">
                <label class="form-label">Last Name</label>
                <input type="text" name="accounts[${accountIndex}][last_name]" class="form-control" required>
            </div>

            <div class="col-md-2">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="accounts[${accountIndex}][date_of_birth]" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Address</label>
                <input type="text" name="accounts[${accountIndex}][address]" class="form-control" required>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-account">Remove</button>
            </div>

            <hr class="mt-3">
        `;
        
        container.appendChild(newEntry);
        accountIndex++;

        // Show remove button for new entries
        document.querySelectorAll('.remove-account').forEach(btn => {
            btn.classList.remove('d-none');
            btn.addEventListener('click', function () {
                this.closest('.account-entry').remove();
            });
        });
    });
</script>
