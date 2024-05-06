@extends('companies.dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1 style="font-family: 'italic'">Liste des Catégories de Problèmes </h1>
        </div>
        <div class="col-md-2">
            <a href="{{ route('problem_categories.create') }}" class="btn btn-primary mb-3">
                <i class="bi bi-plus-circle"></i>Add
            </a>
        </div>
    </div>

    @foreach ($categories->groupBy('application.app_name') as $applicationName => $categoriesByApplication)
    <h2>{{ $applicationName }}</h2>

    @if ($categoriesByApplication->isEmpty())
    <p>Aucune catégorie de problème n'a été trouvée pour {{ $applicationName }}.</p>
    @else
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col" style="width: 50px">#ID</th>
                    <th scope="col" style="min-width: 200px">Nom</th>
                    <th scope="col" style="min-width: 300px">Description</th>
                    <th scope="col" style="width: 150px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categoriesByApplication as $category)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        <a href="{{ route('problem_categories.show', $category) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-info-circle-fill"></i>
                        </a>
                        <a href="{{ route('problem_categories.edit', $category->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <form action="{{ route('problem_categories.destroy', $category) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie de problème ?')">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    @endforeach
</div>
@endsection
