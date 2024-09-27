'use strict';

const generatePdf = () => {

    const pdfButton = jQuery('.generate-pdf-test-example');
    if (pdfButton.length > 0) {

        pdfButton.on('click', function () {

                const meta = {
                    'content': jQuery('.optional-pdf-content').val() ?? '',
                    'template': 'exampleTemplate'
                }

                jQuery.ajax({
                    url: ajax.url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'generate_pdf',
                        meta: meta
                    },
                    success: function (response) {

                        if (response.success === false) {
                            console.error(response.message);
                        }

                        if (response) {
                            const pdfData = atob(response.pdf_data);
                            const arrayBuffer = new ArrayBuffer(pdfData.length);
                            let uintArray = new Uint8Array(arrayBuffer);
                            for (let i = 0; i < pdfData.length; i++) {
                                uintArray[i] = pdfData.charCodeAt(i);
                            }
                            let blob = new Blob([uintArray], {type: 'application/pdf'});
                            let link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = response.pdf_name;
                            link.click();
                        }
                    }
                });
            }
        )
    }
}


module.exports = {
    generatePdf
}