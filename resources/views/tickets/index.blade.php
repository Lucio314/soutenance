@extends('companies.dashboard')

@section('content')
<div class="container mt-4">
    <form action="{{ route('tickets.index') }}" method="GET" class="row g-3">
        <div class="col-auto">
            <label for="filter" class="form-label">Filtrer par :</label>
            <select class="form-select form-select-sm" id="filter" name="filter">
                <option value="category" {{ request('filter') == 'category' ? 'selected' : '' }}>Catégorie de Problème</option>
                <option value="application" {{ request('filter') == 'application' ? 'selected' : '' }}>Application</option>
            </select>
        </div>
        <div class="col-auto" id="filter-options">
            @if(request('filter') == 'category')
                <label for="category" class="form-label">Catégorie :</label>
                <select class="form-select form-select-sm" id="category" name="category">
                    <option value="">Sélectionnez une catégorie</option>
                    @foreach($problemCategories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            @elseif(request('filter') == 'application')
                <label for="application" class="form-label">Application :</label>
                <select class="form-select form-select-sm" id="application" name="application">
                    <option value="">Sélectionnez une application</option>
                    @foreach($applications as $application)
                        <option value="{{ $application->id }}" {{ request('application') == $application->id ? 'selected' : '' }}>
                            {{ $application->app_name }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="col-auto align-self-end">
            <button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
        </div>
    </form>

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
                            <a href="{{ route('applications.show', $ticket->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this ticket?')"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $tickets->withQueryString()->links() }}
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fonction pour afficher ou masquer les options de filtrage
        function toggleFilterOptions() {
            var selectedFilter = document.getElementById('filter').value;
            var filterOptionsDiv = document.getElementById('filter-options');
            filterOptionsDiv.innerHTML = '';

            if (selectedFilter === 'category') {
                filterOptionsDiv.innerHTML = `
                    <label for="category" class="form-label">Catégorie :</label>
                    <select class="form-select form-select-sm" id="category" name="category">
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach($problemCategories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                `;
            } else if (selectedFilter === 'application') {
                filterOptionsDiv.innerHTML = `
                    <label for="application" class="form-label">Application :</label>
                    <select class="form-select form-select-sm" id="application" name="application">
                        <option value="">Sélectionnez une application</option>
                        @foreach($applications as $application)
                            <option value="{{ $application->id }}" {{ request('application') == $application->id ? 'selected' : '' }}>
                                {{ $application->app_name }}
                            </option>
                        @endforeach
                    </select>
                `;
            }
        }

        // Initialiser les options de filtrage au chargement de la page
        toggleFilterOptions();

        // Mettre à jour les options de filtrage lorsque le critère de filtrage change
        document.getElementById('filter').addEventListener('change', toggleFilterOptions);
    });
</script>
@endpush
