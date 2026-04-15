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
use Model\Deduction;


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

    // Список пользователей
    public function users()
    {
        $users = User::with('role', 'position', 'document')->get();
        return (new View())->render('site.users', ['users' => $users]);
    }

// Форма создания пользователя
    public function create_users()
    {
        $roles = Role::all();
        $positions = Position::all();
        return (new View())->render('site.create_user', [
            'roles' => $roles,
            'positions' => $positions
        ]);
    }

// Сохранение нового пользователя
    public function storeUsers(Request $request)
    {
        $data = $request->all(); // получаем все данные

        // Валидация
        $errors = [];
        if (empty($data['login'])) {
            $errors['login'] = 'Логин обязателен';
        } elseif (User::where('login', $data['login'])->exists()) {
            $errors['login'] = 'Такой логин уже используется';
        }
        if (empty($data['password'])) {
            $errors['password'] = 'Пароль обязателен';
        }
        if (empty($data['first_name'])) {
            $errors['first_name'] = 'Имя обязательно';
        }

        if (!empty($errors)) {
            return (new View())->render('site.create_user', [
                'errors'    => $errors,
                'old'       => $data,
                'roles'     => Role::all(),
                'positions' => Position::all()
            ]);
        }

        // Создаём документ
        $doc = Document::create([
            'inn'            => $data['inn'] ?? null,
            'snils'          => $data['snils'] ?? null,
            'payment_account'=> $data['payment_account'] ?? null,
            'tabel_name'     => $data['tabel_name'] ?? null,
        ]);

        $position_id = !empty($request->position_id) ? $request->position_id : null;

        // Создаём пользователя (хешируем пароль)
        $user = User::create([
            'last_name'   => $data['last_name'] ?? null,
            'first_name'  => $data['first_name'],
            'surname'     => $data['surname'] ?? null,
            'login'       => $data['login'],
            'password'    => md5($data['password']),
            'document_id' => $doc->document_id,
            'role_id'     => $data['role_id'] ?? 2,
            'position_id' => $position_id,
        ]);

        app()->route->redirect('/users');
    }

