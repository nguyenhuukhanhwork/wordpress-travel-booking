# LEARNING LOG

## Các câu hỏi tự hỏi

- Đâu là cái khó nhất: Làm FE đặc biệt là có JavaScript, tôi hơi yếu do chưa va chạm với nó nhiều

## Kiến thức cần bổ xung

Design Parrtern
- Creational Patterns (Tạo đối tượng): Singleton, Factory Method, Abstract Factory, Builder, Prototype…
- Structural Patterns (Cấu trúc): Adapter, Decorator, Facade, Composite, Proxy…
- Behavioral Patterns (Hành vi): Observer, Strategy, Command, State, Template Method, Visitor…

## Concept cần viết tài liệu
- Value Object
- DTO
- Kỹ thuật restruct tái cấu trúc 1 object để né valiate, và giữ được tính bất biến immutable (private của entity)
- over-engineering: thuộc phạm trù tâm lý trong kỹ thuật
- Thắt cổ chai, cửa sổ vỡ
- scatter cache
- Cache nâng cao  Centralized Cache Facade hoặc Cache Namespace Manager.
- bounded context - nhóm dữ liệu
- In-memory cache + CacheManager
- “Anti-Corruption Layer” (ACL) trong DDD
- PURE DOMAIN OBJECT
- pain point



### Câu hỏi tôi đặt ra
- Trong kiến trúc Clean Architecture, nếu Domain đảm nhiệm luôn Factory và Mapper thì lỡ công nghệ thay đổi nó có bị chết không ?
- Nếu Entity là private thì làm sao để Factory khởi tạo được ? => Chỉ dùng cho project cực lớn chuẩn theo lý thuyết DDD
- Nếu là dự án vừa vừa dưới 50 entity thì chơi theo Factory nằm trong Entity luôn

## Problems
Format:  Problem → Difficulty → Solution → Learned

### Import Post Type bằng CSV

**Problem:** 

Trong lúc phát triển Plugin này, tôi suy nghĩ đến vấn đề làm sao để Import dữ liệu nhanh vào hệ thống để dễ dàng Testing, Migrate sang hệ thống khác nhanh chóng.

Cách xử lý ban đầu:
- Sử dụng WP CLI Script để tạo dữ liệu
- Dùng PHP để viết thẳng Import
- Sử dụng Import CSV
- 

**Difficulty**

- Nếu dùng WP-CLI thì có vẻ không tiện nếu đưa qua nhiều site và nó Portable
- Dùng PHP thì hơi khó, viết ra thì phải thiết kế trong kiến trúc => mất thời gian
- Dùng Import để xử lý là giải pháp tôi thử đầu tiên, sau khi test thử một vài công cụ không thành công như WP All Import,... thì cuối cùng sử dụng `wp-ultimate-csv-importer` thì import ok

Vấn đề tôi gặp phải: Import dữ liệu xong nhưng hàm `get_fields` của Plugin Advanced Custom Field không lấy được dữ liệu của Post `tour`, nên tôi Test thử bằng các công cụ khác:
- WP CLI thì kiểm tra `meta data` thì có dữ liệu
- Hàm `get_field` lấy field lẽ thì có dữ liệu
- Hàm `get_post_meta` của Wordpress thì có thể lấy dữ liệu được
- Nếu dùng `update_field` truyền dữ liệu vào thì hàm `get_fields` nhận dữ liệu
- Admin của Advanced Custom Field vẫn đọc được dữ liệu Field và hiển thị lên Admin

**Solution**

Sử dụng hàm `get_post_meta`,  để đọc Field để tăng tốc độ xử lý

**Learned**

- Phát hiện ra lỗi không đọc database của hàm `get_fields` của Plugin Advanced Custom Field
- Sử dụng `get_post_meta` của Wordpress cải thiện hiệu năng tốt hơn

---

### Chưa hiểu rõ cách Testing sao cho nhanh

Ở trong môi trường Local để Test đọc dữ liệu hiển thị của các API ví dụ như `TourRepository::getInstance()->getAll()`

Tìm hiểu Grok/Chat GPT thì nó đề xuất giải pháp load luôn:

```php
add_action('init', function () {
    if (!isset($_GET['test_booking_use_case'])) {
        return;
    }
    
    test_use_case_booking_form_cf7();

    dd('DONE TESTING');
});
```

