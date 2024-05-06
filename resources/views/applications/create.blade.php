@extends('companies.dashboard')
@section('content')


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <title>Register Company</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body,
        input {
            font-family: "Poppins", sans-serif;
        }

        .container {
            display: flex;
            flex-direction: row;
            width: 100%;
            min-height: 100vh;
            background-color: #f4f7f6;
        }

        .left-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 0%;
            border-radius: 31% 69% 23% 77% / 66% 18% 82% 34%;
            background: #5995fd;
        }

        .left-section img {
            width: 80%;
            max-width: 400px;
            height: auto;
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

        .input-field input {
            background: none;
            outline: none;
            border: none;
            line-height: 1;
            font-weight: 600;
            font-size: 1.1rem;
            color: #333;
        }

        .input-field input::placeholder {
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

            .left-section {
                height: 40vh;
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
</head>


<body>
    <div class="container">

        <div class="right-section">
            <form action="{{ route('applications.store') }}" class="sign-up-form" method="post">
                @csrf
                <h2 class="title">Register Application</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="app_name" placeholder="Application Name" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-info-circle"></i>
                    <input type="text" name="description" placeholder="Description" required />
                </div>
              
                <div class="input-field">
                    <i class="fas fa-unlock"></i>
                    <input type="text" name="unique_code" placeholder="Unique Code" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="app_email" placeholder="Application Email" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-phone"></i>
                    <input type="text" name="app_phone" placeholder="Application Phone" required />
                </div>
                <!-- Ajoutez un champ caché pour l'ID de la société -->
                <input type="hidden" name="company_id" value="{{ $company->id }}" />
                <input type="submit" class="btn" value="Register" />
            </form>
        </div>
    </div>
    <script src="{{asset('assets/js/script.js')}}"></script>
</body>

</html>
@endsection
