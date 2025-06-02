document.addEventListener('DOMContentLoaded', () => {
    const favoriteButton = document.querySelector('#favorite-button');
    const favoriteImage = document.querySelector('#favorite-img');
    const favoriteCount = document.querySelector('#favorite-count');

    favoriteButton.addEventListener('click', async () => {
        favoriteImage.classList.toggle('is-active');
        const url = favoriteButton.dataset.url;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({})
            });

            const result = await response.json();

            if (result.favorited) {
                favoriteImage.classList.add('is-active');
            } else {
                favoriteImage.classList.remove('is-active');
            }

            favoriteCount.textContent = result.count;

        } catch (error) {
            console.error('通信エラー', error);
        }
    });
});