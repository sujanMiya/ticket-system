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
        const csrfToken = data.csrf_token || document.querySelector('meta[name="csrf-token"]').content;
        
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        });
        return response.json();
    }
}