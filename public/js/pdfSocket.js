window.addEventListener('load', function() {
    // Seu código aqui
    window.Echo.channel('pdf-generation')
            .listen('PDFGenerated', (e) => {
                completePdf(e.path);
            });

    // window.Echo.channel('job-progress')
    //     .listen('JobProgressUpdate', (event) => {
    //         const progress = event.progress;
    //         updateProgressBar(progress);
    //     });
});
