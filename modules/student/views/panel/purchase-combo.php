<?php
if(isset($error)){
    echo alert('Link Expired.','danger');
}
else{
?>
<div id="countdown">Loading...</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        let targetDate = new Date("<?= $this->token->expiredOn('js'); ?>");
        console.log(targetDate)
        function updateClock() {
            let now = new Date();
            let timeRemaining = targetDate - now; // Time difference in milliseconds

            if (timeRemaining <= 0) {
                // Time is up, reload the page
                location.reload();
            } else {
                // Calculate days, hours, minutes, and seconds
                let days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                    let hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    let minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                    let seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                    // Build the countdown string dynamically
                    let countdownString = "";

                    if (days > 0) {
                        countdownString += `${days}d `;
                    }
                    if (hours > 0 || days > 0) { // Show hours if days > 0, even if hours are 0
                        countdownString += `${hours}h `;
                    }
                    if (minutes > 0 || hours > 0 || days > 0) { // Show minutes if higher units exist
                        countdownString += `${minutes}m `;
                    }
                    countdownString += `${seconds}s`; // Always show seconds

                    // Display countdown
                    $('#countdown').text(countdownString);
            }
        }
        setInterval(updateClock, 1000);

        // Run immediately to avoid 1-second delay
        updateClock();
    })
</script>

<?php
}
?>