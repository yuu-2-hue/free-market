document.querySelector('#comment-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const url = e.target.dataset.url;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const form = e.target;
    const formData = new FormData(form);
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        });
        const data = await response.json();
        if (response.ok) {
            const userHtml = `
            <div class="user-comment__info">
                <img src="/storage/${data.comment.profile.image}" alt="アイコン">
                <p>${data.comment.profile.name}</p>
            </div>`;
            document.getElementById('comment-list').insertAdjacentHTML('beforeend', userHtml);
            const commentHtml = `<p class="user-comment">${data.comment.comment}</p>`;
            document.getElementById('comment-list').insertAdjacentHTML('beforeend', commentHtml);
            form.reset();
        } else {
            alert('コメント投稿に失敗しました。');
        }
    } catch (error) {
        console.error(error);
        alert('通信エラーが発生しました。');
    }
});