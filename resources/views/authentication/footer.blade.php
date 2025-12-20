</div>


<style>
    .modal-body {
    max-height: 60vh;
    overflow-y: auto;
    line-height: 1.6;
    font-size: 14px;
}

/* Disabled submit button style */
button[disabled] {
    opacity: 0.5;
    cursor: not-allowed;
    background-color: #6c757d !important; /* muted gray */
    border-color: #6c757d !important;
}

/* Smooth transition */
button {
    transition: all 0.3s ease;
}

</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const agreeCheckbox = document.getElementById('agree');
    const submitBtn = document.getElementById('submitBtn');

    if (agreeCheckbox && submitBtn) {
        submitBtn.disabled = !agreeCheckbox.checked;

        agreeCheckbox.addEventListener('change', function () {
            submitBtn.disabled = !this.checked;
        });
    }

});
</script>
</body>
</html>
