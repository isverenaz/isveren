<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use GuzzleHttp\Client;

class StoreFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'g-recaptcha-response' => 'required',
            // Digər doğrulama qaydalarınızı burada əlavə edin
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->validateRecaptcha()) {
                $validator->errors()->add('g-recaptcha-response', 'Invalid reCAPTCHA');
            }
        });
    }

    protected function validateRecaptcha()
    {
        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $this->input('g-recaptcha-response'),
                'remoteip' => $this->ip(),
            ]
        ]);

        $body = json_decode((string) $response->getBody());
        return $body->success;
    }
}
