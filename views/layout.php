<?php require_once('layouts/header.php'); ?>
<?php require_once('layouts/navbar.php'); ?>
<?php require_once("layouts/sidebar.php"); ?>

<?= $content; ?>

<?php require_once('layouts/footer.php'); ?>

<!-- Include Translation File -->
<?php require_once('layouts/translate.php'); ?>

<!-- Translation Logic -->
<script>
    // Apply translations to all elements with data-i18n attribute
    function applyTranslations(lang) {
        document.querySelectorAll('[data-i18n]').forEach(element => {
            const key = element.getAttribute('data-i18n');
            if (translations[lang] && translations[lang][key]) {
                let text = translations[lang][key];
                // Handle dynamic placeholders like %ORDER_INCREASE%
                if (key === 'welcome_message') {
                    const orderIncrease = element.querySelector('.fw-bold.text-success')?.textContent.match(/\d+/)?.[0] || '0';
                    text = text.replace('%ORDER_INCREASE%', orderIncrease + '%');
                }
                element.innerHTML = text;
            }
        });
    }

    // Update font family based on language
    function updateFontFamily(lang) {
        document.documentElement.style.fontFamily = lang === 'km' ? "'Noto Sans Khmer', sans-serif" : "'Public Sans', sans-serif";
    }

    // Change language and update UI
    function changeLanguage(lang) {
        localStorage.setItem('selectedLanguage', lang);
        document.documentElement.lang = lang;
        applyTranslations(lang);
        updateLanguageDropdown(lang);
        updateFontFamily(lang);
    }

    // Update language dropdown display
    function updateLanguageDropdown(lang) {
        const languageDropdown = document.getElementById('languageDropdown');
        const dropdownMenu = document.getElementById('languageDropdownMenu');

        const languages = {
            en: {
                name: "English",
                flag: "/views/assets/modules/img/country/english.png",
                oppositeLang: "km",
                oppositeName: "Khmer",
                oppositeFlag: "/views/assets/modules/img/country/cambodia.png"
            },
            km: {
                name: "ខ្មែរ",
                flag: "/views/assets/modules/img/country/cambodia.png",
                oppositeLang: "en",
                oppositeName: "អង់គ្លេស",
                oppositeFlag: "/views/assets/modules/img/country/english.png"
            }

        };

        if (languageDropdown && dropdownMenu) {
            languageDropdown.innerHTML = `
            <img src="${languages[lang].flag}" alt="${languages[lang].name}" class="flag-icon"> ${languages[lang].name}
        `;
            dropdownMenu.innerHTML = `
            <li><a class="dropdown-item" href="#" onclick="changeLanguage('${languages[lang].oppositeLang}'); return false;">
                <img src="${languages[lang].oppositeFlag}" alt="${languages[lang].oppositeName}" class="flag-icon"> ${languages[lang].oppositeName}
            </a></li>
        `;
        }
    }

    // Initialize on page load
    document.addEventListener("DOMContentLoaded", function() {
        const selectedLanguage = localStorage.getItem('selectedLanguage') || 'en';
        changeLanguage(selectedLanguage);

        // Set active menu item (for sidebar)
        const currentUrl = window.location.pathname;
        document.querySelectorAll(".menu-item a").forEach(item => {
            if (item.getAttribute("href") === currentUrl) {
                item.classList.add("active");
            }
        });

        // Assuming updateNotificationBadge() is defined elsewhere
        if (typeof updateNotificationBadge === 'function') {
            updateNotificationBadge();
        }
    });
</script>