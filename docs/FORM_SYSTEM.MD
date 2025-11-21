# Form System

Trong hệ thống này, sử dụng các Form Contact tích hợp với Contact Form 7. Hệ thống Form bao gồm:
- Form liên hệ cơ bản (Khiếu nại, thắc mắc,...)
- Form Booking
- Form Search, Filter (Code)

## Form liên hệ
- Mục tiêu: để ở FE cho người dùng viết Contact cơ bản
- Fields:
  - Name
  - Phone
  - Email (Option)
  - Ghi chú

## Form Booking
- Mục tiêu: Để người dùng đặt lịch, lưu dữ liệu Booking vào hệ thống
- Fields:
  - Contact:
    - Tên, người đại diện
    - Phone, người đại diện
    - Phone 2 (Option) người đại diện
  - Tour
    - Select, Tên Tour
    - Select, Số người
    - Select, Ngày khởi hành
    - Select, Thời lượng
    - Select, Số người lớn
    - Select, Số trẻ em
  - Thông tin thêm: 
    - Ghi chú


## Contact Form 7 data

### Form Contact Basic

```html
<!-- Form ID: 561 -->

[text*  travel-booking-customer-name minlength:2 maxlength:25 placeholder "Họ và tên"]

[email* travel-booking-customer-email maxlength:40 placeholder "Email"]

[tel* travel-booking-customer-phone maxlength:21 placeholder "Phone"]

[textarea travel-booking-customer-note maxlength:120 placeholder "Ghi chú"]

[submit "Gửi đi"]
```


Tiền số `trbooking_`

```html
<!-- Form ID: 551 -->

<div class="trbooking_warpper">
    <!-- Tour Customer infomation -->
    <h2>Thông tin người đại diện đặt Tour</h2>

    <label>Họ và tên</label>
    [text* trbooking_customer_name minlength:2 maxlength:25 placeholder "Họ và tên"]

    <label>Email (Tùy chọn)</label>
    [email trbooking_customer_email  maxlength:40 placeholder "Email"]

    <label>Số điện thoại</label>
    [tel* trbooking_customer_phone maxlength:21 placeholder "Phone"]

    <h2>Thông tin Tour</h2>
    <!-- Tour booking information -->
    <label>Chọn Tour</label> [select* trbooking_tour_name data:tour-post-type-name-data]

    <label>Số người lớn</label>
    [select* trbooking_tour_adults
    class:half-width
    "Số người lớn" "1" "2" "3" "4" "5" "6" "7" "8" "9"
    ]
    <label>Số trẻ em (Nhỏ hơn 10 tuổi)</label>
    [select* trbooking_tour_child class:half-width
    "Số trẻ em (Nhỏ hơn 10 tuổi)"
    "0" "1" "2" "3" "4" "5" "6" "7" "8" "9"
    ]

    <label>Ghi chú</label>
    [textarea trbooking_tour_note maxlength:300 placeholder "Ghi chú thêm (nếu có)"]

    [submit "Đặt Tour"]
</div>
```
### Form Register