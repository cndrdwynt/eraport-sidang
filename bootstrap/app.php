<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // ATURAN 1: Jika orang BELUM LOGIN memaksa masuk
        $middleware->redirectGuestsTo(function (Request $request) {
            // Jika dia mencoba mengakses URL yang depannya "mahasiswa"
            if ($request->is('mahasiswa*')) {
                return route('mahasiswa.login'); // Lempar ke login mahasiswa
            }
            // Selain itu, lempar ke login dosen
            return route('login'); 
        });

        // ATURAN 2: Jika orang SUDAH LOGIN tapi iseng mau buka halaman login lagi
        $middleware->redirectUsersTo(function (Request $request) {
            // Jika yang login adalah mahasiswa, kembalikan ke beranda mahasiswa
            if (Auth::guard('mahasiswa')->check()) {
                return route('mahasiswa.dashboard');
            }
            // Jika yang login adalah dosen, kembalikan ke beranda dosen
            if (Auth::guard('web')->check()) {
                return route('dashboard'); 
            }
            return '/';
        });

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();