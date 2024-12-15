<script>
const tg = window.Telegram.WebApp;
tg.ready();
const userinfo = tg.initDataUnsafe.user;
if (userinfo) {
    window.location.href = '/generate/token/' + userinfo.id;



}
</script>