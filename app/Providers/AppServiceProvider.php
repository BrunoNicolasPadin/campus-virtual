<?php

namespace App\Providers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Inertia::share('app.name', config('app.name'));
        Inertia::share('flash', function () {
            return [
                'successMessage' => Session::get('successMessage'),
            ];
        });
        Inertia::share('errors', function () {
            return Session::get('errors') ? Session::get('errors')->getBag('default')->getMessages() : (object) [];
        });

        $this->registerLengthAwarePaginator();
    }

    protected function registerLengthAwarePaginator()
    {
        $this->app->bind(LengthAwarePaginator::class, function ($app, $values) {
            return new class(...array_values($values)) extends LengthAwarePaginator {
        
                public function only(...$attributes)
                {
                    return $this->transform(function ($item) use ($attributes) {
                        return $item->only($attributes);
                    });
                }

                public function transform($callback)
                {
                    $this->items->transform($callback);
                    return $this;
                }

                public function toArray()
                {
                    return [
                            'data' => $this->items->toArray(),
                            'links' => $this->links(),
                        ];
                }
        
                public function links($view = null, $data = [])
                {
                    $this->appends(Request::all());
                    $window = UrlWindow::make($this);
                    $elements = array_filter([
                        $window['first'],
                        is_array($window['slider']) ? '...' : null,
                        $window['slider'],
                        is_array($window['last']) ? '...' : null,
                        $window['last'],
                    ]);

                    return Collection::make($elements)->flatMap(function ($item) {
        
                        if (is_array($item)) {
                            return Collection::make($item)->map(function ($url, $page) {
                                return [
                                        'url' => $url,
                                        'label' => $page,
                                        'active' => $this->currentPage() === $page,
                                        ];
                            });
                        } 
                        else {
                            return [
                                [
                                'url' => null,
                                'label' => '...',
                                'active' => false,
                                ],
                            ];
                        }
                        })->prepend([
                            'url' => $this->previousPageUrl(),
                            'label' => 'Anterior',
                            'active' => false,
                        ])->push([
                            'url' => $this->nextPageUrl(),
                            'label' => 'Posterior',
                            'active' => false,
                        ]);
                }
            };
        });
    }

    public function boot()
    {
        //
    }
}
