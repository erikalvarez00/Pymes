<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel" style="background-color: #009688;" >
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">Registro</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->nombre }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tbQuestionsList').DataTable({
                "language" : {
                    "url" : "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
        });

        $("#addClause").click(function(){ 
            var contenedor, numAux, fila, campo, boton;

            contenedor = $("#closedAnswersL"); 
            numAux = $("#closedAnswersL > div").length;

            if (numAux < 26) {
                campo ='<div class="col-md-8"><input type="text" class="form-control" name="opciones[]" placeholder="Inciso '+ String.fromCharCode(numAux + 65)+'"></div>';

                boton ='<div class="col-md-4"><input type="button" class="btn btn-danger btn-block" name="borrar[]" value="Eliminar"></div>';

                fila = '<div class="row form-group w-100" id="r_' + numAux + '">' + campo + boton + '</div>';

                $(contenedor).append(fila);
            } else{
                alert('Ha superado el limite de incisos');
            }
        });

        $(":radio[name=typeQuestion]").click(function(){
            var contenedor = $("#closedAnswersL");
            var boton = $("#closedAnswersB");

            if($(this).val() === "3" && $(this).prop("checked", true)){
                contenedor.prop("style", "display: visible;");
                boton.prop("style", "display: visible;");
                $("#closedAnswersL > div > div > :text").prop("required", true);
            }else{
                contenedor.prop("style", "display: none;");
                boton.prop("style", "display: none;");
                $("#closedAnswersL > div > div > :text").prop("required", false);
            }
        });

        $("#closedAnswersL").on("click", ".btn-danger", function(){
            var id, numAux, padre;
            numAux = $("#closedAnswersL > div").length;

            if(numAux > 2){
                id = Number($(this).parent().parent().prop("id").substring(2));

                var estaSeguro = true;

                if($("#r_" + id + " :text").val().trim() !== ''){
                    estaSeguro = confirm('Este campo posee texto ¿Esta seguro que quiere borrarlo?');
                }

                if(estaSeguro){
                    $("#r_" + id).remove();

                    for(var i = id; i + 1 < numAux; i++){
                        $("#r_" + (i + 1) + " > div > :text").prop("placeholder", "Inciso " + String.fromCharCode(i + 65));
                        $("#r_" + (i + 1)).prop("id", "r_" + i);
                    }
                }
            }else{
                alert('Como mínimos dos incisos');
            }
        });

        $("#tbQuestionsList tr td form").on('submit', function(e){
            var estaSeguro = confirm("¿Esta seguro que desea eliminar esta pregunta? Se eliminará toda la información relacionada");

            if(!estaSeguro){
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
