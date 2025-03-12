<?php

use App\Livewire\Auth\Login;
use App\Livewire\Users\ViewUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('login');
Route::post('/logout', function () {
    Auth::logout();
})->name('logout');

// Route::group(['middleware' => ['auth', 'is_approver']], function () {
    Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return view('pages.dashboard.dashboard');
    })->name('dashboard');
    Route::get('/', function () {
        return view('pages.dashboard.dashboard');
    })->name('dashboard');

    Route::prefix('users')->group(function () {
        Route::get('list', function () {
            return view('pages.users.index');
        })->name('users.index');

        Route::get('edit-user/{id}', function ($id) {
            return view('pages.users.edit', compact('id'));
        })->name('users.edit');

        Route::get('create-user', function () {
            return view('pages.users.create');
        })->name('users.create');

        Route::get('view-user/{id}', ViewUser::class)->name('users.view');
    });

    Route::prefix('templates')->group(function () {
        Route::get('list', function () {
            return view('pages.templates.index');
        })->name('templates.index');
        Route::get('edit-template/{id?}', function ($id = null) {
            return view('pages.templates.edit', compact('id'));
        })->name('templates.edit');
        Route::get('view-template/{id}', function ($id) {
            return view('pages.templates.view', compact('id'));
        })->name('templates.view');
    });

    Route::prefix('workflows')->group(function () {
        Route::get('list', function () {
            return view('pages.workflows.index');
        })->name('workflows.index');
        Route::get('create-workflow', function () {
            return view('pages.workflows.create');
        })->name('workflows.create');
        Route::get('edit-workflow/{id}', function ($id) {
            return view('pages.workflows.edit', compact('id'));
        })->name('workflows.edit');
        Route::get('view-workflow/{id}', function () {
            return view('pages.workflows.view');
        })->name('workflows.view');
    });

    Route::prefix('rules')->group(function () {
        Route::get('list', function () {
            return view('pages.validation-rules.index');
        })->name('vr.index');

        Route::get('edit/{id?}', function ($id = null) {
            return view('pages.validation-rules.edit', compact('id'));
        })->name('vr.edit');

        Route::get('create', function () {
            return view('pages.validation-rules.create');
        })->name('vr.create');
        Route::get('view-validation-rule/{id}', function () {
            return view('pages.validation-rules.view');
        })->name('vr.view');
    });

    Route::prefix('data')->group(function () {
        Route::get('validation/{id}', function ($id) {
            return view('pages.data.validation', compact('id'));
        })->name('data.validation');
        Route::get('approval/{id}', function ($id) {
            return view('pages.data.approval', compact('id'));
        })->name('data.approval');
        Route::get('integration/{id}', function ($id) {
            return view('pages.data.integration', compact('id'));
        })->name('data.integration');
        Route::get('archival/{id}', function ($id) {
            return view('pages.data.archival', compact('id'));
        })->name('data.archival');


        // Route::get('edit/{id}', function ($id = null) {
        //     return view('pages.validation-rules.edit', compact('id'));
        // })->name('vr.edit');
        // Route::get('create', function () {
        //     return view('pages.validation-rules.create');
        // })->name('vr.create');
        // Route::get('view-validation-rule/{id}', function(){
        //     return view('pages.validation-rules.view');
        // })->name('vr.view');
    });

    Route::get('/system-logs', function () {
        return view('pages.system-logs.index');
    })->name('system-logs');

    Route::get('/roles', function () {
        return view('pages.roles.index');
    })->name('roles');

    Route::get('/roles/create', function () {
        return view('pages.roles.create');
    })->name('roles.create');

    Route::get('/roles/{id}', function ($id) {
        return view('pages.roles.edit', compact('id'));
    })->name('roles.edit');

    Route::get('/notifications', function () {
        return view('pages.notifications.notifications');
    })->name('notifications');
});
