<?php

namespace Tochka\Validators;


class DocumentValidator
{
    /**
     * Проверка ИНН
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function isInn(mixed $value): bool
    {
        if (!is_numeric($value)) {
            return false;
        }
        $len = \strlen($value);
        return match ($len) {
            12 => self::isInnIp($value),
            10 => self::isInnJur($value),
            default => false,
        };
    }

    /**
     * Проверка ИНН ИП
     *
     * @param mixed $value
     *
     * @param bool $easy
     *
     * @return bool
     */
    public static function isInnIp(mixed $value, bool $easy = false): bool
    {
        if (!$easy) {
            if (\strlen($value) != 12 || !is_numeric($value)) {
                return false;
            }
        }

        $s = (7 * $value[0] +
                2 * $value[1] +
                4 * $value[2] +
                10 * $value[3] +
                3 * $value[4] +
                5 * $value[5] +
                9 * $value[6] +
                4 * $value[7] +
                6 * $value[8] +
                8 * $value[9]) % 11;
        if ($s == 10) {
            $s = 0;
        }
        $s2 = (3 * $value[0] +
                7 * $value[1] +
                2 * $value[2] +
                4 * $value[3] +
                10 * $value[4] +
                3 * $value[5] +
                5 * $value[6] +
                9 * $value[7] +
                4 * $value[8] +
                6 * $value[9] +
                8 * $value[10]) % 11;
        if ($s2 == 10) {
            $s2 = 0;
        }
        if ($s != $value[10] || $s2 != $value[11]) {
            return false;
        }

        return true;
    }

    /**
     * Проверка ИНН юр. лица
     *
     * @param mixed $value
     * @param bool $easy
     *
     * @return bool
     */
    public static function isInnJur(mixed $value, bool $easy = false): bool
    {
        if (!$easy) {
            if (\strlen($value) != 10 || !is_numeric($value)) {
                return false;
            }
        }

        $s = (2 * $value[0] +
                4 * $value[1] +
                10 * $value[2] +
                3 * $value[3] +
                5 * $value[4] +
                9 * $value[5] +
                4 * $value[6] +
                6 * $value[7] +
                8 * $value[8]) % 11;
        if ($s == 10) {
            $s = 0;
        }
        if ($s != $value[9]) {
            return false;
        }

        return true;
    }

    /**
     * Проверка Снилс
     *
     * @param mixed $value
     * @param bool $easy
     *
     * @return bool
     */
    public static function isSnils(mixed $value, bool $easy = false): bool
    {
        if(!$easy) {
            if (\strlen($value) !== 11 || !is_numeric($value)) {
                return false;
            }
        }

        $s = 9 * $value[0] +
            8 * $value[1] +
            7 * $value[2] +
            6 * $value[3] +
            5 * $value[4] +
            4 * $value[5] +
            3 * $value[6] +
            2 * $value[7] +
            $value[8];
        if ($s >= 101) {
            $s = $s % 101;
        }
        if ($s == 100 || $s == 0) {
            $s = '00';
        }

        return $s == substr($value, -2);
    }

    /**
     * Проверяет код ФНС
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function isFmsCode(mixed $value): bool
    {
        return preg_match('/^\d{3}\-\d{3}$/', $value);
    }

    /**
     * Проверяем серию паспорта РФ
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function isRussianPassportSerial(mixed $value): bool
    {
        return is_numeric($value) && \strlen($value) === 4;
    }

    /**
     * Проверяем код паспорта РФ
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function isRussianPassportCode(mixed $value): bool
    {
        return is_numeric($value) && \strlen($value) === 6;
    }

    /**
     * Проверяем серию загранпаспорта РФ
     *
     * @param $value
     *
     * @return bool
     */
    public static function isRussianForeignPassportSerial(mixed $value): bool
    {
        return is_numeric($value) && \strlen($value) === 2;
    }

    /**
     * Проверяем код загранпаспорта РФ
     *
     * @param $value
     *
     * @return bool
     */
    public static function isRussianForeignPassportCode(mixed $value): bool
    {
        return is_numeric($value) && \strlen($value) === 7;
    }

    /**
     * Проверяем серия вида на жительства
     *
     * @param $value
     *
     * @return bool
     */
    public static function isRussianResidencePermitSerial(mixed $value): bool
    {
        return is_numeric($value) && \strlen($value) === 2;
    }

    /**
     * Проверяем код вида на жительства
     *
     * @param $value
     *
     * @return bool
     */
    public static function isRussianResidencePermitCode(mixed $value): bool
    {
        return is_numeric($value) && \strlen($value) === 7;
    }

    public static function isInnOrSnils(string|int $value): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        $length = \strlen($value);
        return match ($length) {
            10 => self::isInnJur($value, true),
            12 => self::isInnIp($value, true),
            11 => self::isSnils($value),
            default => false,
        };
    }
}