<?php

namespace App\Validator;

use App\Models\Assessment;
use App\Models\Lesson;

class NewLessonValidator {
    public static array $MESSAGES = [
        'lesson.title.required' => 'Vui lòng nhập tên bài học.',
        'lesson.title.min' => 'Tên bài học phải có ít nhất :min ký tự.',
        'lesson.title.max' => 'Tên bài học không được vượt quá :max ký tự.',

        'lesson.type.required' => 'Vui lòng chọn định dạng cho bài học.',
        'lesson.type.in' => 'Định dạng bài học không hợp lệ. Vui lòng chọn lại.',

        'lesson.document.required_if' => 'Nội dung văn bản là bắt buộc đối với định dạng Tài liệu.',
        'lesson.document.min' => 'Nội dung tài liệu phải có ít nhất :min ký tự.',

        'lesson.assessment.required_if' => 'Thông tin bài kiểm tra là bắt buộc khi chọn loại hình Đánh giá.',

        'lesson.assessment.title.required_if' => 'Vui lòng nhập tên cho bài kiểm tra.',
        'lesson.assessment.title.min' => 'Tên bài kiểm tra phải có ít nhất :min ký tự.',
        'lesson.assessment.title.max' => 'Tên bài kiểm tra không được vượt quá :max ký tự.',

        'lesson.assessment.description.required_if' => 'Vui lòng nhập mô tả yêu cầu cho bài tập hoặc bài thực hành lập trình.',
        'lesson.assessment.description.min' => 'Nội dung mô tả phải có ít nhất :min ký tự.',
        'lesson.assessment.description.in' => 'Loại mô tả phải thuộc danh mục: Bài tập (assignment) hoặc Lập trình (programming).',

        'lesson.assessment.type.required_if' => 'Vui lòng chọn hình thức kiểm tra (Trắc nghiệm/Bài tập/Lập trình).',
        'lesson.assessment.type.in' => 'Hình thức kiểm tra không hợp lệ.',

        'lesson.assessment.assessments_questions.required_if' => 'Vui lòng thêm ít nhất một câu hỏi cho bài trắc nghiệm.',
        'lesson.assessment.assessments_questions.array' => 'Danh sách câu hỏi không đúng định dạng.',
        'lesson.assessment.assessments_questions.min' => 'Bài trắc nghiệm phải có tối thiểu :min câu hỏi.',

        'lesson.video_file_name.required_if' => 'Vui lòng tải lên tệp video cho bài học này.',
        'lesson.video_file_name.max' => 'Dung lượng video không được vượt quá 250 MB.',
        'lesson.video_file_name.mimes' => 'Video phải thuộc một trong các định dạng: MP4, MOV, hoặc WEBM.',

        'lesson.duration.required_if' => 'Vui lòng xác định thời lượng cho video.',
        'lesson.duration.numeric' => 'Thời lượng video phải là một con số (tính bằng giây).',
        'lesson.duration.min' => 'Thời lượng video không được nhỏ hơn :min giây.',

        'lesson.preview.required' => 'Vui lòng xác định bài học này có cho phép học thử hay không.',
        'lesson.preview.boolean' => 'Giá trị cho phép học thử không hợp lệ.',
    ];

    public static function rules(array $existingLessonTitles = []): array
    {
        $lessonType = implode(',', array_keys(Lesson::$TYPES));
        $assessmentType = implode(',', array_keys(Assessment::$ASSESSMENT_PRACTICE_TYPES));

        $rules = [
            'lesson.title' => 'required|min:3|max:255',
            'lesson.type' => 'required|in:' . $lessonType,

            'lesson.document' => 'required_if:lesson.type,document|min:3',

            'lesson.assessment' => 'required_if:lesson.type,assessment',
            'lesson.assessment.title' => 'required_if:lesson.type,assessment|min:3|max:255',
            'lesson.assessment.description' => 'required_if:lesson.assessment.type,assignment,programming|min:3',
            'lesson.assessment.type' => 'required_if:lesson.type,assessment|in:' . $assessmentType,

            'lesson.assessment.programming' => 'nullable|array',

            'lesson.video_file_name' => 'required_if:lesson.type,video|max:250000',
            'lesson.duration' => 'required_if:lesson.type,video|numeric|min:0',

            'lesson.preview' => 'required|boolean',
        ];

        if (is_string($rules['lesson.title'])) {
            $rules['lesson.title'] = explode('|', $rules['lesson.title']);
        }

        $rules['lesson.title'][] = function ($attribute, $value, $fail) use ($existingLessonTitles) {
            $incomingTitle = mb_strtolower(trim((string)$value));

            if ($incomingTitle !== '') {
                $normalizedExisting = array_map(
                    fn($t) => mb_strtolower(trim((string)$t)),
                    $existingLessonTitles ?? []
                );

                if (in_array($incomingTitle, $normalizedExisting, true)) {
                    $fail('Tên bài học đã tồn tại trong chương này. Vui lòng chọn tên khác.');
                }
            }
        };

        return $rules;
    }

    public static function rulesFor(string $field): array
    {
        $rules = [];

        foreach (self::rules([]) as $key => $rule) {
            if ($key === "lesson.$field" || str_starts_with($key, "lesson.$field.")) {
                $shortKey = str_starts_with($key, 'lesson.')
                    ? substr($key, strlen('lesson.'))
                    : $key;

                $ruleParts = is_string($rule) ? explode('|', $rule) : (array)$rule;

                $cleaned = array_map(function ($r) {
                    if (str_starts_with($r, 'required_if')) {
                        return 'required';
                    }
                    return $r;
                }, $ruleParts);

                $rules[$shortKey] = implode('|', $cleaned);
            }
        }

        return $rules;
    }

    public static function messagesFor(string $field): array
    {
        $messages = [];

        foreach (self::$MESSAGES as $key => $message) {
            if ($key === "lesson.$field" || str_starts_with($key, "lesson.$field.")) {
                $shortKey = str_starts_with($key, 'lesson.')
                    ? substr($key, strlen('lesson.'))
                    : $key;

                if (str_ends_with($shortKey, '.required_if')) {
                    $shortKey = str_replace('.required_if', '.required', $shortKey);
                }

                $messages[$shortKey] = $message;
            }
        }

        return $messages;
    }

    public static function rulesForAs(string $fromField, string $toField): array
    {
        $original = self::rulesFor($fromField);
        $remapped = [];

        foreach ($original as $key => $rule) {
            if ($key === $fromField) {
                $newKey = $toField;
            } elseif (str_starts_with($key, $fromField . '.')) {
                $newKey = $toField . substr($key, strlen($fromField));
            } else {
                $newKey = $key;
            }
            $remapped[$newKey] = $rule;
        }

        return $remapped;
    }

    public static function messagesForAs(string $fromField, string $toField): array
    {
        $messages = [];

        foreach (self::$MESSAGES as $key => $message) {
            if ($key === "lesson.$fromField" || str_starts_with($key, "lesson.$fromField.")) {
                $shortKey = str_starts_with($key, 'lesson.')
                    ? substr($key, strlen('lesson.'))
                    : $key;

                if (str_ends_with($shortKey, '.required_if')) {
                    $shortKey = str_replace('.required_if', '.required', $shortKey);
                }
                if ($shortKey === $fromField || str_starts_with($shortKey, $fromField . '.')) {
                    $newKey = $toField . substr($shortKey, strlen($fromField));
                } else {
                    $newKey = $shortKey;
                }

                $messages[$newKey] = $message;
            }
        }
        return $messages;
    }

}
