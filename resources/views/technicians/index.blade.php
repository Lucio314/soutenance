@extends('companies.dashboard')
@section('content')
<div class="container">
    <h1>Liste des Techniciens</h1>
    <a href="{{ route('technicians.create') }}" class="btn btn-primary mb-3">Ajouter un Technicien</a>
    @if ($technicians->isEmpty())
    <p>Aucun technicien n'a été trouvé.</p>
    @else
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">User email</th>
                    <th scope="col">Problem Categories</th>
                    <th scope="col">Company ID</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($technicians as $technician)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $technician->user->email }}</td>
                    <td>
                        <ul>
                            @foreach ($technician->problemCategories as $category)
                                <li>{{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $technician->company->cpn_name }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Actions">
                            <a href="{{ route('technicians.edit', $technician) }}" class="btn btn-primary btn-sm">Modifier</a>
                            <form action="{{ route('technicians.destroy', $technician) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce technicien ?')">Supprimer</button>
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
