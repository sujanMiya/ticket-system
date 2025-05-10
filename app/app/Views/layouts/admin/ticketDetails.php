<h1 class=" mx-auto p-6 text-center">Support Ticket</h1>
<form id="ticketForm" class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md space-y-4 mt-1 ">
  <!-- Text Input -->
  <input type="hidden" id="csrf_token" name="csrf_token" value="<?= generateCsrfToken() ?>">
  <div id="messageContainer" class="hidden"></div>
  <div>
    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
    <input
      type="text"
      id="subject"
      name="subject"
      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
      placeholder="Enter your Subject"
      required
    />
  </div>

  <!-- Dropdown Select -->
  <div>
    <label for="priority" class="block text-sm font-medium text-gray-700">Select an priority</label>
    <select
      id="priority"
      name="priority"
      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
    >
      <option value="">Please choose</option>
      <option value="high">High</option>
      <option value="medium">Medium</option>
      <option value="low">Low</option>
    </select>
  </div>
  <div>
    <label for="department" class="block text-sm font-medium text-gray-700">Select an Department</label>
    <select
      id="department"
      name="department"
      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
    >
      <option value="">Please choose</option>
      <?php foreach ($getDepartments as $department) { ?>
        <option value="<?php echo htmlspecialchars($department->id); ?>"><?php echo htmlspecialchars($department->name); ?></option>
    <?php  }?>
    </select>
  </div>

  <!-- Textarea -->
  <div>
    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
    <textarea
      id="description"
      name="description"
      rows="6"
      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
      placeholder="Write your message here"
    ></textarea>
  </div>

  <!-- Submit Button -->
  <button
    type="submit"
    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700"
  >
    Submit
  </button>
</form>
<script>
    document.getElementById('ticketForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = e.target;
    const submitButton = form.querySelector('button[type="submit"]');
    const messageContainer = document.getElementById('messageContainer');
    
    submitButton.disabled = true;
    submitButton.innerHTML = 'Submitting...';
    
    try {
        const formData = {
            subject: form.elements.subject.value,
            priority: form.elements.priority.value,
            department: form.elements.department.value,
            description: form.elements.description.value,
            csrf_token: form.elements.csrf_token.value
        };
        
        const response = await ApiClient.post('/ticket', formData);
        if (!response.success) {
            throw new Error(response.message);
        }
        showMessage('Ticket submitted successfully!', 'success');

        form.reset();
        
    } catch (error) {
        console.error('Error:', error);
        const errorMsg = error.message || 'Failed to submit ticket. Please try again.';
        showMessage(errorMsg, 'error');
        
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = 'Submit';
    }
});

function showMessage(message, type) {
    const messageContainer = document.getElementById('messageContainer');
    messageContainer.classList.remove('hidden');
    messageContainer.innerHTML = `
        <div class="p-4 mb-4 rounded ${type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
            ${message}
        </div>
    `;
    
    setTimeout(() => {
        messageContainer.classList.add('hidden');
    }, 3000);
}
</script>