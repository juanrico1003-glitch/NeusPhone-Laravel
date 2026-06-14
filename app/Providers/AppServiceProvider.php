<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Override @vite to use the current request's scheme and host
        Blade::directive('vite', function ($expression) {
            // Get the manifested files using Laravel's default vite resolution
            $files = eval("return {$expression};");
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
            
            $html = '';
            foreach ((array)$files as $file) {
                if (isset($manifest[$file])) {
                    $entry = $manifest[$file];
                    $filePath = '/build/' . $entry['file'];
                    
                    if (str_ends_with($filePath, '.css')) {
                        $html .= "<link rel=\"stylesheet\" href=\"{$filePath}\" />";
                    } elseif (str_ends_with($filePath, '.js')) {
                        $html .= "<script type=\"module\" src=\"{$filePath}\"></script>";
                    }
                }
            }
            return $html;
        });
    }
}
