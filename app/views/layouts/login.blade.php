<!DOCTYPE html>
<html>
    <head>
        <title>Lets´scom</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0, user-scalable=no">
        <link href='{{ URL::to('css/fonts.css') }}' rel='stylesheet' type='text/css'>
        <link rel="icon" type="image/png" href="{{ URL::to('img/favicon_lets.png') }}" />
        {{ HTML::style('css/login.css') }}
    </head>
    <body>
        
        <div class="main-wrap">
            <div class="header">
                <img src="{{ URL::to('img/letscom.gif') }}" width="200" class="logo" />
                <div class="clear"></div>
            </div><!-- .header -->

            <div>@yield('content')</div>
            
            <div class="footer">
                <!-- <div class="dev">
                    <p>Desenvolvido por</p>
                    <a href="http://www.worktab.com.br" target="_blank">
                        <img src="{{ URL::to('img/worktab.png') }}" width="100" />
                    </a>
                </div> -->
                <p>Let´scom &copy; <?=date('Y');?> - Todos os direitos reservados</p>
            </div><!-- footer -->
        </div><!-- .main-wrap -->

    </body>
</html>