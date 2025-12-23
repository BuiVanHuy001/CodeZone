<div class="rbt-contact-form contact-form-style-1 max-width-auto mx-auto my-5 w-50">
    <h3 class="title text-center">Khôi phục tài khoản</h3>

    @if($user)
        <div class="rbt-avatars m-auto mb-4">
            <img src="{{ $user->getAvatarPath() }}" alt="Ảnh đại diện">
        </div>
        <h5 class="text-center mb-2">Xin chào, {{ $user->name }}</h5>
        <p class="text-center text-muted mb-4">
            Hệ thống sẽ gửi liên kết đặt lại mật khẩu đến email <strong>{{ $user->email }}</strong> của bạn.
        </p>

        <div class="text-center">
            <button wire:click="sendPasswordResetLink"
                    class="rbt-btn btn-gradient w-50"
                    wire:loading.attr="disabled"
                    wire:target="sendPasswordResetLink">
                <span wire:loading.remove wire:target="sendPasswordResetLink">Gửi liên kết khôi phục</span>
                <span wire:loading wire:target="sendPasswordResetLink">Đang gửi...</span>
            </button>

            <button wire:click="$set('user', null)" class="rbt-btn-link mt-3 d-block small">
                Không phải bạn? Tìm tài khoản khác
            </button>
        </div>

    @else
        <form class="max-width-auto" wire:submit="findAccount">
            <x-client.dashboard.inputs.text
                model="emailInput"
                label="Địa chỉ Email"
                type="email"
                name="emailInput"
                placeholder="Ví dụ: sv.nguyenvana@caodangvietmy.edu.vn"
                info="Vui lòng nhập email sinh viên hoặc email cá nhân đã đăng ký trên hệ thống."
            />

            <div class="d-flex justify-content-center mb-5 mt-4">
                <button type="submit"
                        class="rbt-btn btn-gradient w-50 mx-auto"
                        wire:loading.attr="disabled"
                        wire:target="findAccount">
                    <span wire:loading.remove wire:target="findAccount">Tìm tài khoản</span>
                    <span wire:loading wire:target="findAccount">Đang kiểm tra...</span>
                </button>
            </div>
        </form>

        <div class="text-center mb-3">
            <p class="description">Bạn chưa có tài khoản sinh viên?
                <a class="rbt-btn-link" href="{{ route('student.register') }}"><strong>Đăng ký tại đây</strong></a>
            </p>
        </div>
    @endif
</div>
