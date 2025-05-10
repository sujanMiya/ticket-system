class ApiClient {
    static async get(url) {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        return response.json();
    }

    static async post(url, data) {
        // Get CSRF token from form or meta tag
        const csrfToken = document.getElementById('csrf_token').value;
        console.log('CSRF Token:', csrfToken);
        
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data),
            credentials: 'include'
        });
        return response.json();
    }
}