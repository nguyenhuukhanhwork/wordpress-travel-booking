# TourBooking Pro – Hệ thống đặt tour tự động

## Warning

Đây là project đang phát triển (chưa hoàn thành), phục vụ cho việc học tập.

## Mục tiêu
Xây dựng hệ thống đặt tour hoàn chỉnh: **tìm kiếm, đặt tour, lưu DB, gửi Telegram, quản trị**.

## Công nghệ
- WordPress + Custom Post Type + ACF
- Clean Architecture + Repository Pattern
- REST API + Vanilla JS (Shortcode)
- Custom DB Tables + Cache
- Telegram Bot Notification
- Unit Test + Documentation

## Vai trò của các Folder
- inc/Application:
- inc/Config: Quản lý tập trung các file cấu hình gồm:
  - ENUM tên của các cột trong bảng
  - File JSON chứa các cấu hình liên quan đến Core WP: CPT, ACF, Taxonomies
- inc/Domain: Chứa các Model (đối tượng nghiệp vụ) của hệ thống, đây là nơi thuần OOP để bảo vệ sự thay đổi công nghệ
- inc/Infrastructure: Chứa hạ tầng liên phục vụ cho hệ thống: notification, log, cache, database
- inc/Presentation: Chứa các Shortcode, CSS, JS phục vụ cho việc hiển thị lên trình duyệt
- inc/Tool: Các tool hổ trợ làm việc như WP-CLI

## Demo
- Frontend: `[tour_search]` shortcode
- API: `/wp-json/travel-booking/v1/search-tours`
- Admin: Quản lý tour, booking, khách hàng

## URL liên quan
- [Trello URL](https://trello.com/b/mJXDtZic)
- [My Trello URL](https://trello.com/b/mJXDtZic/wordpress-plugin-travel-booking)
- [Github Repository](https://github.com/nguyenhuukhanhwork/wordpress-travel-booking)
