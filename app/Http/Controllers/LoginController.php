<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function showRegisterForm() {
        return view('auth.register');
    }
    public function forgotPasswordForm() {
        return view('auth.forgot-password');
    }


    public function register(Request $request) {
        // 1. Validate nghiêm ngặt ở tầng Backend một lần nữa để bảo mật tuyệt đối
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8) // Ít nhất 8 ký tự
                    ->letters()  // Phải có chữ
                    ->mixedCase()// Cả hoa và thường
                    ->numbers()  // Phải có số
                    ->symbols(), // Phải có ký tự đặc biệt (trùng hoàn toàn với Regex Alpine của bạn)
            ],
        ], [
            // Custom thông báo lỗi tiếng Việt thân thiện
            'name.required'     => 'Vui lòng nhập họ và tên.',
            'email.required'    => 'Vui lòng nhập địa chỉ email.',
            'email.email'       => 'Định dạng email chưa chính xác.',
            'email.unique'      => 'Email này đã tồn tại trên hệ thống.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed'=> 'Mật khẩu xác nhận lại không trùng khớp.',
        ]);

        // 2. Tạo User mới trong bảng `users` qua Eloquent ORM
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu bcrypt trước khi lưu DB
        ]);

        // 3. Đăng nhập luôn cho user sau khi đăng ký thành công
        Auth::login($user);

        // 4. Chuyển hướng về trang chủ kèm thông báo thành công
        return redirect('/')->with('success', 'Đăng ký tài khoản và đăng nhập thành công!');
    }

    public function login(Request $request) {
        // 1. Validate dữ liệu đầu vào cơ bản ở Backend
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Vui lòng điền thông tin email.',
            'email.email'       => 'Định dạng email không chính xác.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        // 2. Sử dụng Auth::attempt để so khớp thông tin đăng nhập với DB (đã tự động hash mật khẩu để check)
        // Thêm tham số true nếu bạn muốn bật chức năng "Ghi nhớ đăng nhập" (Remember me)
        if (Auth::attempt($credentials, true)) {
            // Đăng nhập thành công, làm mới lại mã Token Session phòng chống tấn công định danh
            $request->session()->regenerate();

            // Chuyển hướng người dùng về trang chủ (hoặc trang họ đang định vào trước đó)
            return redirect()->intended('/')->with('success', 'Chào mừng bạn quay trở lại!');
        }

        // 3. Nếu đăng nhập thất bại, quay trở lại trang cũ kèm dữ liệu email cũ và thông báo lỗi
        return back()->withInput($request->only('email'))->with('error', 'Email hoặc mật khẩu không chính xác, vui lòng thử lại.');
    }

    public function logout(Request $request) {
        Auth::logout(); // Đăng xuất người dùng khỏi hệ thống

        $request->session()->invalidate(); // Hủy bỏ tất cả dữ liệu session hiện tại
        $request->session()->regenerateToken(); // Tạo mới CSRF token để bảo mật

        return redirect('/')->with('success', 'Bạn đã đăng xuất thành công!');
    }

    public function forgotPassword(Request $request) {
        // 1. Validate email đầu vào
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email của bạn.',
            'email.email'    => 'Định dạng email không hợp lệ.',
            'email.exists'   => 'Email này không tồn tại trong hệ thống.',
        ]);

        // 2. Tìm user theo email
        $user = User::where('email', $request->email)->first();

        // 3. Tạo token reset password (có thể dùng Laravel's built-in Password Reset hoặc tự custom)
        $token = Str::random(60); // Tạo token ngẫu nhiên

        // Lưu token vào database hoặc cache (ví dụ: password_resets table)
        \Illuminate\Support\Facades\DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => Hash::make($token), // Mã hóa token trước khi lưu
            'created_at' => now(),
        ]);

        // 4. Gửi email chứa link reset password (ví dụ: /reset-password?token=xxx&email=yyy)
        // Bạn có thể sử dụng Laravel's Mailables để gửi email chuyên nghiệp hơn
        Mail::send('emails.password-reset', ['token' => $token, 'email' => $user->email], function($message) use ($user) {
            $message->to($user->email);
            $message->subject('Yêu cầu đặt lại mật khẩu');
        });

        return back()->with('success', 'Chúng tôi đã gửi một email chứa hướng dẫn đặt lại mật khẩu đến địa chỉ của bạn.');
    }

}