Sử dụng cách này hay ở chỗ là phải kích hoạt nó mới chạy, kiểm soát được, kích hoạt đơn giản thông qua `query string` `/?test_booking_use_case=1`


### Phân vân giữa sử dụng dùng JSON Config hay Code PHP thì cấu hình Post Type, ACF và Taxonomy sẽ ok hơn

**Problem**

Tôi phân vân giữa việc sử dụng:
- JSON Config => linh hoạt đưa sang site khác vẫn thao tác dễ
- PHP code => hiệu năng

Sau khi nghiên cứu đọc qua phân tích của ChatGPT/Grok/Claud thì tôi thấy giải pháp dùng JSON + Cache `get_transient` là ok và chọn cách này luôn.

Lý do:
- Đây là CPT, ACF và Taxonomy riêng nên ít thay đổi => Cache lại ổn áp, tăng hiệu năng
- Linh hoạt, đưa sang site khác triển khai nhanh chóng

### Không biết các Search REST API

### Vấn đề kế thừa và Interface - làm sao để Class con bắt buộc phải khai báo các thứ mình cần


### Phân vân giữa kiến trúc tinh gọn dễ hiểu và đầy đủ của kiến trúc Multi Layer

Ban đầu khi bắt đầu code project này tôi đã chọn trước kiến trúc là Multi-Layer cho hệ thống vì vừa đọc xong cuốn sách về kiến trúc phần mềm, nên muốn làm thử.

Kết quả khi các Chat Bot gợi ý thì quá là ngộp vì:
- Không hiểu tại sao phải có các Class như DTO, Entity tồn tại.
- Tạo sao phải tạo Entity làm gì ? Không nạp luôn dữ liệu xuống Database
- Cách xử lý ra làm sao vì class liên kết quá nhiều
- Tại sao phải có các Method thừa và phải Validate nhiều đến thế cho 1 hệ thống nhỏ

Rồi tôi code từ từ, xây dựng tầng Infrastructure trước sau đó xây Repository ban đầu tôi chia nó làm 2 tầng, code lên Repository suy nghĩ thiếu cái gì xuống thêm method vào Infrastructure


### Không biết sử dụng Redis Cache

Ban đầu tôi cũng phân vân về vấn đề hiệu năng, muốn sử dụng Redis Cache nhưng sợ cài khó khăn, rồi làm ở Local thì không hiểu Server, nhưng khi cài thử nó đơn giản:

**Learned**

- Chỉ cần cài bằng Terminal Ubuntu, không cần cấu hình phức tạp
- Cài thêm Plugin trong Wordpress để quản lý dễ hơn đối với Beginner
- Có thể dùng Command Line để kiểm tra
- Không cần phải khởi động thủ công
- Không cần Refactor lại Infrastructure/Cache và transient API đã lo luôn
- Nó giúp cái thiện hiệu năng đáng kể không riêng gì những Cache Object mình kiểm soát, các API WP cũng được Cache luôn
- Hiểu được sự khác biệt giữa Cache Object và Cache Page

### Ở mỗi chức năng mới đều không biết sẽ đưa nó vào tầng nào

Khi xử lý một vấn đề mới tôi không biết đưa Class đó vào đâu đều phải hỏi ChatBot, rồi từ từ nắm ý tưởng tự làm có sai thì Refactor sau.

Sử dụng Command `tree` để đưa cây thư mục cho ChatBot xem, cho nó tư vấn ok hơn

### Phân vân ở Repository có nên ràng buộc các parameter hay không để khi chèn không bị sót dữ liệu



### Xóa các thứ như Entity, DTO nhưng rồi tạo lại do bị ngột kiến trúc

Do ban đầu không hiểu kiến trúc => bị ngột, AI tạo ra code, tôi đọc không hiểu thì để đó, đến khi hiểu chút ít thì lại xóa vì chưa hiểu nó dùng vào việc gì.

Sau khi làm việc với Contact Form 7 nhận data từ Front-End truyền vào thì mới hiểu tại sao có Entity, DTO trong hệ thống.


### Mỗi lần testing Form phải ra ngoài Form điền => Thiếu chuyên nghiệp, phải làm sao cho tối ưu? - 17-11-2025

Tạo 1 Array Fake data truyền thẳng dữ liệu vào để Test sẽ nhanh gọn lẹ hơn là dùng Form. 

Tôi có cài thử thư viện PHP Unit Test mà làm 1 mình nên chưa có thời gian xử lý


