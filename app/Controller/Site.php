<?php

namespace Controller;

use Model\Post;
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

        if (!isset($user->role) || $user->role->role_name !== 'admin') {
            die('У вас нет прав для редактирования документов');
        }

        if ($request->method === 'POST') {
            $document = $user->document;
            if ($document) {
                $document->update([
                    'inn' => $request->inn,
                    'snils' => $request->snils,
                    'payment_account' => $request->payment_account,
                    'tabel_name' => $request->tabel_name
                ]);
            } else {
                $user->document()->create([
                    'inn' => $request->inn,
                    'snils' => $request->snils,
                    'payment_account' => $request->payment_account,
                    'tabel_name' => $request->tabel_name
                ]);
            }
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

        $doc = Document::create([
            'inn' => $request->inn,
            'snils' => $request->snils,
            'payment_account' => $request->payment_account,
            'tabel_name' => $request->tabel_name,
        ]);

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

    public function positions(Request $request)
    {
        $action = $_GET['action'] ?? 'list';

        // Список
        if ($action === 'list') {
            $positions = Position::with('positionAllowance.allowance')->get();
            // Временный прямой инклуд для диагностики
            return (new View())->render('positions', ['mode' => 'list', 'positions' => $positions]);
        }

        // Форма создания
        if ($action === 'create') {
            $allowances = Allowance::all();
            return (new View())->render('positions', ['mode' => 'create', 'allowances' => $allowances]);
        }

        // Сохранение
        if ($action === 'store') {
            $allowanceId = $_POST['allowance_id'] ?? null;
            $posAllowance = null;
            if ($allowanceId) {
                $posAllowance = PositionAllowance::create(['allowance_id' => $allowanceId]);
            }
            Position::create([
                'base_salary' => $_POST['base_salary'],
                'id_allowance_position' => $posAllowance ? $posAllowance->id_allowance_position : null
            ]);
            app()->route->redirect('/positions');
        }

        // Форма редактирования
        if ($action === 'edit') {
            $position = Position::with('positionAllowance')->find($_GET['id']);
            if (!$position) {
                app()->route->redirect('/positions');
            }
            $allowances = Allowance::all();
            return (new View())->render('positions', [
                'mode' => 'edit',
                'position' => $position,
                'allowances' => $allowances
            ]);
        }

        // Обновление
        if ($action === 'update') {
            $position = Position::find($_POST['id']);
            if ($position) {
                $allowanceId = $_POST['allowance_id'] ?? null;
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
                $position->base_salary = $_POST['base_salary'];
                $position->save();
            }
            app()->route->redirect('/positions');
        }

        // Удаление
        if ($action === 'delete') {
            $position = Position::find($_POST['id']);
            if ($position) {
                if ($position->positionAllowance) {
                    $position->positionAllowance->delete();
                }
                $position->delete();
            }
            app()->route->redirect('/positions');
        }

        // Если action не распознан
        app()->route->redirect('/positions');

    }

    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
        }
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
}