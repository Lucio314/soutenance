@extends('technicians.dashboard')

@section('content')
<div class="container">
    <h1>Liste des Tickets</h1>

    <!-- Formulaire de filtrage -->
    <form action="{{ route('tickets.myindex') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="priority" class="form-label">Filtrer par Priorité :</label>
                <select class="form-select" id="priority" name="priority">
                    <option value="">Toutes les priorités</option>
                    @foreach ($priorities as $priority)
                        <option value="{{ $priority->code_priority }}" {{ request('priority') == $priority->code_priority ? 'selected' : '' }}>
                            {{ $priority->name_priority }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 align-self-end">
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </div>
        </div>
    </form>

    @if ($tickets->isEmpty())
        <p>Aucun ticket n'a été trouvé.</p>
    @else
        <form action="{{ route('tickets.verrouillerEnMasse') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-striped table-bordered rounded">
                    <thead>
                        <tr>
                            <th scope="col"><input type="checkbox" id="select-all"></th>
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
                                <td>
                                    @if ($ticket->status == 'Nouveau')
                                        <input type="checkbox" name="ticket_ids[]" value="{{ $ticket->id }}">
                                    @endif
                                </td>
                                <th scope="row">{{ $ticket->id }}</th>
                                <td>{{ $ticket->client_email }}</td>
                                <td>{{ $ticket->application->app_name }}</td>
                                <td>
                                    @php
                                        $priorityColor = '';
                                        switch ($ticket->problemCategory->problem_priority->code_priority) {
                                            case 111:
                                                $priorityColor = 'bg-primary'; // Couleur bleue pour "Priorité plus faible"
                                                break;
                                            case 112:
                                                $priorityColor = 'bg-secondary'; // Couleur grise pour "Priorité faible"
                                                break;
                                            case 121:
                                                $priorityColor = 'bg-info'; // Couleur cyan pour "Priorité moyenne"
                                                break;
                                            case 122:
                                                $priorityColor = 'bg-warning'; // Couleur jaune pour "Priorité plus que moyenne"
                                                break;
                                            case 211:
                                            case 212:
                                            case 221:
                                            case 222:
                                                $priorityColor = 'bg-danger'; // Couleur rouge pour "Priorité élevée", "Priorité plus élevée", "Priorité haute", "Priorité plus que haute"
                                                break;
                                            default:
                                                $priorityColor = 'bg-light'; // Couleur par défaut pour les priorités non définies
                                                break;
                                        }
                                    @endphp
                                    <span class="badge rounded-pill {{ $priorityColor }}">
                                        {{ $ticket->problemCategory->name }}
                                    </span>
                                </td>
                                <td>{{ $ticket->object }}</td>
                                <td>{{ $ticket->status }}</td>
                                <td style="display: flex;flex-direction:row;gap:4px">
                                    @if ($ticket->status == 'Nouveau')
                                        <form action="{{ route('tickets.handle', ['ticketId' => $ticket->id, 'technicianId' => Auth::user()->technician->id]) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-info">
                                                <i class="bi bi-unlock"></i>
                                            </button>
                                        </form>
                                    @elseif ($ticket->status == 'En cours')
                                        <form action="{{ route('tickets.close', ['ticketId' => $ticket->id, 'technicianId' => Auth::user()->technician->id]) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-lock"></i>
                                            </button>
                                        </form>
                                    @elseif ($ticket->status == 'Terminé')
                                        <span class="btn btn-success">
                                            <i class="bi bi-check-circle"></i>
                                        </span>
                                    @endif

                                    <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Verrouiller les tickets sélectionnés</button>
        </form>
    @endif
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Sélectionner ou désélectionner toutes les cases à cocher
        document.getElementById('select-all').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('input[name="ticket_ids[]"]');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
    });
</script>
@endpush
