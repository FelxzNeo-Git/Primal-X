// Barra de progresso de rolagem no topo das páginas de elemento/modalidade
(function () {
    var barra = document.getElementById('progresso');
    if (!barra) return;
    function atualizar() {
        var total = document.documentElement.scrollHeight - window.innerHeight;
        barra.style.width = (total > 0 ? (window.scrollY / total) * 100 : 0) + '%';
    }
    window.addEventListener('scroll', atualizar, { passive: true });
    atualizar();
})();