// Форма редактирования пользователя
    public function edit_users(Request $request)
    {
        $user = User::with('document', 'role', 'position')->find($request->id);
        if (!$user) {
            app()->route->redirect('/users');
        }
        $roles = Role::all();
        $positions = Position::all();
        return (new View())->render('site.edit_users', [
            'editUser'  => $user,
            'roles'     => $roles,
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
            return (new View())->render('site.edit_users', [
                'editUser'  => $user,
                'errors'    => $errors,
                'roles'     => Role::all(),
                'positions' => Position::all()
            ]);
        }

        // Обновляем основные поля
        $user->last_name  = $request->last_name;
        $user->first_name = $request->first_name;
        $user->surname    = $request->surname;
        $user->login      = $request->login;

        if (!empty($request->password)) {
            $user->password = md5($request->password);
        }

        $user->role_id    = $request->role_id;
        $user->position_id = $request->position_id ?: null;
        $user->save();

        // Обновляем связанный документ
        if ($user->document) {
            $user->document->update([
                'inn'            => $request->inn,
                'snils'          => $request->snils,
                'payment_account'=> $request->payment_account,
                'tabel_name'     => $request->tabel_name,
            ]);
        } else {
            // Если документа нет – создаём
            $doc = Document::create([
                'inn'            => $request->inn,
                'snils'          => $request->snils,
                'payment_account'=> $request->payment_account,
                'tabel_name'     => $request->tabel_name,
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
            // Отвязываем и удаляем документ
            if ($user->document_id) {
                $docId = $user->document_id;
                $user->document_id = null;
                $user->save();
                Document::destroy($docId);
            }
            $user->delete();
        }
        app()->route->redirect('/users');
    }

    // Список начислений
    // Список начислений
    public function allowances()
    {
        $allowances = Allowance::all();
        return (new View())->render('site.allowances', ['allowances' => $allowances]);
    }

// Форма создания начисления
    public function create_allowance()
    {
        return (new View())->render('site.create_allowance');
    }

// Сохранение начисления
    public function storeAllowance(Request $request)
    {

        Allowance::create([
        'name_allowance' => $request->name_allowance,
        'precent_allowance' => $request->precent_allowance,
        ]);

        app()->route->redirect('/allowances');
    }

// Форма редактирования начисления
    public function edit_allowance(Request $request)
    {
        $allowance = Allowance::find($request->id);
        if (!$allowance) {
            app()->route->redirect('/allowances');
        }
        return (new View())->render('site.edit_allowance', ['allowance' => $allowance]);
    }

// Обновление начисления
    public function updateAllowance(Request $request)
    {
        $allowance = Allowance::find($request->id);
        if (!$allowance) {
            app()->route->redirect('/allowances');
        }

        $allowance->update([
            'name_allowance' => $request->name_allowance,
            'precent_allowance' => $request->precent_allowance,
        ]);

        app()->route->redirect('/allowances');
    }


// Удаление начисления
    public function deleteAllowance(Request $request)
    {
        $allowance = Allowance::find($request->id);
        if ($allowance) {
            $allowance->delete();
        }
        app()->route->redirect('/allowances');
    }
    // Список вычетов
    public function deductions()
    {
        $deductions = Deduction::all();
        return (new View())->render('site.deductions', ['deductions' => $deductions]);
    }

// Форма создания вычета
    public function create_deduction()
    {
        return (new View())->render('site.create_deduction');
    }

// Сохранение вычета
    // Сохранение
    public function storeDeduction(Request $request)
    {
        $errors = [];
        if (empty($request->deduction_name)) {
            $errors['deduction_name'] = 'Название вычета обязательно';
        }
        if (empty($request->amount_deduction) && !is_numeric($request->amount_deduction)) {
            $errors['amount_deduction'] = 'Сумма вычета обязательна и должна быть числом';
        }

        if (!empty($errors)) {
            return (new View())->render('site.create_deduction', [
                'errors' => $errors,
                'old' => (array)$request
            ]);
        }

        Deduction::create([
            'deduction_name' => $request->deduction_name,
            'amount_deduction' => $request->amount_deduction,
        ]);

        app()->route->redirect('/deductions');
    }

// Обновление
    public function updateDeduction(Request $request)
    {
        $deduction = Deduction::find($request->id);
        if (!$deduction) {
            app()->route->redirect('/deductions');
        }

        $errors = [];
        if (empty($request->deduction_name)) {
            $errors['deduction_name'] = 'Название вычета обязательно';
        }
        if (empty($request->amount_deduction) && !is_numeric($request->amount_deduction)) {
            $errors['amount_deduction'] = 'Сумма вычета обязательна и должна быть числом';
        }

        if (!empty($errors)) {
            return (new View())->render('site.edit_deduction', [
                'errors' => $errors,
                'deduction' => $deduction
            ]);
        }

        $deduction->update([
            'deduction_name' => $request->deduction_name,
            'amount_deduction' => $request->amount_deduction,
        ]);

        app()->route->redirect('/deductions');
    }

// Форма редактирования вычета
    public function edit_deduction(Request $request)
    {
        $deduction = Deduction::find($request->id);
        if (!$deduction) {
            app()->route->redirect('/deductions');
        }
        return (new View())->render('site.edit_deduction', ['deduction' => $deduction]);
    }


// Удаление вычета
    public function deleteDeduction(Request $request)
    {
        $deduction = Deduction::find($request->id);
        if ($deduction) {
            $deduction->delete();
        }
        app()->route->redirect('/deductions');
    }

    public function calculatePayroll(Request $request)
    {
        if ($request->method === 'POST') {
            $month = $request->month; // формат YYYY-MM
            $users = User::with('position.positionAllowance.allowance', 'deductions')->get();

            foreach ($users as $user) {
                // Базовый оклад из должности
                $baseSalary = $user->position ? $user->position->base_salary : 0;

                // Надбавка (процент от оклада)
                $allowancePercent = 0;
                if ($user->position && $user->position->positionAllowance && $user->position->positionAllowance->allowance) {
                    $allowancePercent = $user->position->positionAllowance->allowance->precent_allowance;
                }
                $allowanceAmount = $baseSalary * $allowancePercent / 100;

                // Сумма вычетов
                $totalDeductions = $user->deductions->sum('amount_deduction');

                $totalAccrued = $baseSalary + $allowanceAmount;
                $finalSum = $totalAccrued - $totalDeductions;

                // Сохраняем отчёт
                PayrollReport::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'date_report' => $month . '-01', // первое число месяца
                    ],
                    [
                        'total_accued' => $totalAccrued,
                        'total_deducted' => $totalDeductions,
                        'final_sum' => $finalSum,
                    ]
                );
            }

            app()->route->redirect('/payroll/reports');
        }

        return (new View())->render('site.calculate_payroll');
    }

    public function payrollReports()
    {
        // Группировка по должностям (или можно по отделам, но у вас отделов нет, используем должности)
        $reports = PayrollReport::with('user.position')
            ->selectRaw('position_id, AVG(final_sum) as avg_salary, DATE_FORMAT(date_report, "%Y-%m") as month')
            ->join('users', 'payroll_reports.user_id', '=', 'users.id')
            ->groupBy('position_id', 'month')
            ->orderBy('month', 'desc')
            ->get();

        return (new View())->render('site.payroll_reports', ['reports' => $reports]);
    }

    public function payslip(Request $request)
    {
        $user = User::find($request->id);
        if (!$user) {
            app()->route->redirect('/users');
        }
        $month = $request->month ?? date('Y-m');
        $report = PayrollReport::where('user_id', $user->id)
            ->where('date_report', 'like', $month . '%')
            ->first();

        return (new View())->render('site.payslip', ['user' => $user, 'report' => $report, 'month' => $month]);
    }

}
