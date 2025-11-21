document.addEventListener('DOMContentLoaded', () => {
    const apiUrl = tourSearch.apiUrl;
    let currentPage = 1;

    const elements = {
        type: document.getElementById('tour-type'),
        location: document.getElementById('tour-location'),
        person: document.getElementById('tour-person'),
        keyword: document.getElementById('tour-keyword'),
        loading: document.getElementById('tour-loading'),
        results: document.getElementById('tour-results'),
        pagination: document.getElementById('tour-pagination')
    };

    let debounceTimer;

    const search = (page = 1) => {
        currentPage = page;
        const params = new URLSearchParams({
            page: page,
            per_page: 10
        });

        if (elements.type.value.trim()) params.append('type', elements.type.value.trim());
        if (elements.location.value.trim()) params.append('location', elements.location.value.trim());
        if (elements.person.value) params.append('person', elements.person.value);
        if (elements.keyword.value.trim()) params.append('keyword', elements.keyword.value.trim());

        elements.loading.style.display = 'block';
        elements.results.innerHTML = '';
        elements.pagination.innerHTML = '';

        fetch(`${apiUrl}?${params}`, {
            headers: { 'X-WP-Nonce': tourSearch.nonce }
        })
            .then(r => r.json())
            .then(data => {
                elements.loading.style.display = 'none';

                if (!data.success || !data.data.length) {
                    elements.results.innerHTML = '<p style="text-align:center; color:#999;">Không tìm thấy tour nào.</p>';
                    return;
                }

                data.data.forEach(tour => {
                    const item = document.createElement('div');
                    item.className = 'tour-item';
                    item.innerHTML = `
                    ${tour.thumbnail ? `<img src="${tour.thumbnail}" alt="${tour.name}" />` : ''}
                    <div class="tour-content">
                        <h3 class="tour-name">${tour.name}</h3>
                        <div class="tour-meta">
                            <strong>Mã:</strong> ${tour.tour_code} | 
                            <strong>Thời gian:</strong> ${tour.tour_duration_days} ngày ${tour.tour_duration_nights || ''} đêm
                        </div>
                        <p class="tour-desc">${tour.description}</p>
                        <div class="tour-meta">
                            <strong>Loại:</strong> ${(Array.isArray(tour.tour_type) ? tour.tour_type : [tour.tour_type]).filter(Boolean).join(', ')} | 
                            <strong>Địa điểm:</strong> ${(Array.isArray(tour.tour_location) ? tour.tour_location : [tour.tour_location]).filter(Boolean).join(', ')}
                        </div>
                        <a href="${tour.link}" class="tour-link" target="_blank">Xem chi tiết →</a>
                    </div>
                `;
                    elements.results.appendChild(item);
                });

                // Phân trang
                const pag = data.pagination;
                if (pag.total_pages > 1) {
                    for (let i = 1; i <= pag.total_pages; i++) {
                        const btn = document.createElement('button');
                        btn.textContent = i;
                        btn.className = i === pag.current_page ? 'active' : '';
                        btn.onclick = () => search(i);
                        elements.pagination.appendChild(btn);
                    }
                }
            })
            .catch(err => {
                elements.loading.style.display = 'none';
                elements.results.innerHTML = '<p style="color:red;">Lỗi kết nối. Vui lòng thử lại.</p>';
                console.error(err);
            });
    };

    // Gắn sự kiện input + debounce 500ms
    [elements.type, elements.location, elements.person, elements.keyword].forEach(el => {
        el.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => search(1), 500);
        });
    });

    // Tìm lần đầu
    search();
});