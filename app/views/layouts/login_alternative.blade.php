<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1, user-scalable=no"/>
{{ HTML::style('css/default.css') }}

@yield('styles') 

{{ 
    HTML::script('js/jquery-1.11.2.js'),
    HTML::script('js/jquery.mask.min.js'),
    HTML::script('js/default.js')
}}

@yield('scripts')

<title>WorkTab</title>
</head>
<body>
    <div class='login'>

        <div class='header-login'>
            <img class='logo-izabela' src="{{ URL::to("img/pbh.png") }}" />
            <div class='clear'></div>
        </div><!-- .header-login -->

        <div>@yield('content')</div>

        <div class='footer-login'>
            <a href="https://cardvantagens.com.br" target="_blank">
                <img src='{{ URL::to("img/cv.png") }}' style="float:left;margin-left:50px" />
            </a>
            <div class="footer-login-logos"></div>
        </div>
        <div class='footer-login-mobile'>
            <div class='creditos'>
                <p class='p-termos'>Termos de Uso | Política de Privacidade</p>
                <p class='p-empresa'><b>© 2014 GrupoTMT.com.br. Todos os direitos reservados.</b></p>
            </div>
            <img src='{{ URL::to("img/site-seguro.png") }}' class='footer-site-seguro-img'/>
        </div>
        <!--footer-login-->

    </div>
    <!--login-->
</body>
</html>