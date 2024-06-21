@extends('technicians.dashboard')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Détails du Ticket #{{ $ticket->id }}</h2>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Email du client:</label>
                </div>
                <div class="col-md-9">
                    <span id="client_email">{{ $ticket->client_email }}</span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Application:</label>
                </div>
                <div class="col-md-9">
                    <span id="application">{{ $ticket->application->app_name }}</span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Catégorie de problème:</label>
                </div>
                <div class="col-md-9">
                    <span id="problem_category">{{ $ticket->problemCategory->name }}</span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Objet:</label>
                </div>
                <div class="col-md-9">
                    <span id="object">{{ $ticket->object }}</span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Contenu:</label>
                </div>
                <div class="col-md-9">
                    <span id="content">{{ $ticket->content }}</span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Statut:</label>
                </div>
                <div class="col-md-9">
                    <span id="status">{{ $ticket->status }}</span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Créé le:</label>
                </div>
                <div class="col-md-9">
                    <span id="created_at">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-12">
                    <h3>Transférer le Ticket</h3>
                    <form action="{{ route('tickets.transfer', $ticket->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="technician_id">Sélectionner un technicien:</label>
                            <select name="technician_id" id="technician_id" class="form-control">
                                @foreach($technicians as $technician)
                                <option value="{{ $technician->id }}">{{ $technician->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Transférer</button>
                    </form>
                </div>
            </div>

            @if($ticket->uploaded_files)
            <div class="row mb-3">
                <div class="col-md-12">
                    <h3>Fichiers téléversés</h3>
                    <ul>
                        @foreach(json_decode($ticket->uploaded_files, true) as $file)
                        <li><a href="{{ asset('storage/' . $file) }}" target="_blank">{{ basename($file) }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
