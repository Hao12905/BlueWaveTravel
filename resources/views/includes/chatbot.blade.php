<div id="bw-chat-wrapper" style="position: fixed; bottom: 30px; right: 30px; z-index: 2147483647; pointer-events: auto;">
    
    <button id="bw-chat-toggle" class="btn btn-primary shadow-lg d-flex align-items-center justify-content-center" 
        style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #00d2ff, #0084ff); border: none; transition: transform 0.3s ease; cursor: pointer;">
        <i class="fas fa-comments text-white fs-3" id="bw-chat-icon"></i>
    </button>

    <div id="bw-chat-box" class="card shadow-lg d-none" style="position: absolute; bottom: 80px; right: 0; width: 360px; height: 500px; border-radius: 16px; overflow: hidden; border: 1px solid rgba(0,0,0,0.1); flex-column: max-content;">
        
        <div class="card-header d-flex align-items-center justify-content-between text-white" style="background: linear-gradient(135deg, #00d2ff, #0084ff); padding: 15px;">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                    <i class="fas fa-robot text-primary"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold small">Blue Wave Assistant</h6>
                    <span class="text-white-50" style="font-size: 0.75rem;"><i class="fas fa-circle text-success me-1" style="font-size: 0.6rem;"></i>Trực tuyến</span>
                </div>
            </div>
            <button id="bw-chat-close" class="btn btn-link text-white p-0 shadow-none" style="text-decoration: none;">
                <i class="fas fa-times fs-5"></i>
            </button>
        </div>

        <div class="card-body" id="bw-chat-messages" style="height: calc(100% - 130px); overflow-y: auto; background-color: #f8f9fa; padding: 15px;">
            <div class="d-flex gap-2 mb-3">
                <div class="bg-secondary text-white rounded-3 p-2 small max-width-75" style="max-width: 80%;">
                    Xin chào! Blue Wave Travel có thể giúp gì cho hành trình du lịch của bạn hôm nay? 😊
                </div>
            </div>
        </div>

        <div class="card-footer bg-white border-top" style="padding: 10px 15px;">
            <form id="bw-chat-form" class="d-flex gap-2 mb-0">
                <input type="text" id="bw-chat-input" class="form-control form-control-sm border-0 bg-light shadow-none" placeholder="Nhập tin nhắn..." autocomplete="off" style="border-radius: 20px; padding: 8px 15px;">
                <button type="submit" class="btn btn-primary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #0084ff; border: none;">
                    <i class="fas fa-paper-plane text-white" style="font-size: 0.85rem;"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const chatToggle = document.getElementById('bw-chat-toggle');
    const chatBox = document.getElementById('bw-chat-box');
    const chatClose = document.getElementById('bw-chat-close');
    const chatForm = document.getElementById('bw-chat-form');
    const chatInput = document.getElementById('bw-chat-input');
    const chatMessages = document.getElementById('bw-chat-messages');
    const chatToggleStyle = document.getElementById('bw-chat-toggle');

    // 1. Hàm mở/đóng Chatbox
    function toggleChat() {
        if (chatBox.classList.contains('d-none')) {
            chatBox.classList.remove('d-none');
            chatBox.classList.add('d-flex');
            if (chatToggleStyle) chatToggleStyle.style.transform = 'scale(0)';
            chatInput.focus();
            scrollToBottom();
        } else {
            closeChat();
        }
    }

    function closeChat() {
        chatBox.classList.remove('d-flex');
        chatBox.classList.add('d-none');
        if (chatToggleStyle) chatToggleStyle.style.transform = 'scale(1)';
    }

    if (chatToggle) chatToggle.addEventListener('click', toggleChat);
    if (chatClose) chatClose.addEventListener('click', closeChat);

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // 2. HỆ THỐNG XỬ LÝ TRẢ LỜI THÔNG MINH (TOURS & COUPONS)
    // 2. HỆ THỐNG XỬ LÝ TRẢ LỜI THÔNG MINH CHI TIẾT THEO DATABASE THỰC TẾ
    function generateBotResponse(userMessage) {
        const msg = userMessage.toLowerCase().trim();

        // CHỨC NĂNG 1: MÃ GIẢM GIÁ / COUPONS
        if (msg.includes('mã') || msg.includes('giam gia') || msg.includes('giảm giá') || msg.includes('coupon') || msg.includes('khuyen mai') || msg.includes('khuyến mãi')) {
            return "🎟️ <b>MÃ GIẢM GIÁ HIỆN CÓ:</b><br><br>" +
                   "• <b>BW2026</b>: Giảm ngay 10% cho tất cả các tour du lịch.<br>" +
                   "• <b>HE2026</b>: Giảm 15% áp dụng riêng cho các tour thuộc danh mục Biển Đảo.<br><br>" +
                   "<i>Nhập mã tại bước điền thông tin Đặt Tour (Booking) để nhận ưu đãi nhé!</i>";
        }

        // CHỨC NĂNG 2: TÌM KIẾM CHI TIẾT TỪNG TOUR THEO TỪ KHÓA ĐỊA DANH
        
        // --- MIỀN BẮC ---
        if (msg.includes('sapa') || msg.includes('fansipan')) {
            return "🏔️ <b>Tour Sapa - Fansipan: Nóc nhà Đông Dương</b><br>" +
                   "• <b>Thời gian:</b> 3 Ngày<br>" +
                   "• <b>Điểm đến:</b> Khám phá bản Cát Cát, chinh phục đỉnh Fansipan bằng cáp treo...<br>" +
                   "• <b>Giá trọn gói:</b> 3,000,000đ";
        }
        if (msg.includes('ha noi') || msg.includes('hà nội') || msg.includes('phố phường')) {
            return "⛩️ <b>Tour Hà Nội - 36 Phố Phường</b><br>" +
                   "• <b>Thời gian:</b> 1 Ngày<br>" +
                   "• <b>Điểm đến:</b> Thăm Lăng Bác, Văn Miếu Quốc Tử Giám, thưởng thức ẩm thực thủ đô...<br>" +
                   "• <b>Giá trọn gói:</b> 1,200,000đ";
        }
        if (msg.includes('ha giang') || msg.includes('hà giang') || msg.includes('đồng văn')) {
            return "🌸 <b>Tour Hà Giang - Cao nguyên đá Đồng Văn</b><br>" +
                   "• <b>Thời gian:</b> 4 Ngày<br>" +
                   "• <b>Điểm đến:</b> Chinh phục đèo Mã Pí Lèng, thăm cột cờ Lũng Cú, bản Sủng Là...<br>" +
                   "• <b>Giá trọn gói:</b> 3,800,000đ";
        }
        if (msg.includes('ninh binh') || msg.includes('ninh bình') || msg.includes('tràng an')) {
            return "🛶 <b>Tour Ninh Bình - Tràng An - Bái Đính</b><br>" +
                   "• <b>Thời gian:</b> 1 Ngày<br>" +
                   "• <b>Điểm đến:</b> Du thuyền trên dòng sông Ngô Đồng, thăm quần thể di sản thế giới Tràng An, chùa Bái Đính...<br>" +
                   "• <b>Giá trọn gói:</b> 1,500,000đ";
        }
        if (msg.includes('mù cang chải') || msg.includes('mu cang chai') || msg.includes('ruộng bậc thang')) {
            return "🌾 <b>Tour Mù Cang Chải - Ruộng bậc thang vàng</b><br>" +
                   "• <b>Thời gian:</b> 2 Ngày<br>" +
                   "• <b>Điểm đến:</b> Ngắm nhìn những thửa ruộng bậc thang óng ả mùa lúa chín, đèo Khau Phạ...<br>" +
                   "• <b>Giá trọn gói:</b> 2,400,000đ";
        }

        // --- MIỀN TRUNG ---
        if (msg.includes('da nang') || msg.includes('đà nẵng') || msg.includes('bà nà') || msg.includes('ba na')) {
            return "🏰 <b>Tour Đà Nẵng - Bà Nà Hills - Cầu Vàng</b><br>" +
                   "• <b>Thời gian:</b> 3 Ngày<br>" +
                   "• <b>Điểm đến:</b> Check-in Cầu Vàng nổi tiếng thế giới, vui chơi tại Fantasy Park, tắm biển Mỹ Khê...<br>" +
                   "• <b>Giá trọn gói:</b> 4,200,000đ";
        }
        if (msg.includes('huế') || msg.includes('hue')) {
            return "👑 <b>Tour Cố Đô Huế - Vẻ đẹp trầm mặc</b><br>" +
                   "• <b>Thời gian:</b> 2 Ngày<br>" +
                   "• <b>Điểm đến:</b> Tham quan Đại Nội, các lăng tẩm vua triều Nguyễn, chùa Thiên Mụ...<br>" +
                   "• <b>Giá trọn gói:</b> 2,200,000đ";
        }
        if (msg.includes('hội an') || msg.includes('hoi an') || msg.includes('cù lao chàm') || msg.includes('cu lao cham')) {
            return "🏮 <b>Tour Phố cổ Hội An - Cù Lao Chàm</b><br>" +
                   "• <b>Thời gian:</b> 2 Ngày<br>" +
                   "• <b>Điểm đến:</b> Thăm chùa Cầu, nhà cổ Tấn Ký, đi thuyền ra đảo Cù Lao Chàm lặn ngắm san hô...<br>" +
                   "• <b>Giá trọn gói:</b> 1,800,000đ";
        }
        if (msg.includes('phong nha') || msg.includes('quảng bình') || msg.includes('quang binh')) {
            return "⛰️ <b>Tour Phong Nha - Động Thiên Đường</b><br>" +
                   "• <b>Thời gian:</b> 3 Ngày<br>" +
                   "• <b>Điểm đến:</b> Khám phá hệ thống hang động thạch nhũ kỳ ảo, hang Phong Nha hoành tráng...<br>" +
                   "• <b>Giá trọn gói:</b> 3,200,000đ";
        }
        if (msg.includes('quy nhơn') || msg.includes('quy nhon') || msg.includes('kỳ co') || msg.includes('eo gió')) {
            return "🌊 <b>Tour Quy Nhơn - Kỳ Co - Eo Gió</b><br>" +
                   "• <b>Thời gian:</b> 4 Ngày<br>" +
                   "• <b>Điểm đến:</b> Tận hưởng làn nước trong xanh tại đảo Kỳ Co, ngắm hoàng hôn tại Eo Gió...<br>" +
                   "• <b>Giá trọn gói:</b> 3,890,000đ";
        }

        // --- MIỀN NAM & TÂY NGUYÊN ---
        if (msg.includes('hồ chí minh') || msg.includes('tphcm') || msg.includes('sài gòn') || msg.includes('sai gon') || msg.includes('củ chi')) {
            return "🏙️ <b>Tour TP.HCM - Địa đạo Củ Chi</b><br>" +
                   "• <b>Thời gian:</b> 1 Ngày<br>" +
                   "• <b>Điểm đến:</b> Thăm Dinh Độc Lập, Nhà thờ Đức Bà, khám phá hệ thống địa đạo Củ Chi kiên cường...<br>" +
                   "• <b>Giá trọn gói:</b> 900,000đ";
        }
        if (msg.includes('cần thơ') || msg.includes('can tho') || msg.includes('cái răng')) {
            return "🌾 <b>Tour Cần Thơ - Chợ nổi Cái Răng</b><br>" +
                   "• <b>Thời gian:</b> 2 Ngày<br>" +
                   "• <b>Điểm đến:</b> Trải nghiệm nét văn hóa sông nước miệt vườn, đi ghe tham quan Chợ nổi Cái Răng...<br>" +
                   "• <b>Giá trọn gói:</b> 1,600,000đ";
        }
        if (msg.includes('đà lạt') || msg.includes('da lat') || msg.includes('tuyền lâm')) {
            return "🌲 <b>Tour Đà Lạt - Thành phố ngàn hoa</b><br>" +
                   "• <b>Thời gian:</b> 3 Ngày<br>" +
                   "• <b>Điểm đến:</b> Thăm thung lũng Tình Yêu, hồ Tuyền Lâm, check-in các vườn hoa rực rỡ...<br>" +
                   "• <b>Giá trọn gói:</b> 2,800,000đ";
        }
        if (msg.includes('tây ninh') || msg.includes('tay ninh') || msg.includes('bà đen')) {
            return "⛰️ <b>Tour Tây Ninh - Núi Bà Đen</b><br>" +
                   "• <b>Thời gian:</b> 1 Ngày<br>" +
                   "• <b>Điểm đến:</b> Chinh phục đỉnh núi cao nhất miền Nam bằng cáp treo tân tiến, viếng chùa Bà...<br>" +
                   "• <b>Giá trọn gói:</b> 1,100,000đ";
        }
        if (msg.includes('vũng tàu') || msg.includes('vung tau')) {
            return "🌊 <b>Tour Vũng Tàu - Biển xanh nắng vàng</b><br>" +
                   "• <b>Thời gian:</b> 2 Ngày<br>" +
                   "• <b>Điểm đến:</b> Nghỉ dưỡng bãi Sau, thăm tượng Chúa Kito giang tay, Bạch Dinh...<br>" +
                   "• <b>Giá trọn gói:</b> 1,300,000đ";
        }

        // --- DANH MỤC BIỂN ĐẢO ---
        if (msg.includes('phú quốc') || msg.includes('phu quoc')) {
            return "🏖️ <b>Tour Phú Quốc - Thiên đường Đảo Ngọc</b><br>" +
                   "• <b>Thời gian:</b> 4 Ngày<br>" +
                   "• <b>Điểm đến:</b> Vui chơi tại VinWonders, Grand World, lặn ngắm san hô đảo An Thới...<br>" +
                   "• <b>Giá trọn gói:</b> 5,200,000đ";
        }
        if (msg.includes('hạ long') || msg.includes('ha long') || msg.includes('du thuyền')) {
            return "🚢 <b>Tour Vịnh Hạ Long - Du thuyền 5 sao</b><br>" +
                   "• <b>Thời gian:</b> 2 Ngày<br>" +
                   "• <b>Điểm đến:</b> Ngủ đêm trên vịnh sang trọng, chèo thuyền Kayak, thăm hang Sửng Sốt...<br>" +
                   "• <b>Giá trọn gói:</b> 3,600,000đ";
        }
        if (msg.includes('lý sơn') || msg.includes('ly son')) {
            return "🌋 <b>Tour Đảo Lý Sơn - Vương quốc tỏi</b><br>" +
                   "• <b>Thời gian:</b> 3 Ngày<br>" +
                   "• <b>Điểm đến:</b> Thăm cổng Tò Vò, đỉnh Thới Lới, tìm hiểu quy trình trồng tỏi núi lửa độc đáo...<br>" +
                   "• <b>Giá trọn gói:</b> 3,400,000đ";
        }
        if (msg.includes('côn đảo') || msg.includes('con dao')) {
            return "🕊️ <b>Tour Côn Đảo - Tâm linh & Nghỉ dưỡng</b><br>" +
                    "• <b>Thời gian:</b> 3 Ngày<br>" +
                    "• <b>Điểm đến:</b> Viếng mộ chị Võ Thị Sáu, tham quan hệ thống nhà tù lịch sử, tắm biển bãi Đầm Trầu...<br>" +
                    "• <b>Giá trọn gói:</b> 4,500,000đ";
        }

        // CHỨC NĂNG 3: TRẢ LỜI DANH MỤC LỚN (Khi khách hỏi chung theo vùng miền)
        if (msg.includes('miền bắc') || msg.includes('mien bac')) {
            return "🏔️ <b>Các Tour thuộc danh mục Miền Bắc:</b><br>" +
                   "1. Sapa - Fansipan (3 Ngày)<br>" +
                   "2. Hà Nội - 36 Phố Phường (1 Ngày)<br>" +
                   "3. Hà Giang - Cao nguyên đá Đồng Văn (4 Ngày)<br>" +
                   "4. Ninh Bình - Tràng An (1 Ngày)<br>" +
                   "5. Mù Cang Chải (2 Ngày)<br><br>" +
                   "<i>Gõ tên tỉnh thành (Ví dụ: 'Sapa') để xem lịch trình chi tiết!</i>";
        }
        if (msg.includes('miền trung') || msg.includes('mien trung')) {
            return "🏰 <b>Các Tour thuộc danh mục Miền Trung:</b><br>" +
                   "1. Đà Nẵng - Bà Nà Hills (3 Ngày)<br>" +
                   "2. Cố Đô Huế (2 Ngày)<br>" +
                   "3. Hội An - Cù Lao Chàm (2 Ngày)<br>" +
                   "4. Phong Nha - Động Thiên Đường (3 Ngày)<br>" +
                   "5. Quy Nhơn - Kỳ Co Eo Gió (4 Ngày)<br><br>" +
                   "<i>Gõ tên tỉnh thành (Ví dụ: 'Đà Nẵng') để xem lịch trình chi tiết!</i>";
        }
        if (msg.includes('miền nam') || msg.includes('mien nam') || msg.includes('miền tây') || msg.includes('mien tay')) {
            return "🏙️ <b>Các Tour thuộc danh mục Miền Nam:</b><br>" +
                   "1. TP.HCM - Địa đạo Củ Chi (1 Ngày)<br>" +
                   "2. Cần Thơ - Chợ nổi Cái Răng (2 Ngày)<br>" +
                   "3. Đà Lạt - Thành phố ngàn hoa (3 Ngày)<br>" +
                   "4. Tây Ninh - Núi Bà Đen (1 Ngày)<br>" +
                   "5. Vũng Tàu - Biển xanh nắng vàng (2 Ngày)<br><br>" +
                   "<i>Gõ tên tỉnh thành (Ví dụ: 'Đà Lạt') để xem lịch trình chi tiết!</i>";
        }
        if (msg.includes('biển đảo') || msg.includes('bien dao') || msg.includes('biển') || msg.includes('bien')) {
            return "🏖️ <b>Các Tour thuộc danh mục Biển Đảo đặc sắc:</b><br>" +
                   "1. Phú Quốc - Thiên đường Đảo Ngọc (4 Ngày)<br>" +
                   "2. Vịnh Hạ Long - Du thuyền 5 sao (2 Ngày)<br>" +
                   "3. Đảo Lý Sơn - Vương quốc tỏi (3 Ngày)<br>" +
                   "4. Côn Đảo - Tâm linh & Nghỉ dưỡng (3 Ngày)<br><br>" +
                   "<i>Gõ tên đảo (Ví dụ: 'Phú Quốc') để xem lịch trình chi tiết!</i>";
        }

        // CÂU HỎI CHUNG VỀ TOUR
        if (msg.includes('tour') || msg.includes('du lich') || msg.includes('du lịch')) {
            return "✈️ <b>Blue Wave Travel đang cung cấp 4 danh mục tuyến tour lớn:</b><br>" +
                   "• 🌲 <b>Miền Bắc</b> (Sapa, Hà Giang, Hà Nội, Ninh Bình...)<br>" +
                   "• 🏰 <b>Miền Trung</b> (Đà Nẵng, Huế, Hội An, Quy Nhơn...)<br>" +
                   "• 🏙️ <b>Miền Nam</b> (Đà Lạt, Cần Thơ, Vũng Tàu, Tây Ninh...)<br>" +
                   "• 🏖️ <b>Biển Đảo</b> (Phú Quốc, Hạ Long, Lý Sơn, Côn Đảo...)<br><br>" +
                   "Bạn hãy gõ vùng miền hoặc địa điểm cụ thể để mình cung cấp thông tin nhé!";
        }

        // PHẢN HỒI MẶC ĐỊNH
        return "Chào bạn, mình là trợ lý Blue Wave! Bạn cần tư vấn thông tin chi tiết về <b>Mã giảm giá</b> hoặc <b>Tour du lịch cụ thể nào</b> (ví dụ: Hà Giang, Phú Quốc, Sapa...)? Hãy gõ để mình hỗ trợ ngay nhé! 😊";
    }

    // 3. Xử lý gửi tin nhắn từ Form
    if (chatForm) {
        chatForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const messageText = chatInput.value.trim();
            if (!messageText) return;

            // Render tin nhắn của Người dùng
            appendMessage(messageText, 'user');
            chatInput.value = '';

            // Tạo hiệu ứng "Đang nhập..." giả lập cho Bot để mang lại cảm giác chân thật
            const typingId = appendTypingIndicator();

            setTimeout(() => {
                // Xóa hiệu ứng đang nhập đi
                removeTypingIndicator(typingId);

                // Lấy câu trả lời tương ứng dựa trên bộ lọc từ khóa
                const botReply = generateBotResponse(messageText);
                
                // Render câu trả lời của Bot
                appendMessage(botReply, 'bot');
            }, 800); // Trả lời nhanh sau 0.8 giây
        });
    }

    // 4. Hàm chèn mẫu HTML tin nhắn
    function appendMessage(text, sender) {
        const messageWrapper = document.createElement('div');
        messageWrapper.className = `d-flex gap-2 mb-3 ${sender === 'user' ? 'justify-content-end' : ''}`;
        
        const messageContent = document.createElement('div');
        if (sender === 'user') {
            messageContent.className = 'bg-primary text-white rounded-3 p-2 small';
            messageContent.style.backgroundColor = '#0084ff';
            messageContent.innerText = text; // Tin nhắn user chỉ hiển thị text thô
        } else {
            messageContent.className = 'bg-secondary text-white rounded-3 p-2 small';
            messageContent.style.backgroundColor = '#6c757d';
            // Sử dụng innerHTML để cho phép hiển thị các thẻ định dạng chữ đậm <b>, xuống dòng <br> hoặc icon
            messageContent.innerHTML = text.replace(/\n/g, '<br>'); 
        }
        messageContent.style.maxWidth = '80%';

        messageWrapper.appendChild(messageContent);
        chatMessages.appendChild(messageWrapper);
        scrollToBottom();
    }

    // 5. Hàm tạo hiệu ứng chấm chấm "Đang nhập..."
    function appendTypingIndicator() {
        const id = 'typing-' + Date.now();
        const wrapper = document.createElement('div');
        wrapper.className = 'd-flex gap-2 mb-3';
        wrapper.id = id;

        const content = document.createElement('div');
        content.className = 'bg-secondary text-white rounded-3 p-2 small';
        content.style.backgroundColor = '#e9ecef';
        content.style.color = '#6c757d';
        content.innerHTML = '<span class="spinner-grow spinner-grow-sm" role="status" style="width: 0.5rem; height: 0.5rem;"></span> Đang xử lý...';

        wrapper.appendChild(content);
        chatMessages.appendChild(wrapper);
        scrollToBottom();
        return id;
    }

    function removeTypingIndicator(id) {
        const element = document.getElementById(id);
        if (element) element.remove();
    }
});
</script>