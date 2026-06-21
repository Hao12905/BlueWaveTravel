(function () {
    const translations = {
        vi: {
            nav_home: 'TRANG CHỦ',
            nav_about: 'GIỚI THIỆU',
            nav_tours: 'TOUR',
            nav_contact: 'LIÊN HỆ',
            nav_profile: 'HỒ SƠ',
            login: 'Đăng nhập',
            register: 'Đăng ký',
            logout: 'Thoát',
            home_static: 'Trải nghiệm ',
            home_desc: 'Kiến tạo những hành trình độc bản, kết nối tâm hồn với đại dương xanh và tận hưởng đặc quyền tích lũy Travel Points.',
            home_safe_title: 'An Toàn Tuyệt Đối',
            home_safe_desc: 'Bảo hiểm du lịch cao cấp',
            home_points_desc: 'Tích điểm đổi quà hấp dẫn',
            home_support_title: 'Hỗ Trợ 24/7',
            home_support_desc: 'Luôn đồng hành cùng bạn',
            home_collection: 'SIGNATURE COLLECTION',
            home_featured: 'Hành Trình Nổi Bật',
            home_view_all: 'Xem tất cả tour',
            detail: 'Chi tiết',
            contact_button: 'Gửi Yêu Cầu Liên Hệ',
            profile_history: 'Lịch sử đặt tour của tôi',
            explore_tour: 'Khám phá Tour'
        },
        en: {
            nav_home: 'HOME',
            nav_about: 'ABOUT',
            nav_tours: 'TOURS',
            nav_contact: 'CONTACT',
            nav_profile: 'PROFILE',
            login: 'Login',
            register: 'Register',
            logout: 'Logout',
            home_static: 'Experience ',
            home_desc: 'Crafting unique journeys that connect your soul with the blue ocean and reward every trip with Travel Points.',
            home_safe_title: 'Total Safety',
            home_safe_desc: 'Premium travel insurance',
            home_points_desc: 'Earn points and redeem rewards',
            home_support_title: '24/7 Support',
            home_support_desc: 'Always by your side',
            home_collection: 'SIGNATURE COLLECTION',
            home_featured: 'Featured Journeys',
            home_view_all: 'View all tours',
            detail: 'Details',
            contact_button: 'Send Contact Request',
            profile_history: 'My Tour Booking History',
            explore_tour: 'Explore Tours'
        }
    };

    let currentLang = localStorage.getItem('lang') || 'vi';

    function t(key) {
        return translations[currentLang][key] || key;
    }

    function setText(selector, key) {
        const element = document.querySelector(selector);
        if (element) {
            element.textContent = t(key);
        }
    }

    function setAllText(selector, key) {
        document.querySelectorAll(selector).forEach((element) => {
            element.textContent = t(key);
        });
    }

    function setNavText(path, key) {
        document.querySelectorAll('.navbar .navbar-nav a[href]').forEach((element) => {
            try {
                const url = new URL(element.href, window.location.origin);
                if (url.pathname === path) {
                    element.textContent = t(key);
                }
            } catch (error) {
                // Ignore malformed links.
            }
        });
    }

    function applyTheme() {
        const enabled = localStorage.getItem('darkMode') === 'true';
        document.body.classList.toggle('dark-mode', enabled);

        const icon = document.getElementById('theme-icon');
        if (icon) {
            icon.className = enabled ? 'fas fa-sun' : 'fas fa-moon';
        }
    }

    function applyLanguage() {
        document.documentElement.lang = currentLang;

        const langText = document.getElementById('lang-text');
        if (langText) {
            langText.textContent = currentLang === 'vi' ? 'EN' : 'VI';
        }

        const brand = document.querySelector('.navbar-brand');
        if (brand) {
            brand.innerHTML = '<span class="text-primary">BLUE WAVE</span> TRAVEL';
        }

        setNavText('/', 'nav_home');
        setNavText('/gioi-thieu', 'nav_about');
        setNavText('/tours', 'nav_tours');
        setNavText('/lien-he', 'nav_contact');
        setNavText('/profile', 'nav_profile');
        setNavText('/login', 'login');
        setNavText('/register', 'register');
        setText('.navbar form[action*="/logout"] button', 'logout');

        setText('.static-txt', 'home_static');
        setText('.hero-desc', 'home_desc');
        setText('.stats-bar .col-md-4:nth-child(1) h6', 'home_safe_title');
        setText('.stats-bar .col-md-4:nth-child(1) small', 'home_safe_desc');
        setText('.stats-bar .col-md-4:nth-child(2) small', 'home_points_desc');
        setText('.stats-bar .col-md-4:nth-child(3) h6', 'home_support_title');
        setText('.stats-bar .col-md-4:nth-child(3) small', 'home_support_desc');
        setText('#featured .sub-title', 'home_collection');
        setText('#featured .main-title', 'home_featured');
        setText('#featured .view-all-link', 'home_view_all');
        setAllText('.tour-card a.btn', 'detail');

        setText('button.btn-gold-action', 'contact_button');
        setText('.profile-wrapper .col-lg-8 > h4', 'profile_history');
        setText('.empty-state a.btn', 'explore_tour');
    }

    window.toggleDarkMode = function () {
        const enabled = !document.body.classList.contains('dark-mode');
        localStorage.setItem('darkMode', enabled ? 'true' : 'false');
        applyTheme();
    };

    window.toggleLanguage = function () {
        currentLang = currentLang === 'vi' ? 'en' : 'vi';
        localStorage.setItem('lang', currentLang);
        applyLanguage();
    };

    document.addEventListener('DOMContentLoaded', function () {
        applyTheme();
        applyLanguage();
    });
})();
