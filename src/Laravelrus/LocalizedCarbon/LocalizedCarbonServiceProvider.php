<?php namespace Laravelrus\LocalizedCarbon;

use Illuminate\Support\ServiceProvider;

class LocalizedCarbonServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('difffactory', function() {
			return new DiffFormatterFactory();
		});
	}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->loadTranslationsFrom(__DIR__.'/../../lang', 'localized-carbon');

		$this->publishes([
			__DIR__.'/../../lang' => base_path('resources/lang'),
		]);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('difffactory');
	}

}
