<?php

namespace basetemplate\Customizer;
class CompanyDetails extends CUSTOMIZER
{
    public string $company_name = 'company_details_company';
    public string $company_ceo = 'company_details_ceo';
    public string $company_street = 'company_details_street';
    public string $company_zipcode = 'company_details_zipcode';
    public string $company_city = 'company_details_city';
    public string $company_phone = 'company_details_phone';
    public string $company_email = 'company_details_email';
    public string $company_homepage_url = 'company_details_homepage';

    protected function define_customizer_fields(): void
    {

        $this->add_customizer_field(
            $this->company_name, [
            $this->field_setting_label => _x('Firmenname', 'Theme customizer', 'basetemplate'),
            $this->field_setting_type => $this->input_type_text,
        ]);

        $this->add_customizer_field(
            $this->company_ceo, [
            $this->field_setting_label => _x('Geschäftsführer', 'Theme customizer', 'basetemplate'),
            $this->field_setting_type => $this->input_type_text,
        ]);

        $this->add_customizer_field(
            $this->company_street, [
            $this->field_setting_label => _x('Straße', 'Theme customizer', 'basetemplate'),
            $this->field_setting_type => $this->input_type_text,
        ]);

        $this->add_customizer_field(
            $this->company_zipcode, [
            $this->field_setting_label => _x('Postleitzahl', 'Theme customizer', 'basetemplate'),
            $this->field_setting_type => $this->input_type_text,
        ]);

        $this->add_customizer_field(
            $this->company_city, [
            $this->field_setting_label => _x('Stadt', 'Theme customizer', 'basetemplate'),
            $this->field_setting_type => $this->input_type_text,
        ]);

        $this->add_customizer_field(
            $this->company_phone, [
            $this->field_setting_label => _x('Telefon', 'Theme customizer', 'basetemplate'),
            $this->field_setting_type => $this->input_type_text,
        ]);

        $this->add_customizer_field(
            $this->company_email, [
            $this->field_setting_label => _x('E-Mail', 'Theme customizer', 'basetemplate'),
            $this->field_setting_type => $this->input_type_email,
        ]);

        $this->add_customizer_field(
            $this->company_homepage_url, [
            $this->field_setting_label => _x('Homepage', 'Theme customizer', 'basetemplate'),
            $this->field_setting_type => $this->input_type_url,
        ]);

    }

    public function get_company_name(): string
    {
        return $this->get_customizer_value($this->company_name);
    }

    public function get_company_ceo(): string
    {
        return $this->get_customizer_value($this->company_ceo);
    }

    public function get_company_street(): string
    {
        return $this->get_customizer_value($this->company_street);
    }

    public function get_company_zipcode(): string
    {
        return $this->get_customizer_value($this->company_zipcode);
    }

    public function get_company_city(): string
    {
        return $this->get_customizer_value($this->company_city);
    }

    public function get_company_phone(): string
    {
        return $this->get_customizer_value($this->company_phone);
    }

    public function get_company_email(): string
    {
        return $this->get_customizer_value($this->company_email);
    }

    public function get_company_homepage_url(): string
    {
        return $this->get_customizer_value($this->company_homepage_url);
    }

}
