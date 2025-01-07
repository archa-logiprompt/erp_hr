@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Expense Details</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Data Tables</li>
                            <li class="breadcrumb-item active">Expense Details Table</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <!-- Zero Configuration Starts -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar">
                                <div class="common-flex justify-content-end mb-5">
                                    <a class="btn btn-primary btn-sm" type="button"
                                        href="{{ route('admin.expense.create') }}">Add</a>
                                </div>
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>Head</th>
                                            <th>Center</th>

                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expensedetails as $expense)
                                            <tr>
                                                <td>{{ $expense->expenseHead->head ?? 'N/A' }}</td>
                                                <td>{{ $expense->centers->name ?? 'N/A' }}</td>


                                                <td>{{ $expense->date ? \Carbon\Carbon::parse($expense->date)->format('d-m-Y') : 'N/A' }}</td>
                                                <td>{{ $expense->name ?? 'N/A' }}</td>
                                                <td>{{ $expense->amount ?? 'N/A' }}</td>
                                                <td>
                                                    <ul class="action">
                                                        <li class="edit">
                                                            <a href="{{ url('/admin/expense/edit', $expense->id) }}">
                                                                <i class="icon-pencil-alt"></i>
                                                            </a>
                                                        </li>
                                                        <li class="delete">
                                                            <!-- Form for deletion -->
                                                            <form id="delete-form-{{ $expense->id }}"
                                                                action="{{ route('admin.expense.destroy', $expense->id) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>

                                                            <!-- Delete Button -->
                                                            <a href="#" class="delete-btn"
                                                                data-id="{{ $expense->id }}">
                                                                <i class="icon-trash"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Zero Configuration Ends -->
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>

    @push('scripts')
    <script>
        // Trigger form submission for delete
        document.querySelectorAll('.delete-btn').forEach(function(deleteButton) {
            deleteButton.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default link behavior
                var expenseId = this.getAttribute('data-id');
                var form = document.getElementById('delete-form-' + expenseId);
                
                if (confirm('Are you sure you want to delete this expense?')) {
                    form.submit(); // Submit the form to trigger the delete action
                }
            });
        });
    </script>
    @endpush
@endsection
