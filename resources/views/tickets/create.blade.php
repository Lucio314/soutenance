<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Ticket</title>
    <style>
        /* Styles for form container */
        .ticket-form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Styles for form labels */
        .ticket-form label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        /* Styles for form inputs */
        .ticket-form input[type="text"],
        .ticket-form input[type="email"],
        .ticket-form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Styles for form select */
        .ticket-form select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            box-sizing: border-box;
        }

        /* Styles for form button */
        .ticket-form button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .ticket-form button:hover {
            background-color: #0056b3;
        }

        /* Styles for error messages */
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <div id="ticket-create-container">
        <form method="post" action="{{ url('/api/tickets') }}" class="ticket-form" enctype="multipart/form-data"
              hx-post="{{ url('/api/tickets') }}"
              hx-swap="outerHTML"
              hx-target="#ticket-create-container">
            @csrf
            <label for="client_email">Adresse e-mail du client:</label>
            <input type="email" id="client_email" name="client_email" placeholder="Adresse e-mail du client" required><br>

            <label for="problem_category_id">Catégorie de problème:</label>
            <select name="problem_category_id" required>
                <option value="">Sélectionnez une catégorie de problème</option>
                @foreach ($problemCategories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select><br>

            <label for="object">Objet:</label>
            <input type="text" id="object" name="object" placeholder="Objet du ticket" required><br>

            <label for="content">Contenu:</label>
            <textarea id="content" name="content" placeholder="Contenu du ticket" required></textarea><br>

            <label for="uploaded_files">Fichiers joints:</label>
            <input type="file" id="uploaded_files" name="uploaded_files[]" multiple><br>

            <button type="submit">Enregistrer</button>
        </form>
    </div>

    <!-- Include HTMX library -->
    <script src="https://unpkg.com/htmx.org@1.6.1"></script>
</body>
</html>
