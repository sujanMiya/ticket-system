<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Micro Framework</title>
    <link rel="stylesheet" href="/assets/frontend/css/style.css">
    <script src="/assets/frontend/js/app.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6 text-center">Login Form</h1>
    <form id="loginForm" class="w-full max-w-sm mx-auto bg-white p-8 rounded-md shadow-md">
    <!-- Add CSRF token for security -->
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= generateCsrfToken() ?>">
    
    <div id="errorContainer" class="hidden mb-4 p-3 bg-red-100 text-red-700 rounded"></div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="email" id="email" name="email" placeholder="john@example.com" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="password" id="password" name="password" placeholder="********" required>
    </div>
    <button
        class="w-full bg-indigo-500 text-white text-sm font-bold py-2 px-4 rounded-md hover:bg-indigo-600 transition duration-300"
        type="submit">Login</button>
</form>

<script>
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = {
        email: this.email.value,
        password: this.password.value,
        csrf_token: this.csrf_token.value
    };

    try {
           const response = await ApiClient.post('/login', formData);
  
        if (response.success) {
            window.location.href = '/dashboard';
        } else {
            const errorContainer = document.getElementById('errorContainer');
            errorContainer.textContent = response.message;
            errorContainer.classList.remove('hidden');
        }
    } catch (error) {
        console.error('Error:', error);
    }
});
</script>
  </div>
</body>
</html>