<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
    <title>Inscription et Connexion</title>
</head>

<body>
    <div class="container">

        <div class="forms-container">
            <div class="signin-signup">
                <!-- Session Status -->
                @if (session('status'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('status') }}
                </div>
                @endif
                <form action="{{route('login')}}" class="sign-in-form" method="POST">
                    @csrf
                    <h2 class="title">Se connecter</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" name="email" value="{{old('email','')}}" placeholder="Email" />
                        @error('email')
                        {{$message}}
                        @enderror
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="mot de passe" />
                    </div>
                    <a href="{{ route('password.request') }}">Mot de passe oublié?</a>

                    <input type="submit" value="Se connecter" class="btn solid" />
                    <p class="social-text">Se connecter une plateforme sociale</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </form>
                <form action="{{route('register')}}" class="sign-up-form" method="post">
                    @csrf
                    <h2 class="title">S'inscrire</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" value="{{old('name','')}}" placeholder="Nom" autofocus />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="mot de passe" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            placeholder="Confirmer mot de passe" required />
                    </div>
                    <input type="submit" class="btn" value="S'inscrire" />
                    <p class="social-text">Ou s'inscrire avec une platforme sociale</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Nouveau ici?</h3>
                    <p>
                        Cliquer sur s'inscrire pour creer un nouveau compte utilisateur.
                    </p>
                    <button class="btn transparent" id="sign-up-btn">
                        S'inscrire
                    </button>
                </div>
                <img src="{{asset('assets/img/log.svg')}}" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>De retour ?</h3>
                    <p>
                        Vueiilez inserer vos informations pour acceder a votre compte
                    </p>
                    <button class="btn transparent" id="sign-in-btn">
                        Se connecter
                    </button>
                </div>
                <img src="{{asset('assets/img/register.svg')}}" class="image" alt="" />
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/script.js')}}"></script>
</body>

</html>