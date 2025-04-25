<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script>
setInterval(() => {
    fetch('../Controllers/verifica_sessao.php')
        .then(response => response.text())
        .then(data => {
            if (data.trim() === 'expirada') {
                alert('Sua sessão expirou. Você será redirecionado para o login.');
                window.location.href = '../index.php?erro=2';
            }
        })
        .catch(error => {
            console.error('Erro ao verificar sessão:', error);
        });
}, 60000); // Verifica a cada 1 minuto
</script>

</body>
</html>