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
        box-sizing: border-box; /* Ensure padding is included in width */
    }

    /* Styles for form select */
    .ticket-form select {
        width: 100%;
        padding: 8px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        box-sizing: border-box; /* Ensure padding is included in width */
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

<form id="ticket-create-container" method="post" action="http://localhost:8000/api/tickets" class="ticket-form" enctype="multipart/form-data">
    @csrf
    <label for="client_email">Adresse e-mail du client:</label>
    <input type="email" id="client_email" name="client_email" placeholder="Adresse e-mail du client" required>


    <label for="application_id">Application:</label>
    <select name="application_id">
        <option value="">Sélectionnez une application</option>
        @foreach ($applications as $application)
        <option value="{{ $application->id }}">{{ $application->app_name }}</option>
        @endforeach
    </select>


    <label for="problem_category_id">Catégorie de problème:</label>
    <select name="problem_category_id">
        <option value="">Sélectionnez une catégorie de problème</option>
        @foreach ($problemCategories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>

    <label for="object">Objet:</label>
    <input type="text" id="object" name="object" placeholder="Objet du ticket" required>

    <label for="content">Contenu:</label>
    <textarea id="content" name="content" placeholder="Contenu du ticket" required></textarea>


    <label for="uploaded_files">Fichiers joints:</label>
    <input type="file" id="uploaded_files" name="uploaded_files[]" multiple>


    <button type="submit">Enregistrer</button>
</form>
