<?php

namespace Tochka\Validators;

use Illuminate\Support\ServiceProvider;

class DocumentValidatorServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $validator = $this->app->make('validator');

        $validator->extend('inn', function ($attribute, $value, $parameters) {
            $type = $parameters[0] ?? null;

            return match ($type) {
                'ip' => DocumentValidator::isInnIp($value),
                'jur' => DocumentValidator::isInnJur($value),
                default => DocumentValidator::isInn($value),
            };

        });

        $validator->extend('fms_code', function ($attribute, $value) {
            return DocumentValidator::isFmsCode($value);
        });
        $validator->extend('passport_code', function ($attribute, $value) {
            return DocumentValidator::isRussianPassportCode($value);
        });

        $validator->extend('passport_serial', function ($attribute, $value) {
            return DocumentValidator::isRussianPassportSerial($value);
        });

        $validator->extend('foreign_passport_serial', function ($attribute, $value) {
            return DocumentValidator::isRussianForeignPassportSerial($value);
        });

        $validator->extend('foreign_passport_code', function ($attribute, $value) {
            return DocumentValidator::isRussianForeignPassportCode($value);
        });

        $validator->extend('residence_permit_serial', function ($attribute, $value) {
            return DocumentValidator::isRussianResidencePermitSerial($value);
        });

        $validator->extend('residence_permit_code', function ($attribute, $value) {
            return DocumentValidator::isRussianResidencePermitCode($value);
        });

        $validator->extend('snils', function($attribute, $value) {
            return DocumentValidator::isSnils($value);
        });

        $validator->extend('inn_or_snils', function ($attribute, $value) {
            return DocumentValidator::isInnOrSnils($value);
        });

    }
}