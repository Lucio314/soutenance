@extends('companies.dashboard')
@section('content')
<div class="container">
    <h1 class="fw-bold mb-4" style="font-family: Arial, sans-serif;">Liste des Techniciens</h1>
    <a href="{{ route('technicians.create') }}" class="btn btn-primary mb-4">
        <i class="bi bi-plus-circle"></i> Ajouter un Technicien
    </a>
    @if ($technicians->isEmpty())
    <p class="text-muted">Aucun technicien n'a été trouvé.</p>
    @else
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Email de l'utilisateur</th>
                    <th scope="col">Catégories de Problèmes</th>
                    <th scope="col">ID de l'Entreprise</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($technicians as $technician)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $technician->user->email }}</td>
                    <td>
                        <ul class="list-unstyled">
                            @foreach ($technician->problemCategories as $category)
                                <li>{{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $technician->company->cpn_name }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('technicians.edit', $technician) }}" class="btn btn-primary btn-sm me-2">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('technicians.destroy', $technician) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce technicien ?')">
                                    <i class="bi bi-trash-fill"></i> 
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
