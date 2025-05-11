<h1 class=" mx-auto p-6 text-center">Support Ticket</h1>
<form id="ticketFormDetails" class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md space-y-4 mt-1 ">
  <!-- Text Input -->
  <input type="hidden" id="csrf_token" name="csrf_token" value="<?= generateCsrfToken() ?>">
  <div id="messageContainer" class="hidden"></div>
  <input type="hidden" id="ticket_id" name="ticket_id" value="<?= $getTicket->id; ?>">
  <div>
    <p class="block text-sm font-medium text-gray-700">Subject</p>
    <p><?php echo htmlspecialchars($getTicket->subject); ?></p>
  </div>

  <div>
    <p class="block text-sm font-medium text-gray-700">Description</p>
    <p><?php echo htmlspecialchars($getTicket->description); ?></p>
  </div>

  <!-- Dropdown Select -->
  <div>
    <label for="assignment" class="block text-sm font-medium text-gray-700">Assigned Agent</label>
    <select
      id="assignment"
      name="assignment"
      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
    >
      <option value="">Please choose</option>
      <?php foreach ($agentUsers as $agentUser) { ?>
        <option value="<?php echo htmlspecialchars($agentUser->id); ?>"><?php echo htmlspecialchars($agentUser->name); ?></option>
 <?php     }?>
    </select>
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
    document.getElementById('ticketFormDetails').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = e.target;
    const submitButton = form.querySelector('button[type="submit"]');
    const messageContainer = document.getElementById('messageContainer');
    
    submitButton.disabled = true;
    submitButton.innerHTML = 'Submitting...';
    
    try {
        const formData = {
            assignment: form.elements.assignment.value,
            ticket_id: form.elements.ticket_id.value,
            csrf_token: form.elements.csrf_token.value
        };
        
        const response = await ApiClient.post('/ticket/assign', formData);
        if (!response.success) {
            throw new Error(response.message);
        }
        showMessage('Ticket updated successfully!', 'success');

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