<select class="btn-bar" id="language-switcher" onchange="changeLanguage()">
    <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>Français</option>
    <option value="ar" {{ app()->getLocale() == 'ar' ? 'selected' : '' }}>Arabe</option>
</select>

<script>
    function changeLanguage() {
        var locale = document.getElementById('language-switcher').value;
        window.location.href = '/locale/' + locale;
    }
</script>