<?php

namespace Controller;

use Model\Post;
use Src\View;
use Src\Request;
use Model\User;
use Src\Auth\Auth;
use Model\Document;

class Site
{
    public function index(Request $request): string
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $posts = Post::where('user_id', $request->id)->get();
        return (new View())->render('site.post', ['posts' => $posts]);
    }

    public function edit(Request $request)
    {
        $user = app()->auth::user();

        // Если POST — сохраняем данные
        if ($request->method === 'POST') {
            $document = $user->document;
            if ($document) {
                // Обновляем существующий документ
                $document->update([
                    'inn'             => $request->inn,
                    'snils'           => $request->snils,
                    'payment_account' => $request->payment_account,
                    'tabel_name'      => $request->tabel_name
                ]);
            } else {
                // Если документа нет (на случай ошибки), создаём новый
                $user->document()->create([
                    'inn'             => $request->inn,
                    'snils'           => $request->snils,
                    'payment_account' => $request->payment_account,
                    'tabel_name'      => $request->tabel_name
                ]);
            }
            // Редирект на профиль с сообщением
            app()->route->redirect('/edit');
        }

        return (new View())->render('site.edit', ['user' => $user]);
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.signup');
        }

        // Создаём документ с данными из формы
        $doc = Document::create([
            'inn'             => $request->inn,
            'snils'           => $request->snils,
            'payment_account' => $request->payment_account,
            'tabel_name'      => $request->tabel_name
        ]);

        // Создаём пользователя с привязкой к документу
        $user = User::create([
            'last_name'   => $request->last_name,
            'first_name'  => $request->first_name,
            'surname'     => $request->surname,
            'login'       => $request->login,
            'password'    => $request->password,
            'document_id' => $doc->document_id
        ]);

        if ($user) {
            app()->route->redirect('/login');
        }

        return new View('site.signup', ['message' => 'Ошибка регистрации']);
    }

    public function login(Request $request): string
    {
        //Если просто обращение к странице, то отобразить форму
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        //Если удалось аутентифицировать пользователя, то редирект
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
        }
        //Если аутентификация не удалась, то сообщение об ошибке
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }
    public function hello(): string
    {
        $user = app()->auth::user();
        return new View('site.hello', ['user' => $user]);
    }
}
