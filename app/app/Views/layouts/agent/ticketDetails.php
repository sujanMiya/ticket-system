<h1 class=" mx-auto p-6 text-center">Support Ticket</h1>
<form id="ticketReplyFormDetails" class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md space-y-4 mt-1 ">
  <!-- Text Input -->
  <input type="hidden" id="csrf_token" name="csrf_token" value="<?= generateCsrfToken() ?>">
  <div id="messageContainer" class="hidden"></div>
  <input type="hidden" id="ticket_id" name="ticket_id" value="<?= $getTicket->id; ?>">
  <input type="hidden" id="user_id" name="user_id" value="<?= $getUser->id; ?>">
  <div>
    <p class="block text-sm font-medium text-gray-700">Subject</p>
    <p><?php echo htmlspecialchars($getTicket->subject); ?></p>
  </div>

  <div>
    <p class="block text-sm font-medium text-gray-700">Description</p>
    <p><?php echo htmlspecialchars($getTicket->description); ?></p>
  </div>

  <div>
    <p class="block text-sm font-medium text-gray-700">Reply</p>
    <p><?php foreach ($getReply as $getRep) { ?>
      <?php echo $getRep->message; ?>
   <?php } ?></p>
  </div>

  <div>
    <label for="description" class="block text-sm font-medium text-gray-700">Reply</label>
    <textarea
      id="message"
      name="message"
      rows="6"
      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
      placeholder="Write your message here"
    ></textarea>
  </div>

  <!-- Dropdown Select -->




  <!-- Submit Button -->
  <button
    type="submit"
    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700"
  >
    Submit
  </button>
</form>
<script>
    document.getElementById('ticketReplyFormDetails').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = e.target;
    const submitButton = form.querySelector('button[type="submit"]');
    const messageContainer = document.getElementById('messageContainer');
    
    submitButton.disabled = true;
    submitButton.innerHTML = 'Submitting...';
    
    try {
        const formData = {
            user_id: form.elements.user_id.value,
            message: form.elements.message.value,
            ticket_id: form.elements.ticket_id.value,
            csrf_token: form.elements.csrf_token.value
        };
        
        const response = await ApiClient.post('/ticket/reply', formData);
        if (!response.success) {
            throw new Error(response.message);
        }
        showMessage('Ticket reply successfully!', 'success');

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