export function formatNumber(value) {
    if (!value) return '';
    let num = value.toString();
    return num.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

export function unformatNumber(value) {
    return value.replace(/\./g, '');
}

export default {
    formatNumber,
    unformatNumber
}