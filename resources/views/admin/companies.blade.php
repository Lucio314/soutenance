@extends('admin.dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Index of Companies</h1>
    <h4>List</h4>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email app</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Member at</th>
                    <th>Count app</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                <tr>
                    <td>{{ $company->cpn_name }}</td>
                    <td>{{ $company->cpn_email }}</td>
                    <td>{{ $company->company_phone }}</td>
                    <td>{{ $company->cpn_address }}</td>
                    <td>{{ date('d/m/Y', strtotime($company->created_at)) }}</td>
                    <td>{{ $company->applications->count() }}</td>
                    <td>
                        <form action="{{ route('admin.company.toggle', $company) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" id="toggleButton-{{ $company->id }}" class="toggle-button" style="border: none; background: none;">
                                <i id="toggleIcon-{{ $company->id }}" class="fas {{ $company->is_active ? 'fa-toggle-on text-primary' : 'fa-toggle-off' }}"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


