<?php

    namespace App\Http\Controllers\Admin;

    use App\Events\SendMailNoticeCourseEvent;
    use App\Http\Controllers\Controller;
    use App\Models\Course;
    use App\Models\Dislike;
    use App\Models\Like;
    use App\Models\Review;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Foundation\Application;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Crypt;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\File;

    class CourseController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
        {
            $status = $request->status ?? null;
            
            if (!is_null($status)) {
                $courses = Course::where('status', $status)->get();
            } else {
                $courses = Course::with('reviews')->withTrashed()->get();
            }
            return view('admin.pages.courses_list', compact('courses', 'status'));
        }

        /**
         * Display the specified resource.
         */
        public function show(string $slug): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
        {
            $course = Course::where('slug', $slug)->first();
            return view('admin.pages.course_detail', compact('course'));
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id): JsonResponse
        {
            DB::beginTransaction();
            try {
                $course = Course::find($id);
                if (file_exists(public_path($course->thumbnail))) {
                    unlink(public_path($course->thumbnail));
                }
                foreach ($course->subjects as $subject) {
                    foreach ($subject->lessons as $lesson) {
                        $lesson->forceDelete();
                    }
                    $subject->forceDelete();
                }
                $course->forceDelete();
                DB::commit();
                return response()->json(['status' => 'success', 'msg' => 'Xóa khóa học thành công']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['status' => 'error', 'msg' => 'Xóa khóa học thất bại']);
            }
        }

        public function updateStatus(string $id, Request $request): JsonResponse
        {
            try {
                $status = $request->status;
                $course = Course::find(Crypt::decrypt($id));
                if ($status == 'rejected') {
                    $this->destroy($id);
                } elseif ($status == 'approved') {
                    if (file_exists(public_path(env('TMP_FOLDER') . $course->thumbnail)) && !is_null($course->thumbnail)) {
                        File::move(public_path(env('TMP_FOLDER') . $course->thumbnail), public_path(env('COURSE_FOLDER_PATH') . $course->thumbnail));
                    }
                } elseif ($status == 'pending') {
                    if (file_exists(public_path(env('COURSE_FOLDER_PATH') . $course->thumbnail))) {
                        File::move(public_path(env('COURSE_FOLDER_PATH') . $course->thumbnail), public_path(env('TMP_FOLDER') . $course->thumbnail));
                    }
                }
                if (in_array($status, ['approved', 'pending', 'suspended'])) {
                    $course->status = $status;
                    $course->save();
                }
                event(new SendMailNoticeCourseEvent($course));
                return response()->json(['status' => 'success', 'msg' => 'Cập nhật trạng thái thành công']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'msg' => 'Cập nhật trạng thái thất bại']);
            }
        }
    }
