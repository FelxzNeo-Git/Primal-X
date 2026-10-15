// Pré-visualização da imagem + filtro de modalidades por elemento + validação rápida
(function () {
    var input = document.getElementById('imagem');
    var img = document.getElementById('preview');
    var txt = document.getElementById('upload-texto');
    var padrao = txt ? txt.textContent : '';

    if (input) {
        input.addEventListener('change', function () {
            var arq = this.files[0];
            if (!arq) { img.style.display = 'none'; txt.textContent = padrao; return; }
            img.src = URL.createObjectURL(arq);
            img.style.display = 'block';
            txt.textContent = '✔ ' + arq.name + ' (clique para trocar)';
        });
    }

    var select = document.getElementById('modalidade');
    if (select) {
        var opcoes = Array.prototype.slice.call(select.querySelectorAll('option[data-el]'));
        var filtrar = function () {
            var marcado = document.querySelector('input[name=tipo]:checked');
            var el = marcado ? marcado.value : '';
            var alvo = select.dataset.selecionada || select.value;
            select.innerHTML = '<option value="">' + (el ? 'Escolha a modalidade' : 'Escolha o tipo primeiro') + '</option>';
            opcoes.filter(function (o) { return o.dataset.el === el; }).forEach(function (o) {
                if (o.value === alvo) o.selected = true;
                select.appendChild(o);
            });
            select.dataset.selecionada = '';
        };
        document.querySelectorAll('input[name=tipo]').forEach(function (r) { r.addEventListener('change', filtrar); });
        filtrar();
    }

    var form = document.getElementById('form');
    if (form) {
        form.addEventListener('submit', function (ev) {
            var msg = null;
            if (!document.querySelector('input[name=tipo]:checked')) msg = 'Escolha um tipo: fogo, água, terra ou ar.';
            else if (!select.value) msg = 'Escolha uma modalidade.';
            else if (document.getElementById('nome').value.trim().length < 3) msg = 'Informe o nome do produto.';
            else if (!document.getElementById('valor').value.trim()) msg = 'Informe o valor.';
            else if (!input.files[0]) msg = 'Escolha uma imagem para o produto.';
            else if (input.files[0].size > 5 * 1024 * 1024) msg = 'A imagem deve ter no máximo 5 MB.';
            if (msg) { ev.preventDefault(); alert(msg); }
        });
    }
})();
