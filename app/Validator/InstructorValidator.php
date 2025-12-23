<?php

namespace App\Validator;

class InstructorValidator {
    public static array $MESSAGES = [
        'name.required' => 'Họ và tên giảng viên không được để trống.',
        'name.string' => 'Họ và tên phải là định dạng văn bản hợp lệ.',
        'name.min' => 'Họ và tên phải có ít nhất :min ký tự.',

        'email.required' => 'Địa chỉ email là bắt buộc.',
        'email.email' => 'Vui lòng nhập đúng định dạng email (Ví dụ: user@vietmy.edu.vn).',
        'email.unique' => 'Địa chỉ email này đã được sử dụng bởi một tài khoản khác.',

        'password.required' => 'Vui lòng thiết lập mật khẩu cho tài khoản.',
        'password.string' => 'Mật khẩu phải là một chuỗi ký tự.',
        'password.min' => 'Mật khẩu phải dài ít nhất :min ký tự để đảm bảo tính bảo mật.',

        'avatar.image' => 'Tệp tải lên phải là định dạng hình ảnh (jpeg, png, bmp, gif, hoặc svg).',
        'avatar.max' => 'Dung lượng ảnh đại diện không được vượt quá :max kilobytes (5MB).',
        'avatar.prohibits' => 'Bạn không thể vừa tải ảnh lên vừa sử dụng liên kết ảnh. Vui lòng chọn một trong hai.',

        'avatarLink.url' => 'Liên kết ảnh đại diện phải là một đường dẫn URL hợp lệ.',
        'avatarLink.prohibits' => 'Bạn không thể vừa sử dụng liên kết ảnh vừa tải ảnh lên. Vui lòng chọn một trong hai.',

        'gender.required' => 'Vui lòng chọn giới tính của giảng viên.',
        'gender.in' => 'Giới tính đã chọn không hợp lệ. Vui lòng chọn từ danh sách có sẵn.',

        'major_id.required' => 'Vui lòng xác định chuyên ngành giảng dạy.',
        'major_id.exists' => 'Chuyên ngành đã chọn không tồn tại trong hệ thống dữ liệu.',
    ];

    public static function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'avatar' => 'nullable|image|max:5120|prohibits:avatarLink',
            'avatarLink' => 'nullable|url|prohibits:avatar',
            'gender' => 'required|in:male,female,other',
            'major_id' => 'required|exists:majors,id',
        ];
    }
}
