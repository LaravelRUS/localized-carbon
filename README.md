# Localized Carbon

See also [localized documentation](docs)

+ [Introduction](#intro)
+ [Usage](#usage)
+ [Supported languages](#languages)
+ [Extending](#extending)
+ [Contributing](#contributing)

<a name="intro"></a>
## Introduction

Localized Carbon is an extension of a popular Carbon package, designed specially for Laravel framework. By localization I mean its `diffForHumans` function, which returns a human-readable string of time interval.

<a name="usage"></a>
## Usage

Imagine you have a `Comment` model which has default timestamp fields. You want to display, how much time has gone since its `create_at` in a human-readable format. You can achieve it this way in your Blade template:

```
{{ LocalizedCarbon::instance($comment->created_at)->diffForHumans() }}
```

In this case the class will output something like "5 minutes ago". Note that for just an English version of the string original Carbon would be enough. This `LocalizedCarbon` is used to display the message in the current application language. For example, for Russian language it will display "5 минут назад".

As in original Carbon, `diffForHumans` functions has an optional first argument (which is another Carbon instance). It specified the time to which difference should be calculated. By default (a missing or `null` value) current time is used.

Also `LocalizedCarbon` adds an optional second argument, in which you may specify the desired language, or directly a `formatter` class which is used to format the difference-string (see [extending Localized Carbon](#extending)). By default current application language is used.

<a name="languages"></a>
## Supported languages

Current version of Localized Carbon ships with two localizations:

+ English
+ Russian

But it is extendable, so you may write and use your own localization without altering the contents of the package. See [extending Localized Carbon](#extending).

## Installation

Add the following requirement to your `composer.json`: `"laravelrus/localized-carbon": "dev-master"`.

Next, add package's Service Provider to `app/config/app.php` in `providers` section:

```
    'Laravelrus\LocalizedCarbon\LocalizedCarbonServiceProvider',
```

After that you may want to add some Aliases (`aliases` section of the same config):

```
        'LocalizedCarbon'   => 'Laravelrus\LocalizedCarbon\LocalizedCarbon',
        'DiffFormatter'     => 'Laravelrus\LocalizedCarbon\DiffFactoryFacade',
```

Note that `DiffFormatter` will only be used for extending default localizations. See [extending Localized Carbon](#extending).

<a name="extending"></a>
## Extending Localized Carbon

If needed localization is not shipped with this package, you may write your own and extend Localized Carbon with it, not even touching the vendor folder itself.

For this you should first write your `DiffFormatter` class, implementing `Laravelrus\LocalizedCarbon\DiffFormatters\DiffFormatterInterface`. This interface forces the class to have a single `format` method which looks like this:

```
public function format($isNow, $isFuture, $delta, $unit);
```

`$isNow` is a boolean, which is `true` when the time difference is calculated relevant to current time.
`$isFuture` is boolean, which is `true` if the DateTime object is in the future relevant to comparable time.
`$delta` is an integer, equals to number of units of difference.
`$unit` is a time-"unit". It can be either: `second`, `minute`, `hour`, `day`, `week`, `month` or `year`.

So, your `format` method should return a string based on this arguments. As an example see an existing DiffFormatters in `vendor\laravelrus\localized-carbon\src\Laravelrus\LocalizedCarbon\DiffFormatters` directory. You can also reference a lang-files, using `Lang::choice` as it is done in Russian localization for example.

When your class is ready, you must register it within the Localized Carbon. For this you must call `DiffFormatter::extend` method from within ane file which is loaded by the framework. For example, you can do it somewhere in `app/start/global.php`.

The `extend` method expects two parameters: first is the language you want to be supported (most often it would be `App::getLocale()` if you want just to use application's language). Next is the instance of your formatter, OR just a name of the class if it can be autoloaded. Consider these examples:

```
$formatter = new Acme\DiffFormatters\FrDiffFormatter;
DiffFormatter::extend('fr', $formatter);

// OR

DiffFormatter::extend('fr', 'Acme\\DiffFormatters\\FrDiffFormatter');
```

In the latter case the formatter will be autoloaded when it is needed using IoC. Also note that formatter is loaded only once during application life-cycle due to optimization considerations.

<a name="contributing"></a>
## Contributing

If you've written a formatter for the language which is not supported by current version of Localized Carbon out of the box - feel free to make a pull request with it, but be sure to adjust your formatter for been used by the package.

The formatter should lie in `src/Laravelrus/LocalizedCarbon/DiffFormatters` directory, following a simple naming convention: the class name should start with the desired language in lower-case, but the first letter in upper-case. The rest part of the name should be "DiffFormatter". The file name should correspond to the class name.

For example, the formatter for `fr` language would lie in `src/Laravelrus/LocalizedCarbon/DiffFormatters/FrDiffFormatter.php`, and the class name would be `FrDiffFormatter`.