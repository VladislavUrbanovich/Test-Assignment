import './bootstrap';

const button = document.getElementById('user_import');
const summary = document.getElementById('count_summary');

button.addEventListener('click', (e) => {
    e.preventDefault();

    axios.get('/api/user/import')
        .then(response => {
            const data = response.data;
            for (const key in data) {
                const element = document.getElementById(key);
                element.textContent = data[key];
            }
        })
        .catch(error => {
            console.log(error.message);
        })
        .finally(() => {
            summary.classList.remove('hidden');
        });
});
