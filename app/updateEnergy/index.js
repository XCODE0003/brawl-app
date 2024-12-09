import axios from 'axios';
import process from 'process';

process.on('uncaughtException', (err) => {
    console.error('Необработанная ошибка:', err);
});

process.on('SIGTERM', () => {
    console.log('Получен сигнал завершения, выключаюсь...');
    process.exit(0);
});

const updateEnergy = async () => {
    try {
        const response = await axios.get('https://brawlcoin.su/update/energy');
        console.log('update energy');
    } catch (error) {
        console.error('Ошибка при обновлении энергии:', error.message);
    }
};

setInterval(updateEnergy, 1000);

const updateCoins = async () => {
    const response = await axios.get(`https://brawlcoin.su/update/coins/1234567890abcdefghijklmnopqrstuvwxyz`);
    console.log('update coins');
};

setInterval(updateCoins, 60000);

console.log('Сервис обновления энергии запущен...');
