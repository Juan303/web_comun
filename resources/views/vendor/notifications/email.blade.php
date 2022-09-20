<!--
    PLantilla para las notificaciones
    -Link para recuperar contraseña
    -Link para activar usuario
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <!-- Poner Cabecera aquí-->
                <tr>
                    <td class="header">
                        <a style="display: inline-block;" href="{{ config('app.url') }}">{{ env('APP_NAME') }}</a>
                        <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
                    </td>
                </tr>
            <!-- Email Body -->
                <tr>
                    <td class="body" width="100%" cellpadding="0" cellspacing="0">
                        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                            <!-- Contenido -->
                            <tr>
                                <td class="content-cell">

                                    @foreach ($introLines as $line)
                                        <p>{{ $line }}</p>
                                    @endforeach
                                    @isset($actionText)
                                        <?php
                                        switch ($level) {
                                            case 'success':
                                            case 'error':
                                                $color = $level;
                                                break;
                                            default:
                                                $color = 'primary';
                                        }
                                        ?>
                                        @component('mail::button', ['url' => $actionUrl, 'color' => $color])
                                            {{ $actionText }}
                                        @endcomponent
                                    @endisset
                                    @foreach ($outroLines as $line)
                                        <p>{{ $line }}</p>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- Poner Pié aquí-->
                <tr>
                    <td>
                        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td class="content-cell" align="center">
                                    © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
