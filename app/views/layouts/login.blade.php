<!DOCTYPE html>
<html>
    <head>
        <title>WorkTab</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0, user-scalable=no">
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
        <link rel="icon" type="image/png" href="{{ URL::to('img/favicon.png') }}" />
        {{ HTML::style('css/login.css') }}
    </head>
    <body>
        
        <div class="main-wrap">
            <div class="header">
                <img src="{{ URL::to('img/worktab.png') }}" class="logo" />
                <div class="clear"></div>
            </div><!-- .header -->

            <div>@yield('content')</div>
            
            <div class="footer">
                <p>WorkTab &copy; <?=date('Y');?> - Todos os direitos reservados</p>
            </div><!-- footer -->
        </div><!-- .main-wrap -->

    </body>
</html>