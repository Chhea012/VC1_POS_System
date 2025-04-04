<?php
class NavbarKhmerController {
    public function switchLanguage($lang) {
        $availableLanguages = ['en', 'km'];

        if (in_array($lang, $availableLanguages)) {
            $_SESSION['lang'] = $lang;
        } else {
            $_SESSION['lang'] = 'en'; // Default to English if invalid lang
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
?>
