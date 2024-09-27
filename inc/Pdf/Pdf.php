<?php

namespace basetemplate\Pdf;

use basetemplate\Ajax\AJAX;
use basetemplate\ThemeWizard;
use Dompdf\Dompdf;
use Dompdf\Options;
use JetBrains\PhpStorm\NoReturn;
use JsonException;

class Pdf extends AJAX
{
    private Options $options;

    /**
     * @hint in this case the constructor is used to set the options for the Dompdf as well as register an ajax endpoint
     * @hint the endpoint is used to generate a pdf from a template triggered by an event defined inside the JavaScript part of the AJAX request
     * */
    public function __construct()
    {
        $this->options = new Options();
        $this->options->set('isHtml5ParserEnabled', true);
        $this->options->set('isRemoteEnabled', true);

        $this->register(
            [
                'generate_pdf' => [$this, 'generate_pdf'],
            ]
        );
    }

    /**
     * @param string $template
     * @param null $meta
     * @return string
     * @description  this method is used to render a template for the pdf
     * @hint the template is a php file that is included and the output is returned
     * @hint templates can be found in the /inc/Pdf/Templates folder
     * */

    public function renderPdfTemplate(string $template, $meta = null): string
    {
        $file_path = ThemeWizard::Helper()->get_template_directory() . '/inc/Pdf/Templates/' . $template . '.php';

        if (!file_exists($file_path)) {
            return 'Template not found';
        }

        ob_start();
        include_once $file_path;
        return ob_get_clean();
    }

    /**
     * @param string|null $template
     * @return void
     * @throws JsonException
     * @description this method is used to generate a pdf from a template
     */
    #[NoReturn] public function generate_pdf(string $template = null): void
    {

        /**
         *@hint meta can be null and defined either in the JavaScript part of the AJAX request, this method OR in the template
         * */

        $meta = $_POST['meta'] ?? null;
        $pdf_name = $meta['pdfname'] ?? 'document';
        $template = $template ?? $meta['template'];

        $pdf = new Dompdf($this->options);

        $html = $this->renderPdfTemplate(
            $template,
            $meta
        );

        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $this->send_json_response(
            [
                'success' => true,
                'pdf_data' => base64_encode($pdf->output()),
                'pdf_name' => $pdf_name . '.pdf'
            ]
        );

        exit;
    }

    /**
     * @param string $template
     * @param string $pdf_name
     * @param null $meta
     * @return string
     * @description this method is used to save a pdf as a temporary file
     * */

    public function save_as_tmp_file(string $template, string $pdf_name, $meta = null): string
    {

        $pdf = new Dompdf($this->options);

        $html = $this->renderPdfTemplate($template, $meta);

        $pdf->loadHtml($html);
        $pdf->setPaper('A4');
        $pdf->render();

        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['path'] . '/' . $pdf_name . '.pdf';

        file_put_contents($file_path, $pdf->output());

        return $file_path;
    }

}