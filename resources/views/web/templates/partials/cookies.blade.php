<script language="javascript" type="text/javascript" src="{{ asset('/js/cookietool.js') }}"></script>
<script language="javascript" type="text/javascript">
    CookieTool.Config.set({
        'link': '/politica-de-cookies',
        'agreetext': '{{ __('cookies.agreeText') }}',
        'declinetext': '{{ __('cookies.declineText') }}',
        'position': 'bottom',
        'message': '{!! __('cookies.message') !!}'
    });
    CookieTool.Event.on('agree', function () {
        CookieTool.Utils.loadScript('https://connect.facebook.net/en_US/fbevents.js');
    });
    CookieTool.Event.on('decline', function () {
        //Analytics+facebook
        var cookiestodelete = ['__utma', '__utmb', '__utmc', '__utmz', '__utmv', '__utmb', '__utmt', '_fbp'],
            i = 0,
            len = cookiestodelete.length,
            domain = window.location.hostname;
        if ((/^www\./).test(domain)) {
            domain = domain.substring(4);
        }

        for (; i < len; i++) {
            CookieTool.Cookie.remove(cookiestodelete[i], domain);
        }
    });
    CookieTool.API.ask();
</script>
