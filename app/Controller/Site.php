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

    public function positions(Request $request)
    {
        $action = $_GET['action'] ?? 'list';

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['create'])) {
            $allowances = Allowance::all();
            extract(['allowances' => $allowances]);
            include __DIR__ . '/../../views/site/create_position.php';
            exit;
        }

        // СПИСОК
        if ($action === 'list') {
            $positions = Position::with('positionAllowance.allowance')->get();
            extract(['positions' => $positions]);
            include __DIR__ . '/../../views/site/positions.php';
            exit;
        }

// ФОРМА СОЗДАНИЯ
        if ($action === 'create') {
            $allowances = Allowance::all();
            extract(['allowances' => $allowances, 'mode' => 'create']);
            include __DIR__ . '/../../views/site/create_position.php';
            exit;
        }

        // СОХРАНЕНИЕ
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
            header('Location: /positions');
            exit;
        }

        // ФОРМА РЕДАКТИРОВАНИЯ
        if ($action === 'edit') {
            $position = Position::with('positionAllowance')->find($_GET['id']);
            if (!$position) {
                header('Location: /positions');
                exit;
            }
            $allowances = Allowance::all();
            extract(['position' => $position, 'allowances' => $allowances, 'mode' => 'edit']);
            include __DIR__ . '/../../views/site/edit_position.php';
            exit;
        }

        // ОБНОВЛЕНИЕ
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
            header('Location: /positions');
            exit;
        }

        // УДАЛЕНИЕ
        if ($action === 'delete') {
            $position = Position::find($_POST['id']);
            if ($position) {
                if ($position->positionAllowance) {
                    $position->positionAllowance->delete();
                }
                $position->delete();
            }
            header('Location: /positions');
            exit;
        }

        // Если action не распознан
        header('Location: /positions');
        exit;
    }
}