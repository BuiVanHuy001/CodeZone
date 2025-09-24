<?php

namespace App\Support;

class MomoResultCodes
{
    private static array $resultCodes = [
        0 => 'Thành công.',
        10 => 'Hệ thống đang được bảo trì.',
        11 => 'Truy cập bị từ chối.',
        12 => 'Phiên bản API không được hỗ trợ cho yêu cầu này.',
        13 => 'Xác thực doanh nghiệp thất bại.',
        20 => 'Yêu cầu sai định dạng.',
        21 => 'Yêu cầu bị từ chối vì số tiền giao dịch không hợp lệ.',
        22 => 'Số tiền giao dịch không hợp lệ.',
        40 => 'RequestId bị trùng.',
        41 => 'OrderId bị trùng.',
        42 => 'OrderId không hợp lệ hoặc không được tìm thấy.',
        43 => 'Yêu cầu bị từ chối vì xung đột trong quá trình xử lý giao dịch.',
        45 => 'Trùng ItemId',
        47 => 'Yêu cầu bị từ chối vì thông tin không hợp lệ trong danh sách dữ liệu khả dụng',
        98 => 'QR Code tạo không thành công. Vui lòng thử lại sau.',
        99 => 'Lỗi không xác định.',
        1000 => 'Giao dịch đã được khởi tạo, chờ người dùng xác nhận thanh toán.',
        1001 => 'Giao dịch thanh toán thất bại do tài khoản người dùng không đủ tiền.',
        1002 => 'Giao dịch bị từ chối do nhà phát hành tài khoản thanh toán.',
        1003 => 'Giao dịch bị đã bị hủy.',
        1004 => 'Giao dịch thất bại do số tiền thanh toán vượt quá hạn mức thanh toán của người dùng.',
        1005 => 'Giao dịch thất bại do url hoặc QR code đã hết hạn.',
        1006 => 'Giao dịch thất bại do người dùng đã từ chối xác nhận thanh toán.',
        1007 => 'Giao dịch bị từ chối vì tài khoản không tồn tại hoặc đang ở trạng thái ngưng hoạt động.',
        1017 => 'Giao dịch bị hủy bởi đối tác.',
        1026 => 'Giao dịch bị hạn chế theo thể lệ chương trình khuyến mãi.',
        1080 => 'Giao dịch hoàn tiền thất bại trong quá trình xử lý. Vui lòng thử lại trong khoảng thời gian ngắn, tốt hơn là sau một giờ.',
        1081 => 'Giao dịch hoàn tiền bị từ chối. Giao dịch thanh toán ban đầu có thể đã được hoàn.',
        1088 => 'Giao dịch hoàn tiền bị từ chối. Giao dịch thanh toán ban đầu không được hỗ trợ hoàn tiền.',
        2019 => 'Yêu cầu bị từ chối vì orderGroupId không hợp lệ.',
        4001 => 'Giao dịch bị từ chối do tài khoản người dùng đang bị hạn chế.',
        4002 => 'Giao dịch bị từ chối do tài khoản người dùng chưa được xác thực với C06.',
        4100 => 'Giao dịch thất bại do người dùng không đăng nhập thành công.',
        7000 => 'Giao dịch đang được xử lý.',
        7002 => 'Giao dịch đang được xử lý bởi nhà cung cấp loại hình thanh toán.',
        9000 => 'Giao dịch đã được xác nhận thành công.',
    ];

    public static function get(int $code): string
    {
        return self::$resultCodes[$code] ?? 'Không xác định';

    }
}
