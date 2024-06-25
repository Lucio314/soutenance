@extends('companies.dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Liste des Applications</h1>
    <a href="{{ route('applications.create') }}" class="btn btn-primary mb-3">Ajouter une application</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
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
                    <td>
                        <div class="d-flex align-items-center">
                            <span id="masked-code">{{ substr($application->unique_code, 0, 5) }}...</span>
                            <span id="actual-code" style="display: none">{{ $application->unique_code }}</span>
                            <button class="copy-btn btn btn-link" data-clipboard-text="{{ $application->unique_code }}">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </td>
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
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Script pour la copie dans le presse-papiers -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script>
    // Initialisation de Clipboard.js
    new ClipboardJS('.copy-btn');

    // Affichage / Masquage du code complet au clic
    document.querySelectorAll('.copy-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const code = btn.getAttribute('data-clipboard-text');
            copyToClipboard(code);
        });
    });

    // Fonction pour copier dans le presse-papiers
    function copyToClipboard(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
       // alert('Code copié dans le presse-papiers : ' + text);
    }
</script>
@endsection