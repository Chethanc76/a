<div class="footer text-center py-3">
     <p>&copy; <span id="currentYear"></span> All rights reserved. Blockchain In Agriculture
.
</div>
  
<script>
    document.getElementById('currentYear').textContent = new Date().getFullYear();
</script>
<style>
    .footer {
    background-color:rgb(25, 25, 44);
    color: white;
    width: 100%;
    bottom: 0;
    left: 0;
    
    margin-top: 50px;
}
#currentYear {
    font-weight: bold;
}
</style>