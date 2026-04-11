<?php

namespace Controller;

use Model\Post;
use Model\Role;
use Src\View;
use Src\Request;
use Model\User;
use Src\Auth\Auth;
use Model\Document;

use Model\Position;
use Model\Allowance;
use Model\PositionAllowance;


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
        if (!$user) return redirect('/login');

        // Если POST — сохраняем данные
        if ($request->method === 'POST') {
            $document = $user->document;
            if ($document) {
                // Обновляем существующий документ
                $document->update([
                    'inn' => $request->inn,
                    'snils' => $request->snils,
                    'payment_account' => $request->payment_account,
                    'tabel_name' => $request->tabel_name
                ]);
            } else {
                // Если документа нет (на случай ошибки), создаём новый
                $user->document()->create([
                    'inn' => $request->inn,
                    'snils' => $request->snils,
                    'payment_account' => $request->payment_account,
                    'tabel_name' => $request->tabel_name
                ]);
            }
            // Редирект на профиль с сообщением
            app()->route->redirect('/edit');
        }

        return (new View())->render('site.edit', ['user' => $user]);
    }

    public function showRole()
    {
        $user = app()->auth::user();
        return new View('role.show', ['role' => $user->role]);
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.signup');
        }

        // Создаём документ с данными из формы
        $doc = Document::create([
            'inn' => $request->inn,
            'snils' => $request->snils,
            'payment_account' => $request->payment_account,
            'tabel_name' => $request->tabel_name,
        ]);

        // Создаём пользователя с привязкой к документу
        $user = User::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'surname' => $request->surname,
            'login' => $request->login,
            'password' => $request->password,
            'document_id' => $doc->document_id,
            'role_id' => 2,
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
        return new View('site.hello', ['user' => $user, 'role' => $user->role]);
    }

    public function positions()
    {
        $positions = Position::with('positionAllowance.allowance')->get();
        return (new View())->render('site.positions', ['positions' => $positions]);
    }

    public function create_position()
    {
        $allowances = Allowance::all();
        return (new View())->render('site.create_position', ['allowances' => $allowances]);
    }

    public function edit_position(Request $request)
    {
        $position = Position::with('positionAllowance')->find($request->id);
        if (!$position) {
            app()->route->redirect('/positions');
        }
        $allowances = Allowance::all();
        return (new View())->render('site.edit_position', [   // ← исправлено
            'position' => $position,
            'allowances' => $allowances
        ]);
    }
    public function updatePosition(Request $request)
    {
        $position = Position::find($request->id);
        if ($position) {
            $allowanceId = $request->allowance_id;
            $posAllowance = $position->positionAllowance;
            if ($allowanceId) {
                if ($posAllowance) {
                    $posAllowance->update(['allowance_id' => $allowanceId]);
                } else {
                    $new = PositionAllowance::create(['allowance_id' => $allowanceId]);
                    $position->id_allowance_position = $new->id_allowance_position;
                }
            } else {
                if ($posAllowance) {
                    $posAllowance->delete();
                    $position->id_allowance_position = null;
                }
            }
            $position->base_salary = $request->base_salary;
            $position->save();
        }
        app()->route->redirect('/positions');
    }

    public function deletePosition(Request $request)
    {
        $position = Position::find($request->id);
        if ($position) {
            // 1. Обнуляем position_id у всех пользователей, у которых была эта должность
            User::where('position_id', $position->position_id)->update(['position_id' => null]);

            // 2. Если у должности была связанная надбавка – обнуляем ссылку и удаляем запись в position_allowances
            if ($position->positionAllowance) {
                $position->id_allowance_position = null;
                $position->save();
                $position->positionAllowance->delete();
            }

            // 3. Удаляем саму должность
            $position->delete();
        }
        app()->route->redirect('/positions');
    }

    public function storePosition(Request $request)
    {
        $allowanceId = $request->allowance_id;
        $posAllowance = null;
        if ($allowanceId) {
            $posAllowance = PositionAllowance::create(['allowance_id' => $allowanceId]);
        }
        $position = Position::create([
            'base_salary' => $request->base_salary,
            'id_allowance_position' => $posAllowance ? $posAllowance->id_allowance_position : null
        ]);
        // Редирект или страница успеха
        app()->route->redirect('/positions');
    }

    public function users()
    {
        $users = User::with('role', 'position')->get(); // загружаем связи
        return (new View())->render('site.users', ['users' => $users]);
    }

    // Форма создания пользователя
    public function create_users()
    {
        $roles = Role::all();
        $positions = Position::all();
        // Документы не нужны – они создаются автоматически при сохранении
        return (new View())->render('site.create_user', [
            'roles' => $roles,
            'positions' => $positions
        ]);
    }

    // Сохранение нового пользователя
    public function storeUsers(Request $request)
    {
        // Валидация (простая)
        $errors = [];
        if (empty($request->login)) {
            $errors['login'] = 'Логин обязателен';
        } elseif (User::where('login', $request->login)->exists()) {
            $errors['login'] = 'Такой логин уже используется';
        }
        if (empty($request->password)) {
            $errors['password'] = 'Пароль обязателен';
        }
        if (empty($request->first_name)) {
            $errors['first_name'] = 'Имя обязательно';
        }

        $doc = Document::create([
            'inn' => $request->inn,
            'snils' => $request->snils,
            'payment_account' => $request->payment_account,
            'tabel_name' => $request->tabel_name,
        ]);

        // Создаём пользователя с привязкой к документу
        $user = User::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'surname' => $request->surname,
            'login' => $request->login,
            'password' => $request->password,
            'document_id' => $doc->document_id,
            'role_id' => 2,
        ]);

        if (!empty($errors)) {
            return (new View())->render('site.create_user', [
                'errors' => $errors,
                'old' => (array)$request,
                'roles' => Role::all(),
                'positions' => Position::all(),
                'documents' => Document::all()
            ]);
        }

        $data = $request->all();
        User::create($data);

        app()->route->redirect('/users');
    }

    // Форма редактирования пользователя
    public function edit_users(Request $request)
    {
        $user = User::with('document')->find($request->id);
        if (!$user) {
            app()->route->redirect('/users');
        }
        $roles = Role::all();
        $positions = Position::all();
        return (new View())->render('site.edit', [
            'editUser' => $user,
            'roles' => $roles,
            'positions' => $positions
        ]);
    }

    // Обновление пользователя
    public function updateUsers(Request $request)
    {
        $user = User::find($request->id);
        if (!$user) {
            app()->route->redirect('/users');
        }

        $errors = [];

        // Проверка уникальности логина (исключая текущего)
        if ($request->login != $user->login && User::where('login', $request->login)->exists()) {
            $errors['login'] = 'Такой логин уже используется';
        }

        if (!empty($errors)) {
            return (new View())->render('sit.edit', [
                'editUser' => $user,
                'errors' => $errors,
                'roles' => Role::all(),
                'positions' => Position::all()
            ]);
        }

        // Обновляем основные поля
        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->surname = $request->surname;
        $user->login = $request->login;

        // Хэшируем пароль только если он передан
        if (!empty($request->password)) {
            $user->password = md5($request->password);
        }

        $user->role_id = $request->role_id;
        $user->position_id = $request->position_id ?: null;
        $user->save();

        // Обновляем документ
        if ($user->document) {
            $user->document->update([
                'inn' => $request->inn,
                'snils' => $request->snils,
                'payment_account' => $request->payment_account,
                'tabel_name' => $request->tabel_name
            ]);
        } else {
            // Если документа нет – создаём
            $doc = Document::create([
                'inn' => $request->inn,
                'snils' => $request->snils,
                'payment_account' => $request->payment_account,
                'tabel_name' => $request->tabel_name
            ]);
            $user->document_id = $doc->document_id;
            $user->save();
        }

        app()->route->redirect('/users');
    }

    // Удаление пользователя
    public function deleteUsers(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $user->delete();
        }
        app()->route->redirect('/users');
    }



}
