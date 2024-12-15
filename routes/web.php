<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\BoostUsers;
use Inertia\Inertia;
use App\Service\User\GetTotalIncome;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Boost;
use App\Service\Task\CheckSubcribeChannel;
use App\Service\Boost\GetBoost;
use App\Models\Setting;
use App\Models\TaksCompleted;
use App\Models\Shop;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/user/init', function () {
    return view('init');
});
Route::get('/login/{token?}', function ($token = null) {
    $user_os = request()->header('User-Agent');
    if (strpos($user_os, 'Mobile') === false) {
        return Inertia::render('mobile');
    }

    if (!$token) {
        return 'Token is required';
    }
    $user = User::where('auth_token', $token)->first();
    if ($user && auth()->check() && auth()->user() && auth()->user()->tg_id === $user->tg_id) {
        return redirect('/');
    }

    if (!$user) {
        return 'User not found';
    }
    // $user->auth_token = null;
    // $user->save();
    auth()->login($user, true);
    return redirect('/');
})->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        $user = auth()->user();
        $total_income = (new GetTotalIncome())->execute($user->id);
        return Inertia::render('index', ['user' => $user, 'total_income' => $total_income]);
    })->name('index');

    Route::get('/friend', function () {
        $user = auth()->user();
        $setting = Setting::first();
        $friends = User::where('referral_code', $user->tg_id)->get();
        $friend = null;
        if ($user->referral_code) {
            $friend = User::where('tg_id', $user->referral_code)->select('username')->first();
        }
        return Inertia::render('friend', ['user' => $user, 'friends' => $friends, 'setting' => $setting, 'friend' => $friend]);
    })->name('friend');

    Route::get('/task', function () {
        $user = auth()->user();
        $tasks_completed = TaksCompleted::where('user_id', $user->id)->get();
        $tasks = Task::where('is_daily', false)->whereNotIn('id', $tasks_completed->pluck('task_id'))->get();
        $tasks_daily = Task::where('is_daily', true)->whereNotIn('id', $tasks_completed->pluck('task_id'))->get();
        return Inertia::render('task', ['tasks' => $tasks, 'tasks_daily' => $tasks_daily, 'user' => $user]);
    })->name('task');

    Route::get('/shop', function () {
        $items = Shop::all();
        return Inertia::render('shop', ['items' => $items]);
    })->name('shop');

    Route::get('/boost', function () {
        $boosts = (new GetBoost())->execute(auth()->user()->id);
        $boost_users = BoostUsers::where('user_id', auth()->user()->id)->get()->toArray();
        $user = auth()->user();
        $total_income = (new GetTotalIncome())->execute($user->id);
        return Inertia::render('boost', ['boosts' => $boosts, 'boost_users' => $boost_users, 'user' => $user, 'total_income' => $total_income]);
    })->name('boost');

    Route::post('/task/check', function (Request $request) {
        $task_id = $request->input('task_id');
        if (TaksCompleted::where('user_id', auth()->user()->id)->where('task_id', $task_id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Задание уже выполнено']);
        }
        $user = auth()->user();
        $task = Task::find($task_id);
        $check_subcribe = (new CheckSubcribeChannel())->execute($user->tg_id, $task->channel_id);
        if (!$check_subcribe) {
            return response()->json(['success' => false, 'message' => 'Вы не подписаны на канал']);
        }
        TaksCompleted::create([
            'user_id' => $user->id,
            'task_id' => $task_id,
        ]);
        $user->coins += $task->reward;
        $user->save();
        return response()->json(['success' => true, 'task_id' => $task_id]);
    })->name('task.check');

    Route::post('/boost/buy', function (Request $request) {
        $boost_id = $request->input('boost_id');
        $user = auth()->user();
        sleep(1);
        $boost = Boost::find($boost_id);
        $boost_user = BoostUsers::where('user_id', $user->id)->where('boost_id', $boost_id)->first();

        if (!$boost_user) {
            $boost_user = new BoostUsers();
            $boost_user->user_id = $user->id;
            $boost_user->boost_id = $boost_id;
            $boost_user->lvl = 1;

            $boost_price = $boost->lvl_prices[0]['price'];
        } else {
            $boost_price = $boost->lvl_prices[$boost_user->lvl - 1]['price'];
            $max_lvl = count($boost->lvl_prices);
            if ($user->coins < $boost_price) {
                return response()->json(['success' => false, 'message' => 'Недостаточно монет']);
            }
            if ($boost_user->lvl < $max_lvl) {
                $boost_price = $boost->lvl_prices[$boost_user->lvl]['price'];
                $boost_user->lvl++;

                $boost_user->save();
            }
        }


        $user->coins -= $boost_price;
        $user->save();
        $boost_user->save();
        $boost_users = BoostUsers::where('user_id', auth()->user()->id)->get()->toArray();
        return response()->json(['success' => true, 'boost_user' => $boost_users, 'coins' => $user->coins]);
    })->name('boost.buy');

    Route::post('/tap', function (Request $request) {
        $tap_count = $request->input('tap_count');
        $user = auth()->user();
        $user->coins += $tap_count;
        $user->energy -= $tap_count;
        $user->last_tap = now();
        $user->save();
        return response()->json(['coins' => $user->coins, 'energy' => $user->energy]);
    });
});


Route::get('/generate/token/{user_id}', function ($user_id) {
    $token = bin2hex(random_bytes(16));
    $user = User::find($user_id);
    dd($user_id, $user);

    $user->auth_token = $token;
    $user->save();
    return redirect(env('APP_URL') . '/login/' . $token);
});


Route::get('/update/energy', function () {
    $users = User::all();
    foreach ($users as $user) {
        if ($user->energy < $user->energy_max) {
            $user->energy++;
            $user->save();
        }
    }
    return response()->json(['success' => true]);
});
Route::get('/update/coins/{token}', function ($token) {
    if ($token != env('API_TOKEN')) {
        return response()->json(['success' => false, 'message' => 'Invalid token']);
    }
    $users = User::all();
    foreach ($users as $user) {
        $user_boosts = BoostUsers::where('user_id', $user->id)->get();
        $user_boosts_coins = 0;
        foreach ($user_boosts as $user_boost) {
            $user_boosts_coins += $user_boost->boost->lvl_prices[$user_boost->lvl - 1]['income_per_hour'];
        }
        $coin_per_second = $user_boosts_coins / 3600;
        $user->coins += $coin_per_second;
        $user->save();
    }
    return response()->json(['success' => true]);
});
