<?php

namespace basetemplate\Mailer;

use basetemplate\ThemeWizard;

class Mailer
{
    /**
     * @param string $template
     * @param array|null $metaData
     * @return string
     * @hint This function will render a mail template including the header and footer inside the /inc/Mailer/Templates folder
     *
     * @example
     * ThemeWizard::Mailer()->renderMailTemplate(
     *      'helloWorld',
     *      ['content' => 'Hello World']
     * ); // returns 'Hello World'
     *
     */
    private function renderMailTemplate(string $template, array $metaData = null): string
    {
        $file_path = ThemeWizard::Helper()->get_template_directory() . '/inc/Mailer/Templates/' . $template . '.php';

        if (!file_exists($file_path)) {
            return 'Template not found';
        }

        ob_start();

        include ThemeWizard::Helper()->get_template_directory() . '/inc/Mailer/Templates/header.php';
        include $file_path;
        include ThemeWizard::Helper()->get_template_directory() . '/inc/Mailer/Templates/footer.php';

        return ob_get_clean();
    }

    /**
     * @param string $to
     * @param string $subject
     * @param string $template
     * @param array|null $metaData
     * @param array $attachments
     * @param array|null $contentType
     * @return bool
     * @hint This function will send a mail including the rendered template and metadata
     *
     * @example
     * ThemeWizard::Mailer()->send_mail(
     *      'to@example.com',               // to
     *      'Hello World',                  // subject
     *      'helloWorld',                   // template
     *      ['content' => 'Hello World'],   // metaData default null
     *      [],                             // attachments default []
     * ); // returns true
     *
     * */

    public function send_mail(string $to, string $subject, string $template, array $metaData = null, array $attachments = [], array $contentType = null,): bool
    {

        if ($contentType === null) {
            $contentType = ['Content-Type: text/html; charset=UTF-8'];
        }

        return wp_mail(
            $to,
            $subject,
            $this->renderMailTemplate($template, $metaData),
            $contentType,
            $attachments
        );
    }

}