@extends('admin.dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Index of Technicians</h1>
    {{-- <a href="{{ route('applications.create') }}" class="btn btn-primary mb-3">Add Application</a> --}}
    <h4>List </h4>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email </th>
                    <th>Member_at</th>
                    <th>Ticket res </th>
                </tr>
            </thead>
            <tbody>
                @foreach($technicians as $technician)
                <tr>
                    <td>{{ $technician->user->name }}</td>
                    <td>{{ $technician->user->email }}</td>
                    <td>{{date('d/m/Y', strtotime($technician->created_at))  }}</td>
                    <td>{{$technician->gerers->count() }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
