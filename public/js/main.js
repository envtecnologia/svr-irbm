function updateClock() {
    var now = new Date();
    var daysOfWeek = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
    var months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

    var dayOfWeek = daysOfWeek[now.getDay()];
    var dayOfMonth = now.getDate();
    var month = months[now.getMonth()];
    var year = now.getFullYear();

    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();

    // Adicione um zero à esquerda para minutos e segundos menores que 10
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;

    var icon = '<i class="fa-solid fa-calendar fa-sm me-1"></i>';
    var timeString = dayOfWeek + ', ' + dayOfMonth + ' de ' + month + ' de ' + year + ' - ' + hours + ':' + minutes + ':' + seconds;

    var output = icon + ' ' + timeString;
    // Atualize o conteúdo do elemento com id 'clock' com a hora atualizada
    document.getElementById('clock').innerHTML = output;
}

document.addEventListener('DOMContentLoaded', function() {
    // Esta função será executada após o carregamento completo do DOM
    updateClock();

    // Atualize a hora a cada segundo
    setInterval(updateClock, 1000);
});

function updateProgressBar() {

    var div_pdf = document.getElementById('progressBarContainer');
        div_pdf.classList.remove('d-none');
        div_pdf.classList.add('d-block');

}

    function completePdf(path){

        var div_pdf = document.getElementById('progressBarContainer');
        div_pdf.classList.remove('d-block');
        div_pdf.classList.add('d-none');

        var div_pdf = document.getElementById('text-pdf');
        div_pdf.classList.remove('d-none');
        div_pdf.classList.add('d-block');

        document.getElementById('btn-open-pdf').href = '/pdf/view/' + path + '.pdf';
        document.getElementById('btn-download-pdf').href = '/pdf/download/' + path + '.pdf';

    }

    function erroPdf(){

        var text = document.getElementById('text-info');
        var spinner = document.getElementById('spinner');
        spinner.remove();
        text.innerText = 'Houve um erro na geração do PDF!';

    }

// CONFIRMAÇÃO DE DELETE
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // Previne o envio do formulário
            const form = this.closest('.delete-form'); // Localiza o formulário mais próximo

            Swal.fire({
                title: 'Tem certeza?',
                text: "Você não poderá reverter esta ação!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submete o formulário se confirmado
                }
            });
        });
    });
});
