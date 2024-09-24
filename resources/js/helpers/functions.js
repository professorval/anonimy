const format_date = (date) => {
    return new Date(date).toLocaleDateString() + ' at ' + new Date(date).toLocaleTimeString()
}

const log_text = (text) => {
    console.log('LOG: ', text);
}

export default {
    format_date,
    log_text
};