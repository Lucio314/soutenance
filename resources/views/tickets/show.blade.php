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
                        <div class="form-group ">
                            <label for="technician_id">Sélectionner un technicien:</label>
                            <select name="technician_id" id="technician_id" class="form-control">
                                @foreach($technicians as $technician)
                                <option value="{{ $technician->id }}">{{ $technician->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary ">Transférer</button>
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

            <hr>

            @php
            $currentTechnician = Auth::user()->technician;
            $isAssignedTechnician = $ticket->technicians->contains($currentTechnician);
        @endphp

        @if (true)
            <div class="row mb-3">
                <div class="col-md-12">
                    <h3>Échanges avec le client</h3>
                    <ul class="chat-box">
                        @if ($ticket->comments && count($ticket->comments) > 0)
                            @foreach ($ticket->comments->reverse() as $comment)
                                <li class="chat-message {{ $comment->is_technician ? 'technician' : 'client' }}">
                                    <div class="message-content">
                                        <p>{{ $comment->body }}</p>
                                        <span class="message-time">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li>Aucun commentaire trouvé.</li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <h3>Ajouter un commentaire</h3>
                    <form action="{{ route('tickets.comments.store', $ticket->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="body" class="form-control" placeholder="Ajouter un commentaire">
                            <button type="submit" class="btn btn-primary">Poster</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        </div>
    </div>
</div>

<style>
    .chat-box {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .chat-message {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 15px;
        max-width: 70%;
    }

    .chat-message .message-content {
        background-color: #dcf8c6;
        border-radius: 10px;
        padding: 10px;
        word-wrap: break-word;
        position: relative;
    }

    .chat-message.technician .message-content {
        background-color: #bee5eb;
        align-self: flex-end;
    }

    .chat-message.client .message-content {
        background-color: #dcf8c6;
        align-self: flex-start;
    }

    .message-time {
        font-size: 0.8em;
        color: #666;
        position: absolute;
        bottom: -15px;
        right: 5px;
    }
</style>

@endsection
