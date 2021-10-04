1.Install

```composer require twin-elements/gdpr-cookies-bundle```

2.in routing.yaml file
```
gdpr_cookies:
    resource: "@TwinElementsGDPRCookiesBundle/Controller/"
    prefix: /
    type: annotation
    requirements:
        _locale: '%app_locales%'
    defaults:
        _locale: '%locale%'
        _admin_locale: '%admin_locale%'
    options: { i18n: false }
```

3.In bundles.php file
```
TwinElements\GDPRCookiesBundle\TwinElementsGDPRCookiesBundle::class => ['all' => true],
```

4. Configuration
If you have created route "cookies_policy" leave package settings (config/packages/twin_elements_gdpr_cookies.yaml) unchanged
```
twin_elements_gdpr_cookies: ~
```
If you want to change the route default route to your own, enter it in the package configuration
```
twin_elements_gdpr_cookies:
    cookies_policy_route: your_route_name
```

How it use?

For marketing codes

```{% if isMarketingAccepted() %}{% endif %}```

Form analytics codes

```{% if isAnalyticsAccepted() %}{% endif %}```

In base template add

```{{ render(controller('TwinElementsGDPRCookiesBundle:Cookies:renderBaseForm')) }}```

In translations.LANG.yaml add
```
translations:    
    cookies: { text: 'Ta strona internetowa chroni twoją prywatność poprzez przestrzeganie EU General Data Protection Regulation (RODO). Nie wykorzystamy Twoich danych w żadnym celu, na który nie wyrażasz zgody. Prosimy o zgodę na korzystanie z anonimowych danych, aby poprawić jakość korzystania z naszej witryny.', accept: 'Akceptuję wszystkie', no_accept: 'Nie akceptuję', read_all: 'Polityka cookies', base_cookies: Niezbędne, base_cookies_desc: 'Te pliki cookie są niezbędne, aby umożliwić Ci poruszanie się po witrynie i korzystanie z jej funkcji oraz zapamiętywanie preferencji. Bez tych plików cookie, witryna nie będzie działać prawidłowo.', analytic_cookies: Analityka, analytic_cookies_desc: 'Przechowamy anonimowe dane w formie zbiorczej na temat odwiedzających i ich doświadczeń na naszej stronie internetowej. Używamy tych danych do naprawiania błędów i poprawy komfortu dla wszystkich odwiedzających.', marketing_cookies: 'Marketing / Pliki cookie innych firm', marketing_cookies_desc: 'Przechowujemy pliki cookies, które umożliwiają sprecyzowanie profilu użytkownika i wyświetlenie mu najbardziej dopasowanych treści reklamowych. Poznanie preferencji gwarantuje największy komfort korzystania z serwisu dla odwiedzających. Informacje te mogą być udostępnione reklamodawcom i/lub sieciom reklamowym.', go_to_settings: 'Przejdź do ustawień' }
```
