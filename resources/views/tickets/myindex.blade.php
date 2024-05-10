@extends('technicians.dashboard')
@section('content')
<div class="container">
    <h1>Liste des Tickets</h1>
    @if ($tickets->isEmpty())
    <p>Aucun ticket n'a été trouvé.</p>
    @else
    <div class="table-responsive">
        <table class="table table-striped table-bordered rounded">
            <thead>
                <tr>
                    <th scope="col">#ID</th>
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
                    <th scope="row"><input type="checkbox" name="id" id="id">{{ $ticket->id }}</th>
                    <td>{{ $ticket->client_email }}</td>
                    <td>{{ $ticket->application->app_name }}</td>
                    <td>{{ $ticket->problemCategory->name }}</td>
                    <td>{{ $ticket->object }}</td>
                    <td>{{ $ticket->status }}</td>
                    <td>
                        <a href="#" type="button"><button class="btn btn-primary">Traiter</button></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection