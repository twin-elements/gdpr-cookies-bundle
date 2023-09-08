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
If you want to change the default route to your own, enter it in the package configuration
```
twin_elements_gdpr_cookies:
    cookies_policy_route: your_route_name
```
in `webpack.config.js` create alias for root dir: 
```
const rootDir = path.resolve(__dirname, '');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('common', './assets/js/app.js')
;

const frontConfig = Encore.getWebpackConfig();
frontConfig.resolve.alias['root-dir'] = rootDir;
frontConfig.name = 'frontConfig';

Encore.reset();
```

Import `cookies.js`

```import 'root-dir/public/bundles/twinelementsgdprcookies/js/cookies';```

##How it use?

For marketing codes

```{% if isMarketingAccepted() %}{% endif %}```

Form analytics codes

```{% if isAnalyticsAccepted() %}{% endif %}```

In base template add

```<div id="cookies-base-container"></div>```

To overwrite translations, create a `cookies.LOCALE.yaml` file and enter your own translations
