Hôm nay mình xin trình bày về hệ thống cơ sở dữ liệu cho đề tài nhóm mình là một nền tảng học trực tuyến.

Mô tả sơ về đề tài này thì đây là một nền tảng kết nối giảng viên những người cung cấp khóa học với học viên những người mua khóa học. Các tính năng chính của đề tài là cho phép người dùng đăng ký tài khoản, tham gia các khóa học, học từng bài học theo lộ trình, làm bài kiểm tra, đánh giá và theo dõi tiến độ học tập của mình.

Cơ sở dữ liệu của chúng tôi được chia thành các nhóm chính như sau:

**1. Quản lý người dùng**

- Bảng user lưu thông tin tài khoản người dùng như email, mật khẩu và trạng thái.

- Mỗi người dùng có thể là giảng viên hoặc học viên hoặc admin, và có hồ sơ riêng được lưu trong instructor_profile và student_profile.

**2. Quản lý khóa học và nội dung học tập**

- Các khóa học được lưu trong bảng *courses*, phân loại bằng `categories`.

- Mỗi khóa học gồm nhiều `modules`, và mỗi module có nhiều `lessons`.

- Mỗi bài học có thể kèm theo video và nội dung chi tiết.

- Mỗi `lesson` có thể có một quiz.

- Quiz gồm nhiều `quiz_questions`, và mỗi câu hỏi có nhiều `quiz_options`.

- Mỗi lần làm bài quiz được lưu trong `quiz_attempts`, kèm điểm số và trạng thái đậu/rớt.

- Các câu trả lời của học viên được lưu chi tiết trong `quiz_answers`, liên kết với từng câu hỏi và đáp án đã chọn.

**3. Tính năng tương tác người dùng**

Người học có thể tương tác thông qua:

- Đánh giá khóa học và giảng viên qua bảng `reviews`, giúp cải thiện chất lượng nội dung.

- `comment`, `like`, và `dislike` trên bài học, blog hoặc khóa học.

- Tất cả được thiết kế để sử dụng Polymorphic Relationships, giúp tái sử dụng bảng hiệu quả.

Ngoài ra, giảng viên có thể viết blog để chia sẻ kiến thức chuyên sâu hơn và được lưu thông qua bảng `blogs`.

**4. Quản lý đơn hàng và thanh toán**

Học viên có thể mua khóa học thông qua hệ thống thanh toán online như VNPAY hoặc MOMO.

* Bảng `orders` lưu đơn hàng, trạng thái và phương thức thanh toán.

* Bảng `order_items` lưu danh sách các khóa học trong đơn hàng.

**5. Theo dõi tiến độ học tập**

- Bảng `progress_trackings` giúp ghi lại học viên đã hoàn thành bài học nào, vào lúc nào.

- Tính toán % hoàn thành khóa học thống kê vào dashboard.

Tóm lại, sơ đồ ERD này thể hiện một nền tảng học trực tuyến, từ học tập, kiểm tra, mua bán đến theo dõi kết quả.


Cảm ơn mọi người đã lắng nghe. Nếu có câu hỏi nào, mình xin sẵn sàng giải đáp