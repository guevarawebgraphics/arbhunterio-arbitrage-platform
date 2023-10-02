<?php

namespace App\Services\Contacts\Repositories;

use App\Services\Base\Repository;
use App\Services\Contacts\Contact;
use App\Http\Traits\SystemSettingTrait;
use File;
use Mail;

/**
 * Class ContactRepository
 * @package App\Services\Contacts\Repositories
 * @author Guevara Web Graphics Studio
 */

class ContactRepository extends Repository implements ContactRepositoryInterface
{
    use SystemSettingTrait;
    public function __construct(Contact $model)
    {
        $this->model = $model;
    }

    public function fetchContacts() 
    {
        return $this->model->all();
    }

    public function addContact(array $data) 
    {
        return $this->create($data);
    }

    public function sendEmail(array $params) 
    {
        if (isset($params)) {
            $system_setting_name = $this->getSystemSettingByCode('BJCDL_001');
            $system_setting_email = $this->getSystemSettingByCode('BJCDL_003');
            $is_admin = isset($params['is_admin']) && $params['is_admin'];

            $data = [
                'type' => $params['type'],
                'subject' => $params['subject'],
                'user' => [
                    'name' => $params['user']['name'],
                    'email' => $params['user']['email']
                ],
                'user_data' => $params['user_data'],
                'attachments' => $params['attachments']
            ];

            Mail::send($params['view'], compact('data'), function ($message) use ($data, $system_setting_name, $system_setting_email, $is_admin) {
                $message->bcc(config('constants.mycms_bcc'));
                if ($is_admin) {
                    $message->from(/*$system_setting_email->value*/config('constants.no_reply_email'), $system_setting_name->value);
                    $message->to($system_setting_email->value, $system_setting_name->value);
                } else {
                    $message->from(/*$system_setting_email->value*/config('constants.no_reply_email'), $system_setting_name->value);
                    $message->to($data['user']['email'], $data['user']['name']);
                }
                $message->subject($data['subject']);
                if (isset($data['attachments']) && count($data['attachments'])) {
                    foreach ($data['attachments'] as $attachment) {
                        if (File::exists($attachment)) {
                            $message->attach($attachment);
                        }
                    }
                }
            });
        
        }
    }
}
