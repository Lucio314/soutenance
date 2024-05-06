@extends('companies.dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Index of Applications</h1>
    <a href="{{ route('applications.create') }}" class="btn btn-primary mb-3">Add Application</a>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Unique Code</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($company->applications as $application)
                <tr>
                    <td>{{ $application->app_name }}</td>
                    <td>{{ $application->description }}</td>
                    <td>{{ $application->unique_code }}</td>
                    <td>{{ $application->app_email }}</td>
                    <td>{{ $application->app_phone }}</td>
                    <td>
                        <a href="{{ route('applications.show', $application->id) }}" class="btn btn-info btn-sm"><i
                                class="fas fa-eye"></i></a>
                        <a href="{{ route('applications.edit', $application->id) }}" class="btn btn-primary btn-sm"><i
                                class="fas fa-edit"></i></a>
                        <form action="{{ route('applications.destroy', $application->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this application?')"><i
                                    class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
