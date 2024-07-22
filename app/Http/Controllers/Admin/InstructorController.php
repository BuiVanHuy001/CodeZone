<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreInstructorRequest;
    use App\Http\Requests\UpdateInstructorRequest;
    use App\Models\Instructor;
    use App\Models\User;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Foundation\Application;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Hash;

    class InstructorController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
        {
            $instructors = Instructor::with(['user', 'courses'])->get();
            return view('admin.pages.instructor_list', compact('instructors'));
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            //
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(StoreInstructorRequest $request)
        {
            //
        }

        /**
         * Display the specified resource.
         */
        public function show(string $slug): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
        {
            $user = User::where('slug', $slug)->with(['instructor.courses'])->first();
            if (!$user) {
                return view('admin.pages.404admin');
            }
            $instructor = $user->instructor;
            return view('admin.pages.instructor_detail', compact('instructor'));
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Instructor $instructor)
        {
            //
        }

        public function updateStatus(string $id, Request $request): JsonResponse
        {
            $status = $request->status;
            if (in_array($status, ['active', 'suspended', 'rejected', 'unblock', 'deleted'])) {
                DB::beginTransaction();
                try {
                    $instructor = Instructor::find(decrypt($id));
                    if (!$instructor) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Something went wrong'
                        ]);
                    }
                    $user = $instructor->user;
                    if ($status == 'active' && $user->status != 'active') {
                        $user->password = Hash::make($this->generateTemporaryPassword());
                        $instructor->setAttribute('tmp_password', $user->password);
                        $user->status = $status;
                        $user->save();
                    } elseif ($status == 'rejected' || $status == 'deleted') {
                        $instructor->deleteCV();
                        $user->deleteAvatar();
                        // delete instructor if no approved course
                        if ($instructor->courses->where('status', 'approved')->count() > 0) {
                            $instructor->delete();
                            $user->delete();
                        } else {
                            $instructor->forceDelete();
                            $user->forceDelete();
                        }
                    } elseif ($status == 'unblock') {
                        $user->status = 'active';
                        $user->save();
                    } elseif ($status == 'suspended') {
                        $user->status = $status;
                        $user->save();
                    }
                    DB::commit();
                    // event(new SendMailNoticeToInstructorEvent($instructor));
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Cập nhật trạng thái thành công',
                        'statusName' => $instructor->getStatusName(),
                        'badgeColor' => $instructor->getBadgeColor()
                    ]);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Cập nhật trạng thái thất bại'
                    ]);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
        }

        private function generateTemporaryPassword(): string
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            return substr(str_shuffle($characters), 0, 8);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(UpdateInstructorRequest $request, Instructor $instructor)
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Instructor $instructor): void
        {
            // delete avatar
            $instructor->delete();
        }
    }
