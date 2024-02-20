<script>
    $(document).ready(function(){
        // Show the popup
        $('#popup').fadeIn();

        // Hide the popup after 3 seconds
        setTimeout(function(){
            $('#popup').fadeOut();
        }, 5000);
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Wait for the DOM content to be fully loaded
        // Get the pop-up element
        var popup = document.getElementById("popup");
        // Display the pop-up
        popup.style.display = "block";
    });
</script>
