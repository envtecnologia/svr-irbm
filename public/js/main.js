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
