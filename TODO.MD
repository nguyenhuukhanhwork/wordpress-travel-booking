# Todo List

## Tìm hiểu thắc mắc lý thuyết
- [yes] Nghiên cứu cơ chế REST API

## Bootstrap
- [Yes] Thêm Option để quản lý DB đã Installed chưa
- [] 

## Infrastructure
- [yes] Tạo data option là dữ liệu CPT của Tour để người dùng chọn
- [yes] Thêm Class tạo Log riêng
- [] Tìm cách giải quyết cập nhật tự động Database ở bảng Index.
- [] Giải quyết vấn đề khóa ngoại và liên kết bảng
- 

## Repository
- [Yes] Thêm Repository cho BookingIndex, BookingMeta, TourScheduler
- [Yes] Add - Method Filter Tour nâng cao, lọc theo ID của các Tax liên quan 
- [] 

## Config
- [yes] Add Enum Status
- []
- []


## Presentation
- [] Refactor lại build Search theo API, dùng thẳng Filter theo name không cần phải theo ID
- [] Tạo Form Shortcode cho Search CPT Tour, có auto Completed
- [] Tạo Form đặt lịch du lịch:
  - [yes] Sử dụng CF7
  - [yes] Multi step (contact, booking info, note)
  - [yes] Sử dụng Data option
  - [yes] Sử dụng handle CF7
  - [yes] Lưu vào DB
  - [yes] Send Telegram Notification 
  - [] Refactor lại thành các field hợp lệ
  
- [yes] Tạo REST API lưu toàn bộ Tour Entity
- [] Tạo Form Filter:
  - Xắp xếp theo giá
  - Chọn điểm đến
  - Chọn phương tiện duy chuyển
  - Chọn số lượng người tối đa

## Application 
- [] UseCase Sửa Form Booking lại
- [] UseCase thêm Form Search Name
- [] UseCase cứ search theo name Term bình thường

## Refactor
- [yes] Sửa Namespace hệ thống
- [yes] Đổi folder để Config tập trung trong inc/Config
- [yes] Các Method Insert  phải trả về ID
- [yes] Enum các giá trí choose
- [yes] BaseTable sẽ lo luôn CRUD, các Class con chỉ cần khai báo tên Table, tên ID của Table là chạy được

## Theme 
- [] Sử dụng Theme Flatsome để build Page
- [] Tạo child theme để code hiển thị Post Type Tour (single-tour) và archive-tour hoặc thử giải pháp FlatSome thử
- [] Lấy Shortcode ra hiển thị Post Type Tour

## Nghiệp vụ
- [yes] Export Post Type bằng CSV
- [yes] Design Form:
  - Contact cơ bản
  - Booking Travel
  - Feedback hoặc thắc mắc


## Section Design
- [] Hero Section (Search)
- [] Tour Section (Tập hợp các Tour ở archive-tour)
- [] Feature Tour Section 
- [] Điểm đến Section
- [] FAQ Section 

## Đang làm dang dở:
- Class `AdvancedSearchTourRestShortcode` đang thiếu Enqueue Script

## Nhiệm vụ tiếp theo
- [] REST API lấy thẳng theo Name đừng chơi theo ID của Term Taxonomy
- [yes] Refactor Notification (Tách method nạp dữ liệu và gửi dữ liệu riêng ra)
- [] Refactor Entity Status 
- [] Entity không được chứa cái gì liên quan đến Database
- [yes] Thêm Entity Tour
- [] 

## File Mới cần tìm hiểu của REST API:
- [] Presentation/Shortcodes/TourSearch - Form Tour Search, lấy thông tin từ REST API ? 
- [] SearchTourEntitySearchController - Nó đang Filter dữ liệu ở tâng Repository ra sao ?  
- [] Các Method cần tìm hiểu trong TourRepository `applyFilters`, `applySorting`, `getSortValue`
- [] Refactor Flow