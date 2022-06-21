<?php

if (!function_exists('replace_format')) {
  function replace_format($content, $format)
  {
    $content = str_replace('{format}', $format, $content);
    return $content;
  }
}
