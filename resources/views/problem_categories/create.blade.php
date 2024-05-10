@extends('companies.dashboard')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <title>Register Problem Category</title>
    <link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
</head>

<body>
    <div class="container">
        <div class="right-section">
            <form action="{{ route('problem_categories.store') }}" class="sign-up-form" method="post">
                @csrf
                <h2 class="title">Register Problem Category</h2>
                <div class="input-field">
                    <i class="fas fa-align-left"></i>
                    <input type="text" name="name" placeholder="Category Name" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-info-circle"></i>
                    <input type="text" name="description" placeholder="Description" required />
                </div>
                {{-- <div class="input-field">
                    <i class="fas fa-toggle-on"></i>
                    <select name="is_active">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div> --}}
                <div class="input-field">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <select name="code_priority">
                        <option value=""  disabled>Code Priority</option>
                        @foreach($priorities as $priority)
                        <option value="{{ $priority->code_priority }}">{{ $priority->name_priority }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="input-field">
                    <i class="fas fa-layer-group"></i>
                    <select name="application_id" required>
                        @foreach($applications as $application)
                        <option value="{{ $application->id }}">{{ $application->app_name }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="submit" class="btn" value="Register" />
            </form>
        </div>
    </div>
</body>

</html>
@endsection
