# VnCoder Core
VnCoder Core - Sử dụng cho các dự án của Cương Phạm

## assets
Thư mục chứa các assets chung sử dụng trong các dự án
Liên kết động: /core/js/... , /core/css/...

## config
Chứa cấu hình mặc định cho hệ thống
Sửa đổi sẽ ảnh hưởng tới toàn bộ dự án liên quan

## src
Thư mục Core hệ thống
### Controllers
Chứa các controller mặc định cho dự án.
Các controller khác đều kế thừa mở rộng từ đây
### Models
Chứa các Models chung hệ thống
Các model mở rộng viết tại App\Models và phải kế thừa VnModels
### Views
Core View hệ thống
### Backend
Thư mục cấu hình cho quản trị viên
Kế thừa cho dự án từ thư mục App\Admin
### Console
Quản lý lệnh
Câu lệnh: ``` php artisan run abc xyz ```
Hệ thống sẽ tự động gọi đến function Xyz_Action trong class AbcController, lưu tại thư mục App\Admin\Command
### Exceptions\VnCoderHandler.php
Quản lý các Exception của hệ thống
### Helper
Thư mục chứa các Helper dùng chung
Nếu 1 chức năng được sử dụng cho nhiều dự án sẽ đóng gói lại và cho vào đây
### Middleware
Chứa các Middleware chung của hệ thống
### Jobs
Các Jobs mặc định của hệ thống
Các job khởi tạo mới trong thư mục App\Jobs và phải kế thừa VnJobs
