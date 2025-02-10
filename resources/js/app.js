import './bootstrap';
window.Echo.channel('posts')
    .listen('PostCreated', (e) => {
        console.log('Post created:', e.post);
    });
