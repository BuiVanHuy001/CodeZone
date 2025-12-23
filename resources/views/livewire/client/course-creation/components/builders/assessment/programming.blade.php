<x-client.dashboard.course-creation.builders.assessment-types.base
    title="Thực hành lập trình"
    name="programming">
    <div x-show="showDetail">
        <div class="tab-1" x-show="step === 1">
            <x-client.dashboard.inputs.text
                model="programming.title"
                name="programming.title"
                label="Tiêu đề bài toán"
                placeholder="Ví dụ: Tính tổng hai số, Kiểm tra chuỗi đối xứng..."
                info="Nhập tiêu đề ngắn gọn và súc tích cho bài tập lập trình của bạn."
            />

            <livewire:client.shared.markdown-editor
                wire:model="programming.description"
                label="Mô tả"
                name="programming.description"
                :errorMessage="$errors->first('programming.description')"
            />

            <div class="d-flex pt--30 justify-content-between">
                <div class="content">
                    <button wire:click="remove" type="button" class="awe-btn bg-danger">
                        Hủy bỏ
                    </button>
                </div>
                <div class="content">
                    <button class="awe-btn" @click.prevent="$wire.validateStep1().then(ok => ok && (step = 2))">
                        Tiếp theo
                    </button>
                </div>
            </div>
        </div>

        <div class="tab-2" x-show="step === 2">
            <div class="row g-5">
                <div class="col-12">
                    <div class="p-4 border rounded bg-white shadow-sm">
                        <h5 class="mb-4 text-primary border-bottom pb-2">1. Cấu hình hàm (Function Signature)</h5>
                        <div class="row g-4">
                            <x-client.dashboard.inputs.text
                                model="problem.function_name"
                                class="col-lg-6"
                                name="problem.function_name"
                                label="Tên hàm (Function Name)"
                                placeholder="e.g., twoSum, findMax"
                                info="Tên hàm hệ thống sẽ gọi để kiểm tra. Nên đặt theo quy chuẩn camelCase."
                            />

                            <x-client.dashboard.inputs.select
                                wire:model.lazy="problem.return_type"
                                class="col-lg-6"
                                name="problem.return_type"
                                label="Kiểu dữ liệu trả về (Return Type)"
                                :options="$typeMap"
                                placeholder="-- Chọn kiểu trả về --"
                                info="Kết quả mà hàm của sinh viên cần trả về."
                            />
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="p-4 border rounded bg-white shadow-sm">
                        <h5 class="mb-4 text-primary border-bottom pb-2">2. Tham số đầu vào (Parameters)</h5>

                        @if(!empty($problem['params']))
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px">#</th>
                                        <th>Tên tham số</th>
                                        <th>Kiểu dữ liệu</th>
                                        <th class="text-center" style="width: 100px">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($problem['params'] as $index => $param)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="fw-bold text-dark">{{ $param['name'] }}</td>
                                            <td>
                                            <span class="badge bg-light text-primary border border-primary">
                                                {{ $typeMap[$param['type']]['label'] }}
                                            </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeParameter({{ $index }})">
                                                    <i class="feather-trash-2"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
                                <i class="feather-alert-circle me-2"></i> Chưa có tham số nào. Vui lòng thêm tham số bên
                                dưới.
                            </div>
                        @endif

                        <div class="bg-light p-3 rounded border">
                            <h6 class="mb-3 font-system-bold">Thêm tham số mới</h6>
                            <div class="row g-3 align-items-end">
                                <x-client.dashboard.inputs.select
                                    wire:model.lazy="newParam.type"
                                    class="col-lg-6"
                                    name="newParam.type"
                                    label="Kiểu dữ liệu"
                                    :options="$typeMap"
                                    placeholder="-- Chọn kiểu --"
                                    info="Kiểu dữ liệu của tham số đầu vào."
                                />

                                <x-client.dashboard.inputs.text
                                    model="newParam.name"
                                    class="col-lg-6"
                                    name="newParam.name"
                                    label="Tên biến (e.g., nums, target)"
                                    placeholder="Nhập tên tham số"
                                    info="Nên đặt theo quy chuẩn camelCase."
                                />

                                <div class="col-md-3">
                                    <button class="rbt-btn btn-sm btn-gradient w-100 radius-round-10" type="button" wire:click="addParameter">
                                        <i class="feather-plus"></i> Thêm
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="p-4 border rounded bg-white shadow-sm">
                        <h5 class="mb-4 text-primary border-bottom pb-2">3. Bộ kiểm thử (Test Cases)</h5>

                        @if(!empty($problem['params']))
                            <div class="bg-light p-4 rounded border mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0 font-system-bold text-primary">Tạo Test Case Mới</h6>
                                    <span class="badge bg-white text-secondary border">Điền giá trị đầu vào và kết quả mong đợi</span>
                                </div>

                                <div class="row g-3">
                                    @foreach($this->newTestCase['inputs'] as $index => $param)
                                        <x-client.dashboard.inputs.text
                                            model="newTestCase.inputs.{{ $index }}.value"
                                            class="col-lg-6"
                                            name="newTestCase.inputs.{{ $index }}.value"
                                            label="Input: {{ $param['name'] }} <span class='text-muted fw-normal'>({{ $typeMap[$param['type']]['label'] }})</span>"
                                            placeholder="VD: {{ $typeMap[$param['type']]['example'] }}"
                                            info="Nên đặt theo quy chuẩn camelCase."
                                        />
                                    @endforeach

                                    @if(isset($newTestCase['output']))
                                        <x-client.dashboard.inputs.text
                                            model="newTestCase.output.value"
                                            class="col-lg-6"
                                            name="newTestCase.output.value"
                                            label="Output Mong Đợi"
                                            placeholder="VD: {{ $typeMap[$param['type']]['example'] }}"
                                            info="Kết quả mà hàm cần trả về."
                                        />
                                    @endif

                                    <div class="col-12 text-end mt-3">
                                        <button class="rbt-btn btn-sm btn-border hover-icon-reverse radius-round-10" type="button" wire:click="addTestCase">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Thêm Test Case</span>
                                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                    </span>
                                        </button>
                                    </div>
                                    <div class="col-12">
                                        @error('newTestCase.output.*')
                                        <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            @if(!empty($problem['test_cases']))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle">
                                        <thead class="table-dark">
                                        <tr>
                                            <th class="text-center" style="width: 50px">#</th>
                                            <th>Dữ liệu đầu vào (Input)</th>
                                            <th>Kết quả mong đợi (Expected Output)</th>
                                            <th class="text-center" style="width: 80px">Xóa</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($problem['test_cases'] as $index => $testCase)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach($testCase['inputs'] as $input)
                                                            <span class="badge bg-white text-dark border">
                                                            {{ $input['name'] }} = <code>{{ $input['value'] }}</code>
                                                        </span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td>
                                                    <code class="fs-6 text-success fw-bold">{{ $testCase['output']['value'] }}</code>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-danger p-1" style="width: 30px; height: 30px;" wire:click="removeTestCase({{ $index }})">
                                                        <i class="feather-trash-2"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-center text-muted fst-italic py-3 border border-dashed rounded">Chưa có
                                    bộ kiểm thử nào.</p>
                            @endif
                        @else
                            <div class="alert alert-info">
                                <i class="feather-info"></i> Vui lòng thêm ít nhất một tham số ở Bước 2 để kích hoạt
                                tính năng tạo Test Case.
                            </div>
                        @endif
                    </div>
                </div>

                @if($this->canSelectLanguages)
                    <div class="col-12">
                        <div class="p-4 border rounded bg-white shadow-sm">
                            <h5 class="mb-4 text-primary border-bottom pb-2">4. Ngôn ngữ cho phép</h5>

                            <div class="mb-3">
                                <label class="form-label font-system-bold">Sinh viên được phép sử dụng các ngôn ngữ
                                    sau:</label>
                                <p class="text-muted small mb-0"><i class="feather-info"></i> Tích chọn các ngôn ngữ bạn
                                    muốn hệ thống hỗ trợ chấm bài.</p>
                            </div>

                            <div class="row g-3">
                                @foreach(\App\Models\ProgrammingProblems::$SUPPORTED_LANGUAGES as $langKey => $langName)
                                    <div class="col-md-3 col-sm-4 col-6">
                                        <div class="form-check p-3 border rounded bg-light position-relative h-100 d-flex align-items-center transition-hover">
                                            <input class="form-check-input fs-5 me-2"
                                                   type="checkbox"
                                                   value="{{ $langKey }}"
                                                   id="lang-{{ $langKey }}"
                                                   wire:model="problem.allowed_languages">

                                            <label class="form-check-label w-100 cursor-pointer fw-bold stretched-link text-dark" for="lang-{{ $langKey }}">
                                                {{ $langName }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @error('problem.allowed_languages')
                            <div class="alert alert-danger d-flex align-items-center mt-3 py-2">
                                <i class="feather-alert-triangle me-2"></i> {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                @endif

                <div class="col-12 mt-4">
                    <div class="d-flex justify-content-between p-4 bg-light rounded border">
                        <div class="content">
                            <button wire:click="remove" type="button" class="rbt-btn btn-border btn-md radius-round-10 bg-white text-danger">
                                Hủy bỏ
                            </button>
                        </div>
                        <div class="content d-flex gap-3">
                            <button type="button" class="rbt-btn btn-border btn-md radius-round-10" @click="step = 1">
                                <i class="feather-arrow-left"></i> Quay lại
                            </button>
                            <button wire:click="saveProgramming" type="button" class="rbt-btn btn-md radius-round-10 btn-gradient hover-icon-reverse">
                         <span class="icon-reverse-wrapper">
                            <span class="btn-text">Lưu bài tập</span>
                            <span class="btn-icon"><i class="feather-save"></i></span>
                            <span class="btn-icon"><i class="feather-save"></i></span>
                        </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-client.dashboard.course-creation.builders.assessment-types.base>

@script
<script>
    createCodeEditor(
        'programming-description-editor',
        'markdown',
        @json($programming['description'] ?? '', JSON_THROW_ON_ERROR),
        false,
        @json($this->getId(), JSON_THROW_ON_ERROR),
        'programming.description'
    );
</script>
@endscript
