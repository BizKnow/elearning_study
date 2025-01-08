<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions
{

    public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
    {
        if ($this->is_api_request()) {
            header('Content-Type: application/json');
            http_response_code($status_code);
            $CI = &get_instance();
            $CI->output->append_output(json_encode([
                    'status' => 'error',
                    'message' => is_array($message) ? implode(' ', $message) : $message,
                    'code' => $status_code
                ]));
            echo $CI->output->get_output();
            // echo json_encode();
            exit;
        } else {
            parent::show_error($heading, $message, $template, $status_code);
        }
    }

    public function show_exception($exception)
    {
        if ($this->is_api_request()) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $exception->getMessage(),
                'code' => $exception->getCode()
            ]);
            exit;
        } else {
            parent::show_exception($exception);
        }
    }

    public function show_php_error($severity, $message, $filepath, $line)
    {
        if ($this->is_api_request()) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $message,
                'severity' => $severity,
                'filepath' => $filepath,
                'line' => $line
            ]);
            exit;
        } else {
            parent::show_php_error($severity, $message, $filepath, $line);
        }
    }

    private function is_api_request()
    {
        $CI = &get_instance();
        $uri = $CI->uri->segment(1);

        return strpos($uri, 'api') === 0 || $CI->input->is_ajax_request() || $CI->input->get_request_header('Accept') === 'application/json';

        // return isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false;
    }
}
