<?php
require_once 'motivations.php';
$minute = intval(date('i'));
$index = $minute % count($motivations);
$motivation_message = htmlspecialchars($motivations[$index]);
?>
<p class="mb-4" id="motivation-message">
  <?php echo htmlspecialchars($motivation_message); ?>
</p>
<script>    
function updateMotivation() {
  fetch('motivation_api.php')
    .then(response => response.text())
    .then(text => {
      document.getElementById('motivation-message').innerText = text;
    });
}
updateMotivation(); // зареди веднага при отваряне
setInterval(updateMotivation, 60000); // всяка минута
</script>