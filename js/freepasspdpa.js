document.addEventListener('DOMContentLoaded', function() {
    if (!localStorage.getItem('freepasspdpa_consent')) {
        // Показываем баннер согласия
        var consentBanner = document.createElement('div');
        consentBanner.id = 'freepasspdpa-banner';
        consentBanner.innerHTML = `
            <div class="freepasspdpa-content">
                <p>${freepasspdpa_settings.message} <a href="${freepasspdpa_settings.privacy_url}">${freepasspdpa_settings.privacy_text}</a>.</p>
                <button id="freepasspdpa-accept">${freepasspdpa_settings.accept_text}</button>
                <button id="freepasspdpa-decline">${freepasspdpa_settings.decline_text}</button>
            </div>
        `;
        document.body.appendChild(consentBanner);

        // Обработчики событий для кнопок
        document.getElementById('freepasspdpa-accept').addEventListener('click', function() {
            localStorage.setItem('freepasspdpa_consent', 'accepted');
            document.getElementById('freepasspdpa-banner').style.display = 'none';
        });

        document.getElementById('freepasspdpa-decline').addEventListener('click', function() {
            localStorage.setItem('freepasspdpa_consent', 'declined');
            document.getElementById('freepasspdpa-banner').style.display = 'none';
        });
    } else {
        // Если пользователь уже дал согласие или отказался, баннер не отображается
        var banner = document.getElementById('freepasspdpa-banner');
        if (banner) {
            banner.style.display = 'none';
        }
    }
});
