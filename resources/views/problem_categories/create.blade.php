@extends('companies.dashboard')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <title>Register Problem Category</title>
<<<<<<< HEAD
    <link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
=======
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body,
        input,
        select {
            font-family: "Poppins", sans-serif;
        }

        .container {
            display: flex;
            flex-direction: row;
            width: 100%;
            min-height: 100vh;
            background-color: #f4f7f6;
        }

        .right-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .sign-up-form {
            width: 100%;
            max-width: 500px;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .input-field {
            max-width: 380px;
            width: 100%;
            background-color: #f0f0f0;
            margin: 0px 30px 10px 9%;
            height: 55px;
            border-radius: 55px;
            display: grid;
            grid-template-columns: 15% 85%;
            padding: 0 0.4rem;
            position: relative;
        }

        .input-field i {
            text-align: center;
            line-height: 55px;
            color: #acacac;
            transition: 0.5s;
            font-size: 1.1rem;
        }

        .input-field input, .input-field select {
            background: none;
            outline: none;
            border: none;
            line-height: 1;
            font-weight: 600;
            font-size: 1.1rem;
            color: #333;
        }

        .input-field input::placeholder, .input-field select::placeholder {
            color: #aaa;
            font-weight: 500;
        }

        .btn {
            width: 150px;
            background-color: #5995fd;
            border: none;
            outline: none;
            height: 49px;
            border-radius: 49px;
            color: #fff;
            text-transform: uppercase;
            font-weight: 600;
            margin-left: 25%;
            cursor: pointer;
            transition: 0.5s;
        }

        .btn:hover {
            background-color: #4d84e2;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .right-section {
                padding: 20px 10px;
            }

            .btn {
                margin-left: 0;
            }

            .input-field {
                margin: 10px 0;
            }
        }
    </style>
>>>>>>> 7300c5caa7056006324d5c9a26a6f8206b730999
</head>

<body>
    <div class="container">
        <div class="right-section">
<<<<<<< HEAD
            <form action="{{ route('problem_categories.store') }}" class="sign-up-form" method="post">
=======
            <form action="{{ route('problem-categories.store') }}" class="sign-up-form" method="post">
>>>>>>> 7300c5caa7056006324d5c9a26a6f8206b730999
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
<<<<<<< HEAD
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

=======
                <div class="input-field">
                    <i class="fas fa-toggle-on"></i>
                    <select name="is_active" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
>>>>>>> 7300c5caa7056006324d5c9a26a6f8206b730999
                <div class="input-field">
                    <i class="fas fa-layer-group"></i>
                    <select name="application_id" required>
                        @foreach($applications as $application)
<<<<<<< HEAD
                        <option value="{{ $application->id }}">{{ $application->app_name }}</option>
=======
                            <option value="{{ $application->id }}">{{ $application->app_name }}</option>
>>>>>>> 7300c5caa7056006324d5c9a26a6f8206b730999
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
