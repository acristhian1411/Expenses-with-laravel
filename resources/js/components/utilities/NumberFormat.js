export function formatNumber(value) {
    console.log(value);
    if (!value) return '';
    return value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

export function unformatNumber(value) {
    return value.replace(/\./g, '');
}

export default {
    formatNumber,
    unformatNumber
}