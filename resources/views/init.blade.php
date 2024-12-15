<script src="https://telegram.org/js/telegram-web-app.js?56"></script>

<script>
    const tg = window.Telegram.WebApp;
    tg.ready();
    const userinfo = tg.initDataUnsafe.user;
    if (userinfo) {
        window.location.href = '/generate/token/' + userinfo.id;
    } else {
        window.Telegram.WebApp.close();
    }
</script>