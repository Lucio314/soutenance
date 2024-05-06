@extends('companies.dashboard')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <title>Register Technician</title>
    <link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
</head>

<body>
    <div class="container">
        <div class="right-section">
            <form action="{{route('register')}}" class="sign-up-form" method="post">
                @csrf
                <h2 class="title">Register Technician</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" value="{{old('name','')}}" placeholder="Username" autofocus />
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" />
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" />
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        placeholder="Confirm password" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-align-left"></i>
                    <select name="problem_category_id[]" multiple required>
                        <option  disabled>Problem Categories</option>
                        @foreach($problem_categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="role" id="role" value="technician">
                <input type="hidden" name="company_id" id="role" value="{{Auth::user()->company->id}}">
                <input type="submit" class="btn" value="Register" />
            </form>
        </div>
    </div>
    <script src="{{asset('assets/js/script.js')}}"></script>
</body>

</html>
@endsection
