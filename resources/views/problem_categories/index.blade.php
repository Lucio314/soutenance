@extends('companies.dashboard')
<<<<<<< HEAD
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
=======

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
>>>>>>> 7300c5caa7056006324d5c9a26a6f8206b730999
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<<<<<<< HEAD
    @endif
    @endforeach
=======
>>>>>>> 7300c5caa7056006324d5c9a26a6f8206b730999
</div>
@endsection