### Làm sao để xác định được ID của Contact Form 7 nếu hệ thống Import sang site khác (Dùng Slug) - 17-11-2025

Ban đầu xác định ID cũng nhìn vào Database, dùng WP-CLI để kiểm tra rồi code nhưng rồi thấy cách này bất ổn khi import sang site khác. Mới suy nghĩ các giải pháp:
- Đặt ID do mình quy định rất đặc biệt để tránh trùng
- Sử dụng UUID (Hash ID) thì phiền
- Ghi Dùng WP-CLI Import ghi đè thì không được, do cơ chế nó sẽ Import kiểu khác

Cuối cùng nhờ ChatBot tôi biết đến giải phap dùng Slug thì cách này tôi thấy ổn áp, chơi được.


### Xử lý bất đồng bộ thế nào cho vừa phải (Action Scheduler) - 17-11-2025

Vấn đề Cron Job này không phải là vấn đề lần đầu nhưng đến nay vẫn thấy khó khăn trong xử lý bất đồng bộ Wordpress:
- Nếu dùng công nghệ Third-Party thì hơi thừa
- Dùng Cron Wordpress thì phụ thuộc Traffic
- Dùng Cron Job System thì không rõ 

Trong lần này tôi đã tích hợp được Action Scheduler của Woocommer, và biết dùng CRON System để kích CRON site xử lý vấn đề:
- Gửi Notification bất đồng bộ
- Xử lý nặng bất đồng bộ


### Repository không được là Singleton trong kiến trúc Multi Layer

```csv
Tiêu chí,Repository dùng Singleton (getInstance()),Repository dùng DI (Constructor Injection),Kết luận
Có thể unit test không cần DB?,Không thể mock → test luôn hit DB thật,"Dễ dàng mock → test nhanh, sạch 100%",DI thắng
Có thể thay đổi DB (MySQL → PostgreSQL → Mongo)?,Không (hard-code trong Singleton),Có (inject implementation khác),DI thắng
Vi phạm Dependency Inversion (D)?,Có (Domain phụ thuộc vào Singleton global),Không (Domain chỉ phụ thuộc interface),DI đúng SOLID
Có hidden/global state không?,"Có (static property, global state)",Không,DI sạch
Dễ debug khi có bug?,Rất khó (ai gọi getInstance() ở đâu?),Rõ ràng (xem constructor),DI thắng
Có thể dùng nhiều instance với config khác nhau?,Không,Có (ví dụ: multi-tenant),DI linh hoạt
Được các framework lớn dùng?,"Không (Laravel, Symfony, Spring, NestJS đều cấm)",Có (100% dùng DI + Interface),DI là chuẩn thế giới
```

### Ngữ nghĩa quan trọng hơn code đơn giản

### Chấp nhận bỏ code cũ, Refactor liên tục

### Value Object hay ENUM
Tiêu chí,PHP Enum (bạn đang dùng),Value Object (cấp cao hơn),Ai đang dùng?
Type-safe,Yes,Yes,Cả hai đều tốt
IDE autocomplete,Yes,Yes,Cả hai đều tốt
Không gán được giá trị ngoài danh sách,Yes,Yes,Cả hai đều tốt
Có thể định nghĩa rule chuyển trạng thái?,Không (Enum thuần không có method),Yes canTransitionTo(),Value Object thắng tuyệt đối
Có thể validate logic nghiệp vụ bên trong?,Không,Yes (ví dụ: chỉ hủy được trong 24h),Value Object thắng tuyệt đối
Dễ mở rộng khi có 10+ trạng thái?,Khó,Yes Rất dễ (tập trung hết logic vào 1 chỗ),Value Object thắng
Được các team DDD lớn dùng?,Một số team Laravel mới,"100% team DDD cao cấp (Shopee, Tiki, v.v.)",Value Object là chuẩn


## Reconstruct Method

Đây là method dùng để đọc dữ liệu không hợp lệ lên, bỏ qua private của __construct.

Ứng dụng:
- Giữ private entity nhưng vẫn khởi tạo một entity mới từ database được
- Né Validate

![So sánh reconstruct.png](img/So%20s%C3%A1nh%20reconstruct.png)![img/img.png](img.png)


### Kỹ thuật cho Taxonomy Post Type

- Generic Collection PHP 8.2
- TypedID + Generic collection

## Sử dụng Value Object
- Đây là thành phần quan trọng, chịu trách nhiệm validate các các giá trị quan