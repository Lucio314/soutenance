@extends('companies.dashboard')
@section('content')

<div class="container">
    <h1 class="mb-4">Modifier le Technicien</h1>
    <form action="{{ route('technicians.update', $technician->id) }}" method="POST" id="updateForm">
        @csrf
        @method('PUT')

        <!-- Afficher les informations du technicien à modifier -->

        <!-- Afficher la liste des catégories de problèmes dans un tableau -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAllCategories">
                            <label for="selectAllCategories">Tout sélectionner</label>
                        </th>
                        <th>Nom</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($problem_categories as $category)
                    <tr>
                        <td>
                            <input class="form-check-input category-checkbox" type="checkbox"
                                name="problem_category_id[]" value="{{ $category->id }}" {{
                                $technician->problemCategories->contains($category->id) ? 'checked' : '' }}>
                        </td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCategoriesCheckbox = document.getElementById('selectAllCategories');
        const categoryCheckboxes = document.querySelectorAll('.category-checkbox');

        // Fonction pour cocher ou décocher tous les checkboxes de catégorie
        function toggleAllCategories() {
            categoryCheckboxes.forEach(function (checkbox) {
                checkbox.checked = selectAllCategoriesCheckbox.checked;
            });
        }

        // Écouter les changements sur la case à cocher "Tout sélectionner"
        selectAllCategoriesCheckbox.addEventListener('change', toggleAllCategories);
    });
</script>
@endsection
