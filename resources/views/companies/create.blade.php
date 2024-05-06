<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <title>Register Company</title>
    <link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
</head>

<body>
    <div class="container">
        <div class="left-section">
            <img src="{{asset('assets/img/register.svg')}}" alt="Company Image">
        </div>
        <div class="right-section">
            <form action="{{ route('companies.store') }}" class="sign-up-form" method="post">
                @csrf
                <h2 class="title">Register Company</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="code" placeholder="Company Code" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="cpn_name" placeholder="Company Name" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="cpn_email" placeholder="Company Email" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-phone"></i>
                    <input type="text" name="company_phone" placeholder="Company Phone" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-map-marker-alt"></i>
                    <input type="text" name="cpn_address" placeholder="Company Address" required />
                </div>

                <input type="hidden" name="user_id" value="{{ Auth::id() }}" />
                <input type="submit" class="btn" value="Register" />
            </form>
        </div>
    </div>
    <script src="{{asset('assets/js/script.js')}}"></script>
</body>

</html>
