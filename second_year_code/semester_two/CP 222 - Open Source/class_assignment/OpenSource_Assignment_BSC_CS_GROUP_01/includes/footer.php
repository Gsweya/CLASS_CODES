<?php
// includes/footer.php
?>
    </div> </div> <script>
    // Script ya kuendesha Dark/Light mode kwenye kurasa zote za mfumo
    const bodyEl = document.body;
    
    // Angalia kama user alishachagua mode fulani mwanzo (Local Storage)
    if(localStorage.getItem('theme') === 'dark') {
        bodyEl.classList.remove('light-mode');
        bodyEl.classList.add('dark-mode');
    }

    // Tunaweza kuweka na logic zingine za JS hapa mbeleni
</script>
</body>
</html>