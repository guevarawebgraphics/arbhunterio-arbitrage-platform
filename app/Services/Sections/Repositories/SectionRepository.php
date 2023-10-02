<?php

namespace App\Services\Sections\Repositories;

use App\Services\Base\Repository;
use App\Services\Sections\Section;
use App\Services\Attachments\Attachment;
use Illuminate\Support\Collection;

/**
 * Class SectionRepository
 * @package App\Services\Sections\Repositories
 * @author Guevara Web Graphics Studio
 */

class SectionRepository extends Repository implements SectionRepositoryInterface
{
    public function __construct(Collection $sections, Section $model, Attachment $attachment)
    {
        $this->model = $model;
        $this->attachment = $attachment;
        $this->sections = $sections;
    }

    public function render(string $parameters)
    {
        return once(function () use ($parameters) {
            $parameters = explode('.', $parameters);
            $sectionName = array_splice($parameters, 0, 1)[0];
            $section = $this->find($sectionName);
            
            $value = $section;
            $fetchAttachment = current($parameters) === 'data';
            
            foreach ($parameters as $parameter) {
                if ($parameter === 'first')
                    $value = $value[0];
                elseif (is_numeric($parameter))
                    $section = $section[$parameter];
                else {
                    $value = $value->{$parameter};
                    if ($parameter === 'data') {
                        $attachmentFields = array_filter($section->fields, function ($field) {
                            return $field->type === 'attachment';
                        });
                        
                        if (empty($attachmentFields))
                            continue;
                        $result = array_map(function ($item) use ($attachmentFields, $fetchAttachment) {
                            foreach ($attachmentFields as $field) {
                                $alias = isset($field->alias) ? $field->alias : str_slug($field->name);
                                if ($fetchAttachment) {
                                    $attachment = $this->attachment->find($item->$alias);
                                    $item->$alias = $attachment;
                                } else
                                    $item->$alias = "|x|{$item->$alias}|x|";
                            }

                            return $item;
                        }, $value);
                    }
                }
                   
            }

            return new Renderable($value);
        });
    }

    public function find(string $name)
    {
        $sections = $this->sections;
        return once(function () use ($name, $sections) {
            $section = $sections->where('name', $name)->first();

            if (empty($section))
                return $this->model::content($name);
            return json_decode($section->value);
        });
    }

}

class Renderable {
    public $data; 

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function asWhatItIs(){
        return $this->data;
    }

    public function asAttachment()
    {
        return Attachment::find($this->data);
    }

    public function asString()
    {
        return $this->__toString();
    }

    public function __toString(){
        return (string) $this->data;
    }
}
