<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Notifications\ResetPasswordNotification; // Thêm dòng này

class AuthController extends Controller
{
    // Hiển thị form đăng ký
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký người dùng
    public function register(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ], [
        'name.required' => 'Vui lòng nhập tên của bạn.',
        'email.required' => 'Vui lòng nhập địa chỉ email.',
        'email.email' => 'Email không hợp lệ.',
        'email.unique' => 'Email này đã được đăng ký.',
        'password.required' => 'Vui lòng nhập mật khẩu.',
        'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
    ]);

    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        'role' => 'user',
    ]);

    Auth::login($user);

    return $user->role === 'admin'
        ? redirect()->route('admin.dashboard')->with('success', 'Đăng ký thành công! Chào mừng bạn, Admin!')
        : redirect()->route('home')->with('success', 'Đăng ký thành công! Chào mừng bạn!'); // Đổi route về 'home'
}


    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('home'); // Hoặc bất kỳ route nào bạn muốn redirect đến
        }
    
        return view('auth.login');
    }

    // Xử lý đăng nhập người dùng
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ], [
        'email.required' => 'Vui lòng nhập địa chỉ email.',
        'email.email' => 'Email không hợp lệ.',
        'password.required' => 'Vui lòng nhập mật khẩu.',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Chuyển hướng dựa trên vai trò của người dùng
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công!')
            : redirect()->route('home')->with('success', 'Đăng nhập thành công!'); // Đổi route về 'home'
    }

    // Trả về thông báo lỗi nếu thông tin đăng nhập không chính xác
    return back()->with('error', 'Email hoặc mật khẩu không đúng.')->withInput($request->only('email'));
}


    // Xử lý đăng xuất người dùng
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Đăng xuất thành công!');
    }

    // Hiển thị form yêu cầu liên kết đặt lại mật khẩu
    public function showLinkRequestForm()
{
    return view('auth.passwords.email');
}

public function sendResetLinkEmail(Request $request)
{
    // Xác thực email
    $request->validate(['email' => 'required|email']);

    // Gửi email nếu người dùng tồn tại
    $user = User::where('email', $request->email)->first();
    if ($user) {
        $token = Password::createToken($user);
        $user->notify(new ResetPasswordNotification($token));
    }

    // Thêm thông báo
    return back()->with('status', 'Đã gửi liên kết đặt lại mật khẩu đến email của bạn.');
}

public function showResetForm(Request $request, $token)
{
    return view('auth.passwords.reset')->with(['token' => $token, 'email' => $request->email]);
}

public function reset(Request $request)
{
    // Xác thực và đặt lại mật khẩu
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
        'token' => 'required',
    ]);

    $response = Password::reset($request->only('email', 'password', 'token'), function (User $user, $password) {
        $user->password = Hash::make($password);
        $user->save();
        Auth::login($user);
    });

    // Thêm thông báo thành công hoặc thất bại
    return $response == Password::PASSWORD_RESET
        ? redirect()->route('home')->with('success', 'Mật khẩu đã được đặt lại thành công!')
        : back()->with('error', 'Không thể đặt lại mật khẩu. Vui lòng thử lại.');
}

}
