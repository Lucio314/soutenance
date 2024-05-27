<!-- resources/views/tickets/show.blade.php -->

@extends('technicians.dashboard')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Détails du Ticket</h2>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="client_email" class="form-label">Email du client:</label>
                <p id="client_email">{{ $ticket->client_email }}</p>
            </div>
            <div class="mb-3">
                <label for="application" class="form-label">Application:</label>
                <p id="application">{{ $ticket->application->name }}</p>
            </div>
            <div class="mb-3">
                <label for="problem_category" class="form-label">Catégorie de problème:</label>
                <p id="problem_category">{{ $ticket->problemCategory->name }}</p>
            </div>
            <div class="mb-3">
                <label for="object" class="form-label">Objet:</label>
                <p id="object">{{ $ticket->object }}</p>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Contenu:</label>
                <p id="content">{{ $ticket->content }}</p>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Statut:</label>
                <p id="status">{{ $ticket->status }}</p>
            </div>
            <div class="mb-3">
                <label for="created_at" class="form-label">Créé le:</label>
                <p id="created_at">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="mb-3">
                <label for="updated_at" class="form-label">Mis à jour le:</label>
                <p id="updated_at">{{ $ticket->updated_at->format('d/m/Y H:i') }}</p>
            </div>
            @if($ticket->uploaded_files)
                <div class="mb-3">
                    <label for="uploaded_files" class="form-label">Fichiers téléversés:</label>
                    <ul id="uploaded_files">
                        @foreach($ticket->uploaded_files as $file)
                            <li><a href="{{ asset('storage/' . $file) }}" target="_blank">{{ basename($file) }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-primary">Modifier</a>
            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
@endsection
