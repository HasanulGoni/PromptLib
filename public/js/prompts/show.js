// Send To AI
const sendToAIForm = document.getElementById('sendToAIForm');
const sendToAIBtn = document.getElementById('sendToAIBtn');

sendToAIBtn.addEventListener('click', function() {
  sendToAIForm.submit();
});

// Copy Prompt
const textarea = document.getElementById('custom_prompt');
const copyButton = document.getElementById('copyButton');

copyButton.addEventListener('click', function() {
  textarea.select();
  textarea.setSelectionRange(0, textarea.value.length); // For mobile devices
  navigator.clipboard.writeText(textarea.value)
    .then(() => {
      console.log('Text copied to clipboard');
      // Optional: Provide visual feedback to the user
      copyButton.textContent = "Copied!";
      setTimeout(()=> {copyButton.textContent = "Copy"}, 2000); //revert to original text after 2 seconds.
    })
    .catch(err => {
      console.error('Could not copy text: ', err);
      // Optional: Provide error feedback to the user
      copyButton.textContent = "Copy Failed";
      setTimeout(()=> {copyButton.textContent = "Copy"}, 2000);
    });
});