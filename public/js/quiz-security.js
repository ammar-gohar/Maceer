document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'hidden') {
            alert("Tab switching is not allowed. Your quiz will now be submitted.");
            this.call('submit');
        }
});