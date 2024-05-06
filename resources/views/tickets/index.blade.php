@extends('companies.dashboard')

@section('content')

<div class="container">
    <h1 class="my-4">Liste des Tickets</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Client Email</th>
                <th scope="col">Application</th>
                <th scope="col">Catégorie de Problème</th>
                <th scope="col">Objet</th>
                <th scope="col">Statut</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tickets as $ticket)
            <tr>
                <th scope="row">{{ $ticket->id }}</th>
                <td>{{ $ticket->client_email }}</td>
                <td>{{ $ticket->application->app_name }}</td>
                <td>{{ $ticket->problemCategory->name }}</td>
                <td>{{ $ticket->object }}</td>
                <td>{{ $ticket->status }}</td>
                <td class="align-center">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">

                            <span class="d-none d-lg-inline-flex"><i class="bi bi-three-dots"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="{{ route('applications.show', $ticket->id) }}" class=" btn btn-info btn-sm"><i
                                    class="fas fa-eye"></i></a>
                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-primary btn-sm"><i
                                    class="fas fa-edit"></i></a>
                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this ticket?')"><i
                                        class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>


                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
