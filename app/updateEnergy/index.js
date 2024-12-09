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
        const response = await axios.get('http://localhost:8000/update/energy');
        console.log('update energy');
    } catch (error) {
        console.error('Ошибка при обновлении энергии:', error.message);
    }
};

setInterval(updateEnergy, 1000);

console.log('Сервис обновления энергии запущен...');
