@extends('companies.dashboard')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <title>Update Problem Category</title>
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
</head>

<body>
    <div class="container">
        <div class="right-section">
            <form action="{{route('problem_categories.update',$problem_category)}}" class="sign-up-form" method="post">
                @csrf
                @method('PUT')
                <h2 class="title">Update Problem Category</h2>
                <div class="input-field">
                    <i class="fas fa-align-left"></i>
                    <input type="text" name="name" placeholder="Category Name" value="{{ $problem_category->name }}" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-info-circle"></i>
                    <input type="text" name="description" placeholder="Description" value="{{ $problem_category->description }}" required />
                </div>
                <div class="input-field">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <select name="code_priority">
                        <option value="" disabled>Code Priority</option>
                        @foreach($priorities as $priority)
                            <option value="{{ $priority->code_priority }}" {{ $priority->code_priority == $problem_category->code_priority ? 'selected' : '' }}>{{ $priority->name_priority }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-field">
                    <i class="fas fa-layer-group"></i>
                    <select name="application_id" required>
                        @foreach($applications as $application)
                            <option value="{{ $application->id }}" {{ $application->id == $problem_category->application_id ? 'selected' : '' }}>{{ $application->app_name }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="submit" class="btn" value="Update" />
            </form>
        </div>
    </div>
</body>

</html>
@endsection
