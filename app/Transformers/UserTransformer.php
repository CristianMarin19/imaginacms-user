<?php

namespace Modules\Iuser\Transformers;

use Imagina\Icore\Transformers\CoreResource;

class UserTransformer extends CoreResource
{
  /**
   * Attribute to exclude relations from transformed data
   * @var array
   */
  protected array $excludeRelations = ['fields'];

  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request):array
  {
      $attributes = [];

      if ($this->resource->relationLoaded('fields')) {
          $translations = [];
          $currentLocale = app()->getLocale();

          foreach ($this->resource->fields as $field) {
              $isMultilang = false;
              $fieldTitle = $field->title;

              foreach ($field->getAttributes() as $locale => $data) {
                  if (is_array($data) && isset($data['value'])) {
                      $translations[$locale][$fieldTitle] = $data['value'];
                      $isMultilang = true;
                  }
              }

              if ($isMultilang) {
                  $attributes[$fieldTitle] = $translations[$currentLocale][$fieldTitle] ?? null;
              } else {
                  $attributes[$fieldTitle] = $field->value;
              }
          }

          $attributes = array_merge($attributes, $translations);
      }

      return $attributes;
  }
}
