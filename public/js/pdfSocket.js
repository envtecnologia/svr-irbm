window.addEventListener("load", function () {
    // Seu código aqui
    // window.Echo.channel('pdf-generation')
    //         .listen('PDFGenerated', (e) => {
    //             completePdf(e.path);
    //         })
    //         .listen('PDFError', () => {
    //             erroPdf();
    //         });
    // window.Echo.channel('job-progress')
    //     .listen('JobProgressUpdate', (event) => {
    //         const progress = event.progress;
    //         updateProgressBar(progress);
    //     });
});

window.addEventListener("load", function () {
    document
        .getElementById("action-button")
        .addEventListener("click", function () {
            event.preventDefault();

            // Pega o formulário search
            var formOriginal = document.querySelector('form[id="search"]');

            // Pega os dados do formulário original
            var formDataSearch = new FormData(formOriginal);

            // Adiciona os dados ao pdfForm
            formDataSearch.forEach((value, key) => {
                // Evitar duplicações e manipulação incorreta
                const existingInput = document.querySelector(
                    `#pdfForm input[name="${key}"]`
                );
                if (existingInput) {
                    existingInput.value = value; // Atualiza o valor se já existe
                } else {
                    const input = document.createElement("input");
                    input.type = "hidden";
                    input.name = key;
                    input.value = value;
                    document.getElementById("pdfForm").appendChild(input);
                }
            });

            for (let [key, value] of formDataSearch.entries()) {
                console.log(`Key: ${key}, Value: ${value}`);
            }

            var form = document.getElementById("pdfForm");
            var formData = new FormData(form);

            var newTab = window.open();

            fetch("/action-button", {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: formData,
            })
                .then((response) => response.blob())
                .then((blob) => {
                    const url = URL.createObjectURL(blob);
                    newTab.location.href = url; // Abre o PDF na nova aba
                })
                .catch((error) => {
                    console.error("Erro ao gerar PDF:", error);
                });
        });
});
