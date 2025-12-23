<?php

namespace App\Validator;

use App\Models\Course;
use App\Models\Lesson;

class CourseInfoValidator {
    public static array $MESSAGES = [
        'title.required' => 'Vui lòng nhập tiêu đề để định danh khóa học/môn học này.',
        'title.min' => 'Tiêu đề phải có ít nhất :min ký tự để đảm bảo tính rõ ràng.',
        'title.max' => 'Tiêu đề không được vượt quá :max ký tự để hiển thị tốt nhất.',

        'slug.required' => 'Đường dẫn khóa học không được để trống.',
        'slug.min' => 'Đường dẫn phải có ít nhất :min ký tự.',
        'slug.max' => 'Đường dẫn không được vượt quá :max ký tự.',
        'slug.unique' => 'Đường dẫn này đã tồn tại trên hệ thống. Vui lòng chọn tiêu đề khác.',

        'heading.required' => 'Vui lòng nhập mô tả tóm tắt cho khóa học.',
        'heading.min' => 'Mô tả tóm tắt phải có ít nhất :min ký tự.',
        'heading.max' => 'Mô tả tóm tắt không được vượt quá :max ký tự.',

        'price.required_if' => 'Học phí là bắt buộc đối với loại hình khóa học có thu phí.',
        'price.integer' => 'Học phí phải là một số nguyên.',
        'price.min' => 'Học phí cho khóa học có phí phải lớn hơn 0.',

        'category.required' => 'Vui lòng chọn danh mục phù hợp cho khóa học.',
        'category.exists' => 'Danh mục đã chọn không hợp lệ hoặc không tồn tại.',

        'level.required' => 'Vui lòng xác định cấp độ khó của khóa học.',
        'level.in' => 'Vui lòng chọn một cấp độ hợp lệ từ danh sách có sẵn.',

        'modules.required' => 'Bạn cần tạo ít nhất một chương nội dung cho khóa học này.',
        'modules.min' => 'Khóa học phải chứa ít nhất :min chương.',
        'modules.*.title.required' => 'Mỗi chương học đều phải có tiêu đề.',
        'modules.*.lessons.required' => 'Mỗi chương phải chứa ít nhất một bài học.',
        'modules.*.lessons.*.title.required' => 'Vui lòng nhập tiêu đề cho từng bài học.',
        'modules.*.lessons.*.type.required' => 'Vui lòng chọn định dạng nội dung cho bài học.',
    ];

    public static function rules(): array
    {
        return [
            'title' => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255|unique:courses,slug',
            'heading' => 'required|min:3|max:255',
            'price' => 'exclude_unless:courseType,paid|required|integer|min:1',
            'courseType' => 'required|in:' . implode(',', array_keys(Course::$TYPES)),

            'category' => 'required|exists:categories,id',
            'level' => 'required|in:' . implode(',', array_keys(Course::$LEVELS)),
            'thumbnail' => 'nullable|string',
            'modules' => 'required|array|min:1',
            'modules.*.title' => 'required|min:3|max:255',
            'modules.*.lessons' => 'required|array|min:1',
            'modules.*.lessons.*.title' => 'required|min:3|max:255',
            'modules.*.lessons.*.type' => 'required|in:' . implode(',', array_keys(Lesson::$TYPES)),
        ];
    }
}
