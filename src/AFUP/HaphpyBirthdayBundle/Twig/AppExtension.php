<?php

namespace AFUP\HaphpyBirthdayBundle\Twig;

/**
 * Twig App extension
 */
class AppExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('file_size', [$this, 'fileSize']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'app_extension';
    }

    /**
     * Format file size in a human readable way
     *
     * @param int     $bytes file size in bytes
     * @param boolean $si    thousands to 1000 or 1024
     *
     * @return string
     */
    public function fileSize($bytes, $si = true)
    {
        $unit = $si ? 1000 : 1024;
        if ($bytes <= $unit) {
            return $bytes." B";
        }
        $exp = intval((log($bytes) / log($unit)));
        $pre = ($si ? "k" : "K").'MGTPE';
        $pre = $pre[$exp - 1].($si ? "" : "i");

        return sprintf("%.1f %sB", $bytes / pow($unit, $exp), $pre);
    }
}
