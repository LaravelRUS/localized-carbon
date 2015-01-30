# Localized Carbon

See also [localized documentation](docs)

+ [Introduction](#intro)
+ [Usage](#usage)
+ [Supported languages](#languages)
+ [Installation](#installation)
+ [Extending](#extending)
+ [Contributing](#contributing)

<a name="intro"></a>
## Introduction

Localized Carbon is an extension of a popular Carbon package, designed specially for Laravel framework. By localization I mean its `diffForHumans` function, which returns a human-readable string of time interval. This package also supports genitive months by introducing the "%f" key in `formatLocalized` method.

<a name="usage"></a>
## Usage

This package provides a `LocalizedCarbon` class which inherits original Carbon, so its usage is absolutely the same as original Carbon's.

But imagine you have a `Comment` model for example, which has default timestamp fields (`created_at` and `updated_at`). You want to display, how much time has gone since its `created_at` in a human-readable format. One way to achieve may be such (in your Blade template):

```
{{ LocalizedCarbon::instance($comment->created_at)->diffForHumans() }}
```

In this case the class will output something like "5 minutes ago". Note that for just an English version of the string original Carbon would be enough. This `LocalizedCarbon` is used to display the message in the current application language. For example, for Russian language it will display "5 минут назад".

But also, you may substitute Laravel's Eloquent model, so the timestamps would be converted to `LocalizedCarbon` instead of original `Carbon`. So the usage could be as if your were using original Carbon:

```
{{ $comment->created_at->diffForHumans() }}
```

As in original Carbon, `diffForHumans` functions has an optional first argument (which is another Carbon instance). It specified the time to which difference should be calculated. By default (a missing or `null` value) current time is used.

Also `LocalizedCarbon` adds an optional second argument, in which you may specify the desired language, or directly a `formatter` class which is used to format the difference-string (see [extending Localized Carbon](#extending)). By default current application language is used. Also you may specify a Closure in the second parameter which will do formatting. For its signature refer to [extending Localized Carbon](#extending) section.

<a name="languages"></a>
## Supported languages

Current version of Localized Carbon ships with these localizations:

+ English (en) (full)
+ Russian (ru) (full)
+ Ukrainian (uk) (full)
+ Dutch (nl) (no genitive)
+ Spanish (es) (no genitive)
+ Portuguese (pt) (no genitive)
+ French (fr) (no genitive)
+ Bulgarian (bg) (no genitive)
+ Slovakian (sk) (no genitive)
+ Turkish (tr) (no genitive)
+ Arabic (ar) (no genitive)

But it is extendable, so you may write and use your own localization without altering the contents of the package. See [extending Localized Carbon](#extending).

<a name="installation"></a>
## Installation

Add the following requirement to your `composer.json`: `"laravelrus/localized-carbon": "1.*"` and then run `composer update`.

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

If you want to use the power of `LocalizedCarbon` the same way as you did with original `Carbon` in your models, you may want to use supplied trait for this in your models:

```
use \Laravelrus\LocalizedCarbon\Traits\LocalizedEloquentTrait;
```

In this case `LocalizedCarbon` will be used for all dates in your Eloquent model instead of original `Carbon`.

Note that this method is actual for PHP versions 5.4 and higher.

If you are still using PHP 5.3.7 you can substitute Laravel's Eloquent class by `Laravelrus\LocalizedCarbon\Models\Eloquent` supplied with this package. To do this you can either inherit this class directly, or make an alias to it instead of originial Eloquent in `app\config\app.php`.

<a name="extending"></a>
## Extending Localized Carbon

If needed localization is not shipped with this package, you may write your own and extend Localized Carbon with it, not even touching the vendor folder itself.

There are a couple of ways to extend Localized Carbon.

First, you may write your own `DiffFormatter` class for this, implementing `Laravelrus\LocalizedCarbon\DiffFormatters\DiffFormatterInterface`. This interface forces the class to have a single `format` method which looks like this:

```
public function format($isNow, $isFuture, $delta, $unit);
```

`$isNow` is a boolean, which is `true` when the time difference is calculated relevant to current time.
`$isFuture` is boolean, which is `true` if the DateTime object is in the future relevant to comparable time.
`$delta` is an integer, equals to number of units of difference.
`$unit` is a time-"unit". It can be either: `second`, `minute`, `hour`, `day`, `week`, `month` or `year`.

So, your `format` method should return a string based on this arguments. As an example see an existing DiffFormatters in `vendor\laravelrus\localized-carbon\src\Laravelrus\LocalizedCarbon\DiffFormatters` directory. You can also reference a lang-files, using `Lang::choice` as it is done in Russian localization for example.

When your class is ready, you must register it within the Localized Carbon. For this you must call `DiffFormatter::extend` method from within any file which is loaded by the framework. For example, you can do it somewhere in `app/start/global.php`.

The `extend` method expects two parameters: first is the language you want to be supported (most often it would be `App::getLocale()` if you want just to use application's language). Next is the instance of your formatter, OR just a name of the class if it can be autoloaded. Consider these examples:

```
$formatter = new Acme\DiffFormatters\FrDiffFormatter;
DiffFormatter::extend('fr', $formatter);

// OR

DiffFormatter::extend('fr', 'Acme\\DiffFormatters\\FrDiffFormatter');
```

In the latter case the formatter will be autoloaded when it is needed using IoC. Also note that formatter is loaded only once during application life-cycle due to optimization considerations.

The second way to extend is to pass a Closure as the second parameter. It must have the same signature as the `format` method of `DiffFormatterInterface` interface. For example:

```
DiffFormatter::extend('fr', function($isNow, $isFuture, $delta, $unit) {
    return 'Some formatter diff string!';
});
```

Also, there is a possibility to add an alias for an existing language. For example, Localized Carbon is shipped with Ukranian localization, which is recognized by `uk` language key. But what if your application uses `ua` or `ukr` language, which still means it is Ukranian? In this case you may add an alias for `uk` language in this way:

```
DiffFormatter::alias('ukr', 'uk');
```

<a name="contributing"></a>
## Contributing

If you've written a formatter for the language which is not supported by current version of Localized Carbon out of the box - feel free to make a pull request with it in the current version branch (1.3), but be sure to adjust your formatter for been used by the package.

The formatter should lie in `src/Laravelrus/LocalizedCarbon/DiffFormatters` directory, following a simple naming convention: the class name should start with the desired language in lower-case, but the first letter in upper-case. The rest part of the name should be "DiffFormatter". The file name should correspond to the class name.

For example, the formatter for `fr` language would lie in `src/Laravelrus/LocalizedCarbon/DiffFormatters/FrDiffFormatter.php`, and the class name would be `FrDiffFormatter`.

Also I need the help of the community to complete the list of genitives for all supported languages. If you know a language and it uses genitives in dates, feel free to contribute. See an example of Russian or Ukranian `lang\XX\months.php` files.