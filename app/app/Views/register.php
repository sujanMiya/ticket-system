<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Micro Framework - Register</title>
    <link rel="stylesheet" href="/assets/frontend/css/style.css">
    <script src="/assets/frontend/js/app.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6 text-center">Registration Form</h1>
    <form id="registerForm" class="w-full max-w-sm mx-auto bg-white p-8 rounded-md shadow-md">
      <div id="errorContainer" class="hidden mb-4 p-3 bg-red-100 text-red-700 rounded"></div>
      <div id="successContainer" class="hidden mb-4 p-3 bg-green-100 text-green-700 rounded"></div>
      
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="text" id="name" name="name" placeholder="John Doe" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="email" id="email" name="email" placeholder="john@example.com" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="password" id="password" name="password" placeholder="********" required minlength="8">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_password">Confirm Password</label>
        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="password" id="confirm_password" name="confirm_password" placeholder="********" required>
      </div>
      <input type="hidden" id="csrf_token" name="csrf_token" value="<?= generateCsrfToken() ?>">
      <button
        class="w-full bg-indigo-500 text-white text-sm font-bold py-2 px-4 rounded-md hover:bg-indigo-600 transition duration-300"
        type="submit">Register</button>
      <p class="flex justify-center mt-6 text-sm text-slate-600">
        Already have an account?
        <a href="/login" class="ml-1 text-sm font-semibold text-slate-700 underline">
          Login here
        </a>
      </p>
    </form>
  </div>

  <script>
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const form = e.target;
      const formData = {
        name: form.name.value,
        email: form.email.value,
        password: form.password.value,
        confirm_password: form.confirm_password.value
      };

      try {
        const response = await ApiClient.post('/register', formData);
        
        if (response.success) {
          document.getElementById('errorContainer').classList.add('hidden');
          document.getElementById('successContainer').textContent = response.message;
          document.getElementById('successContainer').classList.remove('hidden');
          
          // Redirect to login after 2 seconds
          setTimeout(() => {
            window.location.href = '/login';
          }, 2000);
        } else {
          throw new Error(response.message);
        }
      } catch (error) {
        document.getElementById('successContainer').classList.add('hidden');
        document.getElementById('errorContainer').textContent = error.message;
        document.getElementById('errorContainer').classList.remove('hidden');
      }
    });
  </script>
</body>
</html>