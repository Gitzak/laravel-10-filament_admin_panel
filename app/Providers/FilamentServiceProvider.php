<?php

namespace App\Providers;

use App\Filament\Resources\PermissionResource;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            if (\auth()->user()) {
                if (\auth()->user()->is_admin === 1 && \auth()->user()->hasAnyRole(['super-admin', 'admin', 'moderator'])) {
                    Filament::registerUserMenuItems([
                        UserMenuItem::make()
                            ->label('Manager users')
                            ->url(UserResource::getUrl())
                            ->icon('heroicon-s-users'),
                        UserMenuItem::make()
                            ->label('Manager Roles')
                            ->url(RoleResource::getUrl())
                            ->icon('heroicon-s-cog'),
                        UserMenuItem::make()
                            ->label('Manager Permission')
                            ->url(PermissionResource::getUrl())
                            ->icon('heroicon-s-key')
                    ]);
                }
            }
        });
    }
}
