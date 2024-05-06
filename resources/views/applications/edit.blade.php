@extends('companies.dashboard')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <title>Update Application</title>
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
</head>

<body>
    <div class="container">
        <div class="right-section">
            <form action="{{ route('applications.update', $application) }}" class="sign-up-form" method="post">
                @csrf
                @method('PUT')
                <h2 class="title">Update Application</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="app_name" placeholder="Application Name" value="{{ $application->app_name }}" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-info-circle"></i>
                    <input type="text" name="description" placeholder="Description" value="{{ $application->description }}" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-unlock"></i>
                    <input type="text" name="unique_code" placeholder="Unique Code" value="{{ $application->unique_code }}" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="app_email" placeholder="Application Email" value="{{ $application->app_email }}" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-phone"></i>
                    <input type="text" name="app_phone" placeholder="Application Phone" value="{{ $application->app_phone }}" required />
                </div>
                <input type="submit" class="btn" value="Update" />
            </form>
        </div>
    </div>
</body>

</html>
@endsection
