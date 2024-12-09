const formatNumber = (number) => {
    if (number >= 1000000) {
        return (number / 1000000).toFixed(1) + 'M';
    } else if (number >= 1000) {
        return (number / 1000).toFixed(1) + 'K';
    }
    return number.toString();
};

const declension = (number, wordForms) => {

    const lastDigit = number % 10;
    const lastTwoDigits = number % 100;

    if (lastTwoDigits > 10 && lastTwoDigits < 20) {
        return wordForms[2];
    }

    if (lastDigit === 1) {
        return wordForms[0];
    }
    if (lastDigit >= 2 && lastDigit <= 4) {
        return wordForms[1];
    }
    return number + ' ' + wordForms[2];
}

export { formatNumber, declension };
